<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{


    public function index()
    {
        try {
            $data = Subscription::get();
            return view('subscription.index', compact('data'));
        } catch (\Exception $e) {

            Toastr::error(__("common.Something Went Wrong"));
            return back();
        }
    }

    public function create()
    {
        return view('subscription.create');
    }

    public function store(Request $request)
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
            $file = $request->file('banner');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/subscription_banners'), $filename);
            $validated['banner'] = 'uploads/subscription_banners/' . $filename;
        }

        try {
            Subscription::create($validated);

            Toastr::success('Subscription Create Successful', __('common.Success'));
            return redirect()->route('subscriptions.index');
        } catch (\Exception $e) {

            return back();
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
