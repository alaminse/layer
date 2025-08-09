<?php

namespace App\Http\Controllers;

use App\User;
use App\Staff;
use Exception;
use Carbon\Carbon;
use App\Models\Act;
use App\Models\Cases;
use App\Models\Court;
use App\Models\Stage;

use App\Models\Client;
use App\Models\Lawyer;
use App\Models\Upload;
use App\Models\CaseAct;
use App\Models\CaseCourt;
use App\Models\CaseStaff;
use App\Traits\ImageStore;
use App\Models\CommentRead;
use App\Models\HearingDate;
use App\Models\CaseCategory;
use App\Traits\CustomFields;
use Illuminate\Http\Request;
use App\Models\CourtCategory;
use App\Models\ClientCategory;
use App\Jobs\CaseAssignMailJob;
use App\Models\CaseCategoryLog;
use App\Models\CaseParticipant;
use App\Models\CaseSubCategory;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Setting\Entities\Config;
use Modules\CasePrint\Entities\PrintLayout;
use Modules\ClientLogin\Entities\ClientCase;
use Illuminate\Validation\ValidationException;
use Modules\EmailtoCL\Jobs\SendMailToLawyerJob;
use Modules\ClientLogin\Entities\ClientCaseUpload;

class CaseController extends Controller
{
    use ImageStore, CustomFields;

    public function __construct()
    {
        $this->middleware('limit:case')->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $caseAccess = false;
        $caseIds = [];

        if (!permissionCheck('all-case')) {
            $caseAccess = true;
            $caseIds = CaseStaff::where('staff_id', auth()->user()->id)->pluck('case_id')->toArray();
        }

        $models = Cases::when(moduleStatusCheck('ClientLogin'), function ($query) {
            $query->whereNotIn('status', ['Pending']);
        })
            ->when($caseAccess, function ($query) use ($caseIds) {
                $query->whereIn('id', $caseIds);
            })->get();

        $page_title = 'All';
        if ($request->status and $request->status == 'Archieved') {

            $page_title = 'Archieved';
        } else if ($request->status and $request->status == 'Waiting') {

            $page_title = 'Waiting';
        } else if ($request->status and $request->status == 'Running') {

            $page_title = 'Running';
        }
        if (moduleStatusCheck('ClientLogin') && $request->status && $request->status == 'Pending') {

            $page_title = 'Pending';
        }
        $status = $request->status;
        $staffs = User::whereNotIn('role_id', [1, 0])
            ->where('id', '!=', auth()->user()->id)->get()
            ->pluck('name', 'id');
        return view('case.index', compact('page_title', 'status', 'staffs'));
    }
    public function pendingCase()
    {
        $models = [];
        if (moduleStatusCheck('ClientLogin')) {
            $models = ClientCase::whereIn('status', ['Pending'])->get();
        }

        $page_title = 'Pending';
        return view('case.pending-case', compact('models', 'page_title'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data['clients'] = Client::when(moduleStatusCheck('ClientLogin'), function ($query) {
            $query->where('status', 'active');
        })->get()->pluck('name_type', 'id');
        $data['client_categories'] = ClientCategory::all()->pluck('name', 'id')->prepend(__('client.Select Category'), '');
        $data['staffs'] = User::whereNotIn('role_id', [1, 0])
            ->where('id', '!=', auth()->user()->id)->get()
            ->pluck('name', 'id');
        $data['stages'] = Stage::all()->pluck('name', 'id')->prepend(__('case.Select Case Stage'), '');
        $data['case_categories'] = CaseCategory::all()->pluck('name', 'id')->prepend(__('case.Select Case Categories'), '');
        $data['case_sub_categories'] = CaseSubCategory::all()->pluck('name', 'id');
        $data['court_categories'] = CourtCategory::all()->pluck('name', 'id')->prepend(__('case.Select Court Categories'), '');
        $data['lawyers'] = Lawyer::all()->pluck('name', 'id');
        $data['acts'] = Act::all()->pluck('name', 'id');
        $data['courts'] = ['' => __('case.Select Court')];

        $fields = null;

        if (moduleStatusCheck('CustomField')) {
            $fields = getFieldByType('case');
        }
        $config = Config::first();
        if (getConfigValueByKey($config, 'case_layout') == 2) {
            return view('case.create_case_layout_2', compact('data', 'fields'));
        }
        return view('case.create', compact('data', 'fields'));
    }

    public function store(Request $request)
    {

        if (!$request->json()) {
            abort(404);
        }
        $layout = config('configs.case_layout', 2);

        $validate_rules = [
            'case_category_id' => 'required|integer',
            'case_no' => 'sometimes|nullable|string',
            'file_no' => 'sometimes|nullable|string|max:20',
            'acts*' => 'required|integer',

            'court_category_id' => 'required|integer',
            'court_id' => 'required|integer',
            'lawyer_id*' => 'sometimes|nullable|integer',
            'stage_id' => 'sometimes|nullable|integer',
            'case_charge' => 'sometimes|nullable|numeric',
            'receiving_date' => 'sometimes|nullable|date',
            'filling_date' => 'sometimes|nullable|date',
            'hearing_date' => 'required_with:hearing_date_yes|nullable|date',
            'hearing_date_description' => 'required_with:hearing_date_yes|nullable|string',
            'judgement_date' => 'required_with:judgement_date_yes|nullable|date',
            'judgement' => 'required_with:judgement_date_yes|nullable|string',
            'description' => 'sometimes|nullable|string',
            'file.*' => 'sometimes|nullable|mimes:jpg,bmp,png,doc,docx,pdf,jpeg,txt',
        ];

        if ($layout == 1) {
            $validate_rules += [
                'plaintiff' => 'required|integer',
                'opposite' => 'required|integer',
                'client_category_id' => 'required|integer',
            ];
        } elseif ($layout == 2) {
            $validate_rules += [
                'plaintiff' => 'sometimes|nullable|integer',
                'opposite' => 'sometimes|nullable|integer',
                'client_id' => 'required|integer',
                'client_category_id' => 'sometimes|nullable|integer',
                'type' => 'required|string',
            ];
        }
        if (moduleStatusCheck('CustomField')) {
            $validate_rules = array_merge($validate_rules, $this->generateValidateRules('case'));
        }

        $request->validate($validate_rules, validationMessage($validate_rules));

        if ($request->plaintiff == $request->opposite && $layout == 1) {
            throw ValidationException::withMessages(['plaintiff' => __('case.Plaintiff can not be opposite')]);
        }

        try {

            $serial = Cases::max('serial_no') + 1;


            $hearing_date = null;
            $filling_date = null;

            $receiving_date = null;
            $judgement_date = null;

            if ($request->hearing_date_yes) {
                $hearing_date = date_format(date_create($request->hearing_date), 'Y-m-d H:i:s');
            }
            if ($request->filling_date_yes) {
                $filling_date = date_format(date_create($request->filling_date), 'Y-m-d H:i:s');
            }

            if ($request->receiving_date_yes) {
                $receiving_date = date_format(date_create($request->receiving_date), 'Y-m-d H:i:s');
            }

            if ($request->judgement_date_yes) {
                $judgement_date = date_format(date_create($request->judgement_date), 'Y-m-d H:i:s');
            }
            $title = $request->title;
            $client = $request->type == 'petitioner' ? 'Plaintiff' : 'Opposite';
            if ($layout == 1) {
                $plaintiff = Client::find($request->plaintiff);
                $opposite = Client::find($request->opposite);
                $title = $plaintiff->name . ' v/s ' . $opposite->name;
                $client_category = ClientCategory::find($request->client_category_id);
                $client = $client_category->plaintiff ? 'Plaintiff' : 'Opposite';
            }

            $model = new Cases();
            $model->title = $title;
            $model->last_action = date('Y-m-d H:i:s');
            $model->client = $client;

            if ($request->judgement_date_yes) {
                $model->judgement_status = 'Judgement';
                $model->status = 'Judgement';
                $model->judgement_date = $judgement_date;
                $model->judgement = $request->judgement;
            } else {
                $model->status = 'Open';
            }

            $model->serial_no = $serial;
            $model->case_category_id = $request->case_category_id;
            $model->case_no = $request->case_no;
            $model->file_no = $request->file_no;
            $model->plaintiff = $request->plaintiff;
            $model->case_charge = $request->case_charge;
            $model->opposite = $request->opposite;
            $model->client_category_id = $request->client_category_id;
            $model->court_category_id = $request->court_category_id;
            $model->court_id = $request->court_id;
            $model->ref_name = $request->ref_name;
            $model->ref_mobile = $request->ref_mobile;
            $model->stage_id = $request->stage_id;
            $model->receiving_date = $receiving_date;
            $model->filling_date = $filling_date;
            $model->hearing_date = $hearing_date;
            $model->description = $request->description;
            $model->layout = $layout;
            $model->created_by = auth()->user()->id;
            if ($layout == 1) {
                if ($client_category->plaintiff) {
                    $model->client_type = 'petitioner';
                    $model->client_id = $request->plaintiff;
                } else {
                    $model->client_type = 'respondent';
                    $model->client_id = $request->opposite;
                }
            } elseif ($layout == 2) {
                $model->client_type = $request->type;
                $model->client_id = $request->client_id;
            }
            $model->save();

            if (moduleStatusCheck('CustomField')) {
                $this->storeFields($model, $request->custom_field, 'case');
            }
            if (auth()->user()->role_id != 1) {
                CaseStaff::firstOrCreate([
                    'case_id' => $model->id,
                    'staff_id' => auth()->user()->id,
                ]);
            }
            if ($layout == 2) {
                if (!empty($request->p_r_name)) {
                    foreach ($request->p_r_name as $key => $name) {
                        $this->storeCaseParticipant($model->id, $name, $request->p_r_advocate[$key] ?? '');
                    }
                }
                if (!empty($request->staff_ids)) {
                    foreach ($request->staff_ids as $staff) {
                        $caseStaff = new CaseStaff();
                        $caseStaff->staff_id = $staff;
                        $caseStaff->case_id = $model->id;
                        $caseStaff->save();
                    }
                }
            } elseif ($layout == 1) {
                if ($client_category->plaintiff) {
                    $this->storeCaseParticipant($model->id, $opposite->name);
                } else {
                    $this->storeCaseParticipant($model->id, $plaintiff->name);
                }
            }

            if (!$request->file_no) {
                $file_no = str_pad($model->id, 4, '0', STR_PAD_LEFT);
                $model->file_no = $file_no;
                $model->save();
            }

            if ($request->acts and count($request->acts) > 0) {
                foreach ($request->acts as $value) {
                    $act = new CaseAct();
                    $act->acts_id = $value;
                    $act->cases_id = $model->id;
                    $act->save();
                }
            }

            if ($request->lawyer_id and count($request->lawyer_id) > 0) {
                foreach ($request->lawyer_id as $lawyer) {
                    $lawyer = Lawyer::find($lawyer);
                    if ($lawyer) {
                        DB::table('cases_lawyer')
                            ->insert([
                                'cases_id' => $model->id,
                                'lawyer_id' => $lawyer->id,
                                'created_at' => Carbon::now(),
                            ]);

                        if ($lawyer->email and $request->send_email_to_lawyer and moduleStatusCheck('EmailtoCL')) {
                            dispatch(new SendMailToLawyerJob($lawyer, $model));
                        }
                    }

                }
            }

            if ($request->hearing_date_yes) {
                $date = new HearingDate();
                $date->cases_id = $model->id;
                $date->stage_id = $request->stage_id;
                $date->date = $hearing_date;
                $date->description = $request->hearing_date_description;
                $date->save();
            }

            if ($request->judgement_date_yes) {
                $date = new HearingDate();
                $date->cases_id = $model->id;
                $date->date = $judgement_date;
                $date->description = $request->judgement;
                $date->type = 'judgement';
                $date->save();
            }
            if (moduleStatusCheck('ClientLogin') && $request->client_case_id) {
                $clientFiles = ClientCaseUpload::where('client_case_id', $request->client_case_id)->get();
                foreach ($clientFiles as $caseFile) {
                    $upload = new Upload();
                    $upload->uuid = $caseFile->uuid;
                    $upload->user_id = auth()->user()->id;
                    $upload->case_id = $model->id;
                    $upload->user_filename = $caseFile->user_filename;
                    $upload->filename = $caseFile->filename;
                    $upload->filepath = $caseFile->filepath;
                    $upload->file_type = $caseFile->file_type;
                    $upload->save();
                }
                ClientCase::where('id', $request->client_case_id)->update([
                    'status' => 'approved',
                    'converted_id' => $model->id,
                ]);

                $model->from = 'client';
                $model->save();
            }
            if ($request->file) {
                foreach ($request->file as $file) {
                    $this->storeFile($file, $model->id);
                }
            }

            $response = [
                'goto' => route('case.show', $model->id),
                'model' => $model,
                'message' => __('case.Case Added Successfully'),
            ];

            return response()->json($response);

        } catch (Exception $e) {
            throw ValidationException::withMessages(['message' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        self::authorizeToCase($id);

        $model = Cases::with('acts', 'hearing_dates', 'comments.read');
        if (moduleStatusCheck('Finance')) {
            $model->with('transactions', 'invoices');
        }


        $layouts = null;
        if (moduleStatusCheck('CasePrint')) {
            $layouts = PrintLayout::all()->pluck('title', 'id');
        }

        $model = $model->findOrFail($id);
//        dd($model->comments);
        $staffs = User::whereNotIn('role_id', [1, 0])
            ->where('id', '!=', auth()->user()->id)->get()
            ->pluck('name', 'id');
        if (request()->print) {
            return view('case.print', compact('model'));
        }

        $comment_ids = $model->comments->where('staff_id', '!=', auth()->id())->pluck('id')->toArray();

        foreach($comment_ids as $comment_id){
            CommentRead::updateOrCreate([
                'case_comment_id' => $comment_id,
                'user_id' => auth()->id(),
            ], [
                'read_at' => Carbon::now()
            ]);
        }

        return view('case.show', compact('model', 'layouts', 'staffs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        self::authorizeToCase($id);
        $model = Cases::with('acts')->findOrFail($id);
        $data['clients'] = Client::when(moduleStatusCheck('ClientLogin'), function ($query) {
            $query->where('status', 'active');
        })->get()->pluck('name', 'id');
        $data['client_categories'] = ClientCategory::all()->pluck('name', 'id')->prepend(__('client.Select Category'), '');
        $data['stages'] = Stage::all()->pluck('name', 'id')->prepend(__('case.Select Case Stage'), '');
        $data['case_categories'] = CaseCategory::all()->pluck('name', 'id')->prepend(__('case.Select Case Categories'), '');
        $data['court_categories'] = CourtCategory::all()->pluck('name', 'id')->prepend(__('case.Select Court Categories'), '');
        $data['lawyers'] = Lawyer::all()->pluck('name', 'id')->prepend(__('case.Select Lawyer'), '');
        $data['courts'] = Court::where('court_category_id', $model->court_category_id)->pluck('name', 'id')->prepend(__('case.Select Court'), '');
        $data['acts'] = Act::all()->pluck('name', 'id');
        $data['selected_acts'] = $model->acts()->pluck('acts_id');

        $data['staffs'] = User::whereNotIn('role_id', [1, 0])
            ->where('id', '!=', auth()->user()->id)->get()
            ->pluck('name', 'id');
        $data['selected_staffs'] = $model->caseStaffs()->pluck('staff_id');
        $fields = null;

        if (moduleStatusCheck('CustomField')) {
            $fields = getFieldByType('case');
        }
        if ($model->layout == 2) {
            return view('case.edit_case_layout_02', compact('model', 'data', 'fields'));
        }
        return view('case.edit', compact('model', 'data', 'fields'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        if (!$request->json()) {
            abort(404);
        }
        $model = Cases::findOrFail($id);
        $layout = $model->layout;
        $validate_rules = [
            'case_category_id' => 'required|integer',
            'case_no' => 'sometimes|nullable|string',
            'file_no' => 'sometimes|nullable|string|max:20',
            'acts*' => 'required|integer',

            'court_category_id' => 'required|integer',
            'court_id' => 'required|integer',
            'stage_id' => 'sometimes|nullable|integer',
            'case_charge' => 'sometimes|nullable|numeric',
            'receiving_date' => 'sometimes|nullable|date',
            'filling_date' => 'sometimes|nullable|date',
            'hearing_date' => 'sometimes|nullable|date',
            'judgement_date' => 'sometimes|nullable|date',
            'description' => 'sometimes|nullable|string',
            'file.*' => 'sometimes|nullable|mimes:jpg,bmp,png,doc,docx,pdf,jpeg,txt',
        ];
        if ($layout == 1) {
            $validate_rules += [
                'plaintiff' => 'required|integer',
                'opposite' => 'required|integer',
                'client_category_id' => 'required|integer',
            ];
        } elseif ($layout == 2) {
            $validate_rules += [
                'plaintiff' => 'sometimes|nullable|integer',
                'opposite' => 'sometimes|nullable|integer',
                'client_id' => 'required|integer',
                'client_category_id' => 'sometimes|nullable|integer',
                'type' => 'required|string',
            ];
        }
        if (moduleStatusCheck('CustomField')) {
            $validate_rules = array_merge($validate_rules, $this->generateValidateRules('case'));
        }
        $request->validate($validate_rules, validationMessage($validate_rules));

        $filling_date = null;
        $receiving_date = null;

        if ($request->filling_date_yes) {
            $filling_date = date_format(date_create($request->filling_date), 'Y-m-d H:i:s');
        }

        if ($request->plaintiff == $request->opposite && $model->layout == 1) {
            Toastr::error(__('case.Plaintiff can not be opposite'));
            throw ValidationException::withMessages(['plaintiff' => __('case.Plaintiff can not be opposite')]);
        }
        if ($request->receiving_date_yes) {
            $receiving_date = date_format(date_create($request->receiving_date), 'Y-m-d H:i:s');
        }

        $title = $request->title;
        $client =
        $client = $request->type == 'petitioner' ? 'Plaintiff' : 'Opposite';
        if ($layout == 1) {
            $plaintiff = Client::find($request->plaintiff);
            $opposite = Client::find($request->opposite);
            $title = $plaintiff->name . ' v/s ' . $opposite->name;
            $client_category = ClientCategory::find($request->client_category_id);
            $client = $client_category->plaintiff ? 'Plaintiff' : 'Opposite';
        }

        $model->title = $title;
        $model->client = $client;
        $model->case_category_id = $request->case_category_id;
        $model->case_no = $request->case_no;
        $model->file_no = $request->file_no;
        $model->plaintiff = $request->plaintiff;
        $model->case_charge = $request->case_charge;
        $model->opposite = $request->opposite;
        $model->client_category_id = $request->client_category_id;
        $model->court_category_id = $request->court_category_id;
        $model->court_id = $request->court_id;
        $model->ref_name = $request->ref_name;
        $model->ref_mobile = $request->ref_mobile;
        $model->stage_id = $request->stage_id;
        $model->receiving_date = $receiving_date;
        $model->filling_date = $filling_date;
        $model->description = $request->description;
        if ($layout == 1) {
            if ($client_category->plaintiff) {
                $model->client_type = 'petitioner';
                $model->client_id = $request->plaintiff;
            } else {
                $model->client_type = 'respondent';
                $model->client_id = $request->opposite;
            }
        } elseif ($layout == 2) {
            $model->client_type = $request->type;
            $model->client_id = $request->client_id;
        }
        $model->save();

        if (moduleStatusCheck('CustomField')) {
            $this->storeFields($model, $request->custom_field, 'case');
        }

        if ($request->acts and count($request->acts) > 0) {
            CaseAct::where('cases_id', $model->id)->delete();
            foreach ($request->acts as $value) {
                $act = new CaseAct();
                $act->acts_id = $value;
                $act->cases_id = $model->id;
                $act->save();
            }
        }

        if ($layout == 2) {
            CaseParticipant::where('case_id', $id)->delete();
            CaseStaff::where('case_id', $id)->delete();
            if (!empty($request->p_r_name)) {
                foreach ($request->p_r_name as $key => $name) {
                    $this->storeCaseParticipant($model->id, $name, $request->p_r_advocate[$key] ?? '');
                }
            }
            if (!empty($request->staff_ids)) {
                foreach ($request->staff_ids as $staff) {
                    $caseStaff = new CaseStaff();
                    $caseStaff->staff_id = $staff;
                    $caseStaff->case_id = $model->id;
                    $caseStaff->save();
                }
            }
        } elseif ($layout == 1) {
            if ($client_category->plaintiff) {
                $this->storeCaseParticipant($model->id, $opposite->name);
            } else {
                $this->storeCaseParticipant($model->id, $plaintiff->name);
            }
        }
        $response = [
            'message' => __('case.Case Updated Successfully'),
            'goto' => route('case.show', $model->id),
        ];

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @return void
     * @throws ValidationException
     */
    public function destroy(Request $request, $id)
    {
        if (!$request->json()) {
            abort(404);
        }

        $model = Cases::with('tasks')->find($id);
        if (!$model) {
            throw ValidationException::withMessages(['message' => __('case.Case Not Found')]);
        }

        if ($model->tasks->count()) {
            throw ValidationException::withMessages(['message' => __('case.Case is assigned with tasks')]);
        }

        if (moduleStatusCheck('CustomField')) {
            $model->load('invoices');
            if ($model->invoices->count()) {
                throw ValidationException::withMessages(['message' => __('case.Case is assigned with invoices')]);
            }
        }

        if (moduleStatusCheck('CustomField')) {
            $model->load('customFields');
            $model->customFields()->delete();
        }

        $model->delete();

        return response()->json(['message' => __('case.Case Deleted Successfully'), 'goto' => route('case.index')]);
    }

    public function causelist(Request $request)
    {
        $data['models'] = Cases::where(['status' => 'Open'])->orWhereIn('judgement_status', ['Open', 'Reopen']);
        if ($request->start_date) {
            $data['start_date'] = getFormatedDate($request->start_date, true);
            $data['models'] = $data['models']->whereDate('hearing_date', '>=', $data['start_date']);
        }

        if ($request->end_date) {
            $data['end_date'] = getFormatedDate($request->end_date, true);
            $data['models'] = $data['models']->whereDate('hearing_date', '<=', $data['end_date']);
        }

        $data['models'] = $data['models']->get();
        $data['staffs'] = User::whereNotIn('role_id', [1, 0])
            ->where('id', '!=', auth()->user()->id)->get()
            ->pluck('name', 'id');
        if ($request->ajax()) {
            return view('case.causelist_data', $data);
        }

        return view('case.causelist', $data);
    }

    public function category_change($id)
    {
        $model = Cases::FindOrFail($id);
        $category = CaseCategory::all()->pluck('name', 'id')->prepend(__('case.Select Case Category'), '');
        return view('case.category-change', compact('model', 'category'));
    }

    public function category_store(Request $request)
    {
        $model = Cases::FindOrFail($request->id);
        $category = CaseCategory::FindOrFail($model->case_category_id);
        $old_category = $category->name;
        $n_category = CaseCategory::FindOrFail($request->category);
        $new_category = $n_category->name;
        $model->case_category_id = $request->category;
        $model->save();

        $user = new CaseCategoryLog();
        $user->date = $request->date;
        $user->case_id = $request->id;
        $user->category_id = $request->category;
        $user->save();

        $description = 'Court Category Change: Form (' . $old_category . ") To (" . $new_category . ")";
        $date = new HearingDate();
        $date->cases_id = $model->id;
        $date->date = $request->date;
        $date->description = $description;
        $date->type = 'court_category_change';
        $date->save();

        $response = [
            'goto' => route('case.show', $model->id),
            'message' => __('case.Case Category Updated'),
        ];

        return response()->json($response);
    }

    public function court_change($id)
    {
        $model = Cases::FindOrFail($id);
        $court = Court::all()->pluck('name', 'id')->prepend(__('case.Select Court'), '');
        return view('case.court-change', compact('model', 'court'));
    }

    public function court_store(Request $request)
    {
        $this->validate($request, [
            'file.*' => 'sometimes|nullable|mimes:jpg,bmp,png,doc,docx,pdf,jpeg,txt',
        ]);

        $model = Cases::FindOrFail($request->id);
        $court = Court::FindOrFail($model->court_id);
        $old_court = $court->name;
        $n_court = Court::FindOrFail($request->court);
        $court_category_id = $n_court->court_category_id;
        $new_court = $n_court->name;
        $model->court_id = $request->court;
        $model->court_category_id = $court_category_id;
        $model->save();

        $user = new CaseCourt();
        $user->date = $request->date;
        $user->case_id = $request->id;
        $user->court_id = $request->court;
        $user->save();

        $description = 'Court Change: Form (' . $old_court . ") To (" . $new_court . ")";
        $date = new HearingDate();
        $date->cases_id = $model->id;
        $date->type = 'court_change';
        $date->date = $request->date;
        $date->description = $description;
        $date->type = 'court_change';
        $date->save();

        if ($request->file) {
            foreach ($request->file as $file) {
                $this->storeFile($file, $model->cases_id, $date->id);
            }
        }

        $response = [
            'goto' => route('case.show', $model->id),
            'message' => __('case.Case Court Updated'),
        ];

        return response()->json($response);
    }

    public function remove_lawyer($case_id, $lawyer_id)
    {
        $case = Cases::find($case_id);
        if ($case) {
            DB::table('cases_lawyer')
                ->where('cases_id', $case_id)
                ->where('lawyer_id', $lawyer_id)
                ->update(array('deleted_at' => DB::raw('NOW()')));
        }

        $response = [
            'goto' => route('case.show', $case_id),
            'message' => __('case.Lawyer removed from case.'),
        ];

        return response()->json($response);
    }

    public function add_lawyer($case_id)
    {
        $data['case'] = Cases::with('lawyers')->find($case_id);
        $previous_lawyer_ids = $data['case']->lawyers()->whereNull('deleted_at')->pluck('lawyer_id');

        $data['lawyers'] = Lawyer::whereNotIn('id', $previous_lawyer_ids)->pluck('name', 'id');
        return view('case.add_lawyer', $data);
    }

    public function post_lawyer(Request $request, $case_id)
    {
        $case = Cases::with('lawyers')->find($case_id);
        if ($case) {
            $sync = [];
            foreach ($request->lawyer_id as $lawyer) {
                DB::table('cases_lawyer')
                    ->insert([
                        'cases_id' => $case_id,
                        'lawyer_id' => $lawyer,
                        'created_at' => $request->date,
                    ]);
            }
        }
        $response = [
            'goto' => route('case.show', $case_id),
            'message' => __('case.Lawyer added to case.'),
        ];

        return response()->json($response);

    }

    public function filter(Request $request)
    {
        $data = [];
        $data['models'] = Cases::query();
        $data['clients'] = Client::all()->pluck('name', 'id');
        $data['client_id'] = $request->client_id;
        $data['stages'] = Stage::all()->pluck('name', 'id')->prepend(__('case.Select Case Stage'), '');
        $data['stage_id'] = $request->stage_id;
        $data['case_categories'] = CaseCategory::all()->pluck('name', 'id')->prepend(__('case.Select Case Categories'), '');
        $data['case_category_id'] = $request->case_category_id;
        $data['hearing_date'] = $request->hearing_date;
        $data['courts'] = Court::all()->pluck('name', 'id')->prepend(__('case.Select Court'), '');
        $data['court_id'] = $request->court_id;
        $data['judgement_status'] = $request->judgement_status;
        $data['status'] = $request->status;
        $data['filling_date'] = $request->filling_date;
        $data['receiving_date'] = $request->receiving_date;
        $data['judgement_date'] = $request->judgement_date;
        $data['case_no'] = $request->case_no;
        $data['file_no'] = $request->file_no;
        $data['db_acts'] = Act::all()->pluck('name', 'id');
        $data['acts'] = $request->acts;

        $data['staffs'] = User::whereNotIn('role_id', [1, 0])
            ->where('id', '!=', auth()->user()->id)->get()
            ->pluck('name', 'id');

            if ($request->client_id) {
                $data['models']->where(function ($q) use ($request) {
                    return $q->where('plaintiff', $request->client_id)->orWhere('opposite', $request->client_id)->orWhere('client_id', $request->client_id);
                });
            }
    
            if ($request->acts) {
                $data['models']->whereHas('acts', function ($q) use ($request) {
                    return $q->whereIn('acts_id', $request->acts);
                });
            }
    
            if ($request->stage_id) {
                $data['models']->where('stage_id', $request->stage_id);
            }
    
            if ($request->case_no) {
                $data['models']->where('case_no', 'like', '%' . $request->case_no . '%');
            }
    
            if ($request->file_no) {
                $data['models']->where('file_no', 'like', '%' . $request->file_no . '%');
            }
    
            if ($request->case_category_id) {
                $data['models']->where('case_category_id', $request->case_category_id);
            }
    
            if ($request->hearing_date) {
                $data['models']->whereDate('hearing_date', $request->hearing_date);
            }
            if ($request->filling_date) {
                $data['models']->whereDate('filling_date', $request->filling_date);
            }
            if ($request->judgement_date) {
                $data['models']->whereDate('judgement_date', $request->judgement_date);
            }
            if ($request->receiving_date) {
                $data['models']->whereDate('receiving_date', $request->receiving_date);
            }
            if ($request->court_id) {
                $data['models']->where(['court_id' => $request->court_id]);
            }
    
            if ($request->status) {
                $data['models']->where(['status' => $request->status]);
            }
            if ($request->judgement_status) {
                $data['models']->where(['judgement_status' => $request->judgement_status]);
            }
    
            $data['models'] = $data['models']->orderBy('hearing_date', 'asc')->get();

        return view('case.filter', $data);
    }
    private function storeCaseParticipant($model_id, $name = null, $advocate = null)
    {
        $casePer = new CaseParticipant();
        $casePer->case_id = $model_id;
        $casePer->name = $name;
        $casePer->advocate = $advocate;
        $casePer->save();
    }
    public function assignStaffToCase(Request $request)
    {
        $staff_ids = $request->staff_ids;
        $case_id = $request->case_id;

        $case = Cases::findOrFail($case_id);
        $hasIds = CaseStaff::where('case_id', $case_id)->pluck('staff_id')->toArray();
        if (!empty($staff_ids)) {
            $staffs = Staff::whereNotIn('id', $hasIds)->where('id', $staff_ids)->get();
            foreach ($staffs as $staff) {
                if (!in_array($staff, $hasIds)) {
                    $caseStaff = new CaseStaff();
                    $caseStaff->staff_id = $staff->id;
                    $caseStaff->case_id = $case_id;
                    $caseStaff->save();

                    dispatch(new CaseAssignMailJob(auth()->user(), $case, $staff->user));
                }
            }
        }

        Toastr::success(__('case.Case Assign Successfully'));
        return redirect()->back();
    }
    public function removeStaff($id)
    {
        $model = CaseStaff::where('id', $id)->first();
        if ($model) {
            $case_id = $model->case_id;
            $model->delete();
        }

        $response = [
            'goto' => route('case.show', $case_id),
            'message' => __('case.Staff Remove Successfully'),
        ];

        return response()->json($response);
    }
    public static function authorizeToCase($id)
    {
        $caseAccess = false;
        $caseIds = [];

        if (!permissionCheck('all-case') && auth()->user()->role_id != 1) {
            $caseAccess = true;
            $caseIds = CaseStaff::where('staff_id', auth()->user()->id)->pluck('case_id')->toArray();
        }
        if ($caseAccess) {
            if (!in_array($id, $caseIds)) {
                abort(403);
            }
        }
    }
}
