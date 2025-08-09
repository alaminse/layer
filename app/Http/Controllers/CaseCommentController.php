<?php

namespace App\Http\Controllers;

use App\Jobs\CaseDateUpdateMailJob;
use App\Jobs\NewCommentMailJob;
use App\Models\CaseComment;
use App\Models\Cases;
use App\Models\CaseStaff;
use App\Models\Client;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CaseCommentFile;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\CaseCommentRequest;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class CaseCommentController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(CaseCommentRequest $request)
    {
        // return $request->all();
        $case = Cases::findOrFail($request->case_id);       
        $comment = new CaseComment;
        $comment->case_id = $case->id;
        $comment->comments = $request->comments;
        $comment->staff_id = auth()->user()->id;
        $comment->save();
        if ($request->file) {
            foreach ($request->file as $file) {
                $this->storeFile($file, $comment->id);
            }
        }
        
        $case->update(['last_action'=>date('Y-m-d H:i:s')]);

        $staffs = CaseStaff::where('case_id', $case->id)->where('staff_id', '!=', auth()->user()->id)->with('user')->get();


        foreach($staffs as $staff){
            if($staff->user && $staff->user->email){
                dispatch(new NewCommentMailJob($staff->user->email, $case, $comment, auth()->user()->name));
            }
        }


        $admins = User::where('role_id', 1)->where('id', '!=', auth()->user()->id)->get();

        foreach($admins as $admin){
            if($admin->email){
                dispatch(new NewCommentMailJob($admin->email, $case, $comment, auth()->user()->name));
            }

        }

        if(auth()->user()->role_id != 0){
            if ($case->layout==2) {
                $client = Client::findOrFail($case->client_id);
            } else {
                if($case->client == 'Plaintiff') {
                    $client = Client::findOrFail($case->plaintiff);
                } elseif($case->client_id) {
                    $client = Client::findOrFail($case->client_id);
                } else {
                    $client = Client::findOrFail($case->opposite);
                }
            }
            if ($client->email) {
                if($client->email){
                    dispatch(new NewCommentMailJob($client->email, $case, $comment, auth()->user()->name));
                }

            }
        }

        Toastr::success(__('common.Operation Successful'));
        if (auth()->user()->role_id ==0) {
            return redirect()->route('client.case.show', [$request->case_id]);
        } else {
            return redirect()->route('case.show', [$request->case_id]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $comment = CaseComment::findOrFail($id);
        $case_id = $comment->case_id;
        if (auth()->user()->role_id ==1) {
            $comment->delete();
        }


        $response = [
            'message' => __('common.Successfully deleted'),
        ];
        if (auth()->user()->role_id ==0) {
            $response['goto'] = route('client.case.show', $case_id);
        } else {
            $response['goto'] = route('case.show', $case_id);
        }

        return response()->json($response);
    }
    public function fileDestroy($uuid)
    {

        $file = CaseCommentFile::with('comment')->where('uuid', $uuid)->first();

        if (!$file) {
            throw ValidationException::withMessages(['message' => __('common.Something Went Wrong')]);
        }
        if (\Illuminate\Support\Facades\File::exists($file->filepath)) {
            \Illuminate\Support\Facades\File::delete($file->filepath);
        }

        $case_id = $file->comment->case_id;
        if (auth()->user()->role_id ==1 || $file->comment->staff_id == auth()->user()->id) {
            $file->delete();
        }

        $response = [
            'message' => __('common.Successfully deleted')
        ];

        if (auth()->user()->role_id ==0) {
            $response['goto'] = route('client.case.show', $case_id);
        } else {
            $response['goto'] = route('case.show', $case_id);
        }

        return response()->json($response);

    }
    public function fileShow($uuid)
    {
        $file = CaseCommentFile::where('uuid', $uuid)->first();
        $type = "comment";
        return view('file.show', compact('file', 'type'));
    }

    public function storeFile($file, $comment_id)
    {
        if (!$file) {
            return;
        }
        if (!file_exists('public/uploads/case-file')) {
            mkdir('public/uploads/case-file', 0777, true);
        }

        $fileName = time() . '-' . uniqid('infix-') . '.' . $file->getClientOriginalExtension();
        $file->move('public/uploads/case-file/', $fileName);
        $path = 'public/uploads/case-file/' . $fileName;
        $image_url = asset($path);

        $upload = new CaseCommentFile();
        $upload->uuid = Str::uuid();
        $upload->case_comment_id = $comment_id;
        $upload->user_filename = $file->getClientOriginalName();
        $upload->filename = $image_url;
        $upload->filepath = $path;
        $upload->file_type = $file->getClientMimeType();
        $upload->save();
    }
}
