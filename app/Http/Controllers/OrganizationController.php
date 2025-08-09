<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Subscription;
use App\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    public function index()
    {
        try {
            $organizations = Organization::get();
            return view('organization.index', compact('organizations'));
        } catch (\Exception $e) {

            Toastr::error(__("common.Something Went Wrong"));
            return back();
        }
    }

    public function create()
    {

        $subscriptions = Subscription::all()->mapWithKeys(function ($sub) {
            if ($sub->offer_price && $sub->offer_price < $sub->price) {
                $priceText = '৳' . number_format($sub->offer_price, 2) . ' (was ৳' . number_format($sub->price, 2) . ')';
            } else {
                $priceText = '৳' . number_format($sub->price, 2);
            }

            return [$sub->id => $sub->name . ' - ' . $priceText];
        });

        return view('organization.create', compact('subscriptions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:255',
            'address'           => 'nullable|string|max:500',
            'phone'             => 'nullable|string|max:20',
            'description'       => 'nullable|string',
            'user_name'         => 'required|string|max:255',
            'user_email'        => 'required|email|unique:users,email',
            'password'          => 'required|string|min:8',
            'avatar'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'subscription_id'   => 'required|exists:subscriptions,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        DB::beginTransaction();

        try {
            $organization = Organization::create([
                'name'          => $data['name'],
                'description'   => $data['description'],
                'address'       => $data['address'],
                'phone'         => $data['phone'],
                'start_date'    => Carbon::now(),
                'end_date'      => Carbon::now()->addDays(7),
                'created_by'    => Auth::id()
            ]);

            $userData = [
                'organization_id'   => $organization->id,
                'name'              => $data['user_name'],
                'email'             => $data['user_email'],
                'role_id'           => 2,
                'password'          => Hash::make($data['password']),
            ];

            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/user'), $filename);
                $userData['avatar'] = 'uploads/user/' . $filename;
            }

            $user = User::create($userData);
            $user->assignRole('Admin');

            DB::commit();

            Toastr::success('Organization created successfully', __('common.Success'));
            return redirect()->route('organizations.index');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function edit(Subscription $subscription)
    {
        return view('subscription.edit', compact('subscription'));
    }

    public function show(Subscription $subscription)
    {
        return view('subscription.show', compact('subscription'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'offer_price' => 'nullable|numeric|min:0|lt:price',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|max:1500',
            'status' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        if ($request->hasFile('banner')) {
            // Delete old banner if exists
            if ($subscription->banner && file_exists(public_path($subscription->banner))) {
                unlink(public_path($subscription->banner));
            }

            $file = $request->file('banner');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/subscription_banners'), $filename);
            $validated['banner'] = 'uploads/subscription_banners/' . $filename;
        }

        try {
            $subscription->update($validated);
            Toastr::success('Subscription updated successfully', __('common.Success'));
            return redirect()->route('subscriptions.index');
        } catch (\Exception $e) {
            // Log error if necessary: \Log::error($e->getMessage());
            return back()->with('error', 'Failed to update subscription. Please try again.');
        }
    }

    public function destroy(Subscription $subscription)
    {
        try {
            if ($subscription->banner && file_exists(public_path($subscription->banner))) {
                unlink(public_path($subscription->banner));
            }

            $delete = $subscription->delete();

            if ($delete) {
                Toastr::success('Subscription Delete Successful', __('common.Success'));
            } else {
                Toastr::error('Something is Wrong');
            }
            return redirect()->back();
        } catch (\Exception $e) {

            return redirect()->back();
        }
    }
}
