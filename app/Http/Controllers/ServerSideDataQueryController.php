<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\CaseStaff;
use App\Models\Client;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ServerSideDataQueryController extends Controller
{
    //
    public function cases(Request $request)
    {

        $caseAccess = false;
        $caseIds = [];

        if (!permissionCheck('all-case')) {
            $caseAccess = true;
            $caseIds = CaseStaff::where('staff_id', auth()->user()->id)->pluck('case_id')->toArray();
        }

        $cases = Cases::when(moduleStatusCheck('ClientLogin'), function ($query) {
            $query->whereNotIn('status', ['Pending']);
        })
            ->when($caseAccess, function ($query) use ($caseIds) {
                $query->whereIn('id', $caseIds);
            })->with(['case_category', 'court', 'client_category']);

        if ($request->status and $request->status == 'Archieved') {
            $cases = Cases::where('judgement_status', 'Judgement')->when($caseAccess, function ($query) use ($caseIds) {
                $query->whereIn('id', $caseIds);
            });

        } elseif ($request->status and $request->status == 'Judgement') {
            $cases = Cases::where('judgement_status', 'Judgement')->when($caseAccess, function ($query) use ($caseIds) {
                $query->whereIn('id', $caseIds);
            });

        } elseif ($request->status and $request->status == 'Close') {
            $cases = Cases::where('judgement_status', 'Close')->when($caseAccess, function ($query) use ($caseIds) {
                $query->whereIn('id', $caseIds);
            });

        } elseif ($request->status and $request->status == 'Waiting') {
            $cases = Cases::where('status', 'Open')->when($caseAccess, function ($query) use ($caseIds) {
                $query->whereIn('id', $caseIds);
            })->where('hearing_date', '<', date('Y-m-d'));

        } elseif ($request->status and $request->status == 'Running') {

            $cases = Cases::where(function ($q) {
                $q->where('status', 'Open')->orWhereIn('judgement_status', ['Open', 'Reopen']);
            })->when($caseAccess, function ($query) use ($caseIds) {
                $query->whereIn('id', $caseIds);
            });

        }
        if (moduleStatusCheck('ClientLogin') && $request->status && $request->status == 'Pending') {
            $cases = Cases::when(moduleStatusCheck('ClientLogin'), function ($query) {
                $query->whereIn('status', ['Pending']);
            })->when($caseAccess, function ($query) use ($caseIds) {
                $query->whereIn('id', $caseIds);
            });

        }
        $cases = $cases->orderBy('last_action', 'DESC')->select('cases.*');
        // if ($request->ajax()) {
        return Datatables::of($cases)
            ->addIndexColumn()
            ->addColumn('case', function ($row) {
                $case = '<b>' . __("case.Case No.") . ": </b>" . $row->case_category->name . '/' . $row->case_no . '<br>' .
                (($row->case_category_id) ?
                    '<a href="' . route('category.case.show', [$row->case_category_id]) . '"><b>' . __('case.Category') .
                    ':</b>' . $row->case_category->name . ' </a>'
                    :
                    '<b>' . __('case.Category') . ': </b>' . $row->case_category->name)
                . '<br>'
                . '<a href="' . route('case.show', [$row->id]) . '"><b>' . __('case.Title') . ': </b>' . $row->title . ' </a>
                    <br> <b>' . __('case.Next Hearing Date') . ': </b>' . formatDate($row->hearing_date) . '<br> <b> ' . __('case.Filing Date') . ': </b>' . formatDate($row->filling_date);

                return $case;
            })

            ->addColumn('client', function ($row) {
                $client = '';
                if (!$row->layout || $row->layout == 1) {
                    if ($row->client == 'Plaintiff' and $row->plaintiff_client) {
                        $client = '<a href="' . route('client.show', [$row->plaintiff_client ? $row->plaintiff_client->id : $row->clientLayout2->id]) . '"><b>' . __('case.Name') . '</b>:' .
                        $row->plaintiff_client->name . '</a> <br> <b>' . __('case.Mobile') . ': </b>' .
                        $row->plaintiff_client->mobile . '<br><b>' . __('case.Email') .
                        ' : </b>' . $row->plaintiff_client->email . '<br>
                                <b>' . __('case.Address') . '
                                    : </b>' . $row->plaintiff_client->address . ' , ' . $row->plaintiff_client->city->name . ' ' . ', ' . $row->plaintiff_client->state->name;
                    } elseif ($row->client == 'Opposite' and $row->opposite_client) {
                        $client = '<a href="' . route('client.show', [$row->opposite_client->id]) . '"><b>' . __('case.Name') . '</b>:' . $row->opposite_client->name . '</a> <br>
                                <b> ' . __('case.Mobile') . '
                                    : </b> ' . $row->opposite_client->mobile . '<br>
                                <b>' . __('case.Email') . ': </b>' . $row->opposite_client->email .
                        '<br>
                                <b>' . __('case.Address') . '
                                    : </b>' . $row->opposite_client->address . ', ' . $row->opposite_client->city->name . '' . ', ' . $row->opposite_client->state->name;
                    }
                } elseif ($row->layout == 2 && $row->clientLayout2) {
                    $client = '<a href="' . route('client.show', $row->clientLayout2->id) . '"><b>' . __('case.Name') . '</b>:'
                    . $row->clientLayout2->name . '</a> <br>
                            <b>' . __('case.Mobile') . '
                                : </b>' . $row->clientLayout2->mobile . '<br>
                            <b>' . __('case.Email') . '
                                : </b>' . $row->clientLayout2->email . '<br>
                            <b>' . __('case.Address') .
                    ' : </b>' . $row->clientLayout2->address . ', ' . $row->clientLayout2->city->name . ', ' . $row->clientLayout2->state->name;
                }
                return $client;
            })

            ->addColumn('details', function ($row) {

                if ($row->court) {
                    $detail = '<a href="' . route('master.court.show', [$row->court_id]) . '"><b>' . __('case.Court') . '</b>:
                        ' . $row->court->name . '</a><br><a href="' . route('category.court.show', [$row->court_category_id]) . '"><b>' . __('case.Category') . '</b>:' . $row->court->court_category->name . '</a><br> <b>'
                    . __('case.Room No') . ': </b>' . $row->court->room_number . ' <br><b>' . __('case.Address')
                    . ': </b>' . $row->court->location . ', ' . $row->court->city->name . ', ' . $row->court->state->name;
                } else {
                    $detail = '';
                }
                return $detail;
            })
            ->addColumn('action', function ($row) use ($request) {
                if ($request->status == 'Judgement') {
                    return view('case.inc.judgement_actions', ['model' => $row]);
                } elseif ($request->status == 'Close') {
                    return view('case.inc.close_actions', ['model' => $row]);
                } else {
                    return view('case.inc.case_actions', ['model' => $row]);
                }

            })
            ->rawColumns(['case', 'client', 'details', 'action'])
            ->make(true);
    }

    public function clients(Request $request)
    {
        if ($request->ajax()) {
            $models = Client::when(moduleStatusCheck('ClientLogin'), function ($quey) {
                $quey->whereIn('status', ['active', 'approve'])->orWhereNull('status');
            })->with('category');
            $models = $models->select('clients.*');
            return Datatables::of($models)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    if (moduleStatusCheck('ClientLogin')) {
                        $name = '<a href="' . route('client.show', $row->id) . '">' . $row->name . '[' . $row->type . ']';
                    } else {
                        $name = '<a href="' . route('client.show', $row->id) . '">' . $row->name;
                    }
                    return $name;
                })
                ->addColumn('email_mobile', function ($row) {
                    $email_mobile = __('client.Mobile') . ': ' . $row->mobile . ' <br>' . __('client.Email') . ': ' . $row->email;
                    return $email_mobile;
                })
                ->addColumn('category', function ($row) {
                    $category = @$row->category->name;
                    return $category;
                })
                ->addColumn('address', function ($row) {
                    $address = $row->address . ', <br>' . $row->state->name . ', ' . $row->city->name . ', ' . $row->country->name;
                    return $address;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown CRM_dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenu2" data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                    ' . __("common.Select") . '
                </button><div class="dropdown-menu dropdown-menu-right"
                aria-labelledby="dropdownMenu2">' . (moduleStatusCheck("ClientLogin") && permissionCheck("client.legal-contract.assign") ? '<a class="dropdown-item edit_brand" target="_blank" href="' . route('client.legal-contract.assign', [$row->id]) . '">' . __("client.Legal Contract") . '</a>' : '')
                        . ((permissionCheck('client.show')) ?
                        '<a class="dropdown-item edit_brand" href="' . route('client.show', [$row->id]) . '">' . __('common.Show')
                        . '</a>' : '')

                        . ((permissionCheck("client.edit")) ?
                        '<a class="dropdown-item edit_brand" href="' . route('client.edit', [$row->id]) . '"
                   >' . __("common.Edit") . "</a>" : '')

                        . ((permissionCheck('client.destroy')) ?
                        '<span class="dropdown-item" id="delete_item" data-url="' . route('client.destroy', [$row->id]) . '"' . 'data-id="' . $row->id . '"' . '<i class="icon-trash"></i>
                        ' . __("common.Delete") . '  </span>' : '')

                        . '</div></div>';
                    return $btn;
                })
                ->rawColumns(['name', 'email_mobile', 'category', 'address', 'action'])
                ->make(true);
        }
    }
    public function causeList(Request $request)
    {
        $caseAccess = false;
        $caseIds = [];

        if (!permissionCheck('all-case')) {
            $caseAccess = true;
            $caseIds = CaseStaff::where('staff_id', auth()->user()->id)->pluck('case_id')->toArray();
        }

        $cases = Cases::where(function ($q) {
            $q->where('status', 'Open')->orWhereIn('judgement_status', ['Open', 'Reopen']);
        });
        if ($request->start_date) {
            $data['start_date'] = getFormatedDate($request->start_date, true);
            $cases = $cases->whereDate('hearing_date', '>=', $data['start_date']);
        }

        if ($request->end_date) {
            $data['end_date'] = getFormatedDate($request->end_date, true);
            $cases = $cases->whereDate('hearing_date', '<=', $data['end_date']);
        }
        if ($caseAccess) {
            $cases->whereIn('id', $caseIds);
        }
        $cases = $cases->select('cases.*');
        // if ($request->ajax()) {
        return Datatables::of($cases)
            ->addIndexColumn()
            ->addColumn('case', function ($row) {
                $case = '<b>' . __("case.Case No.") . ": </b>" . $row->case_category->name . '/' . $row->case_no . '<br>' .
                (($row->case_category_id) ?
                    '<a href="' . route('category.case.show', [$row->case_category_id]) . '"><b>' . __('case.Category') .
                    ':</b>' . $row->case_category->name . ' </a>'
                    :
                    '<b>' . __('case.Category') . ': </b>' . $row->case_category->name)
                . '<br>'
                . '<a href="' . route('case.show', [$row->id]) . '"><b>' . __('case.Title') . ': </b>' . $row->title . ' </a>
                    <br> <b>' . __('case.Next Hearing Date') . ': </b>' . formatDate($row->hearing_date) . '<br> <b> ' . __('case.Filing Date') . ': </b>' . formatDate($row->filling_date);

                return $case;
            })

            ->addColumn('client', function ($row) {

                if ($row->layout == 1) {
                    if ($row->client == 'Plaintiff' and $row->plaintiff_client) {
                        $client = '<a href="' . route('client.show', [$row->plaintiff_client ? $row->plaintiff_client->id : $row->clientLayout2->id]) . '"><b>' . __('case.Name') . '</b>:' .
                        $row->plaintiff_client->name . '</a> <br> <b>' . __('case.Mobile') . ': </b>' .
                        $row->plaintiff_client->mobile . '<br><b>' . __('case.Email') .
                        ' : </b>' . $row->plaintiff_client->email . '<br>
                                <b>' . __('case.Address') . '
                                    : </b>' . $row->plaintiff_client->address . ' , ' . $row->plaintiff_client->city->name . ' ' . ', ' . $row->plaintiff_client->state->name;
                    } elseif ($row->client == 'Opposite' and $row->opposite_client) {
                        $client = '<a href="' . route('client.show', [$row->opposite_client->id]) . '"><b>' . __('case.Name') . '</b>:' . $row->opposite_client->name . '</a> <br>
                                <b> ' . __('case.Mobile') . '
                                    : </b> ' . $row->opposite_client->mobile . '<br>
                                <b>' . __('case.Email') . ': </b>' . $row->opposite_client->email .
                        '<br>
                                <b>' . __('case.Address') . '
                                    : </b>' . $row->opposite_client->address . ', ' . $row->opposite_client->city->name . '' . ', ' . $row->opposite_client->state->name;
                    }
                } elseif ($row->layout == 2) {
                    $client = '<a href="' . route('client.show', $row->clientLayout2->id) . '"><b>' . __('case.Name') . '</b>:'
                    . $row->clientLayout2->name . '</a> <br>
                            <b>' . __('case.Mobile') . '
                                : </b>' . $row->clientLayout2->mobile . '<br>
                            <b>' . __('case.Email') . '
                                : </b>' . $row->clientLayout2->email . '<br>
                            <b>' . __('case.Address') .
                    ' : </b>' . $row->clientLayout2->address . ', ' . $row->clientLayout2->city->name . ', ' . $row->clientLayout2->state->name;
                }
                return $client;
            })

            ->addColumn('details', function ($row) {

                if ($row->court) {
                    $detail = '<a href="' . route('master.court.show', [$row->court_id]) . '"><b>' . __('case.Court') . '</b>:
                        ' . $row->court->name . '</a><br><a href="' . route('category.court.show', [$row->court_category_id]) . '"><b>' . __('case.Category') . '</b>:' . $row->court->court_category->name . '</a><br> <b>'
                    . __('case.Room No') . ': </b>' . $row->court->room_number . ' <br><b>' . __('case.Address')
                    . ': </b>' . $row->court->location . ', ' . $row->court->city->name . ', ' . $row->court->state->name;
                } else {
                    $detail = '';
                }
                return $detail;
            })
            ->addColumn('action', function ($row) use ($request) {

                return view('case.inc.case_actions', ['model' => $row]);

            })
            ->rawColumns(['case', 'client', 'details', 'action'])
            ->make(true);
    }

    public function filterList(Request $request)
    {
        $caseAccess = false;
        $caseIds = [];

        if (!permissionCheck('all-case')) {
            $caseAccess = true;
            $caseIds = CaseStaff::where('staff_id', auth()->user()->id)->pluck('case_id')->toArray();
        }
        $models = Cases::query();
        if ($request->client_id) {
            $models->where(function ($q) use ($request) {
                return $q->where('plaintiff', $request->client_id)->orWhere('opposite', $request->client_id);
            });
        }

        if ($request->acts) {
            $models->whereHas('acts', function ($q) use ($request) {
                return $q->whereIn('acts_id', $request->acts);
            });
        }

        if ($request->stage_id) {
            $models->where('stage_id', $request->stage_id);
        }

        if ($request->case_no) {
            $models->where('case_no', 'like', '%' . $request->case_no . '%');
        }

        if ($request->file_no) {
            $models->where('file_no', 'like', '%' . $request->file_no . '%');
        }

        if ($request->case_category_id) {
            $models->where('case_category_id', $request->case_category_id);
        }

        if ($request->hearing_date) {
            $models->whereDate('hearing_date', $request->hearing_date);
        }
        if ($request->filling_date) {
            $models->whereDate('filling_date', $request->filling_date);
        }
        if ($request->judgement_date) {
            $models->whereDate('judgement_date', $request->judgement_date);
        }
        if ($request->receiving_date) {
            $models->whereDate('receiving_date', $request->receiving_date);
        }
        if ($request->court_id) {
            $models->where(['court_id' => $request->court_id]);
        }

        if ($request->status) {
            $models->where(['status' => $request->status]);
        }
        if ($request->judgement_status) {
            $models->where(['judgement_status' => $request->judgement_status]);
        }

        if ($caseAccess) {
            $models->whereIn('id', $caseIds);
        }
        $models = $models->select('cases.*');
        // if ($request->ajax()) {
        return Datatables::of($models)
            ->addIndexColumn()
            ->addColumn('case', function ($row) {
                $case = '<b>' . __("case.Case No.") . ": </b>" . $row->case_category->name . '/' . $row->case_no . '<br>' .
                (($row->case_category_id) ?
                    '<a href="' . route('category.case.show', [$row->case_category_id]) . '"><b>' . __('case.Category') .
                    ':</b>' . $row->case_category->name . ' </a>'
                    :
                    '<b>' . __('case.Category') . ': </b>' . $row->case_category->name)
                . '<br>'
                . '<a href="' . route('case.show', [$row->id]) . '"><b>' . __('case.Title') . ': </b>' . $row->title . ' </a>
                    <br> <b>' . __('case.Next Hearing Date') . ': </b>' . formatDate($row->hearing_date) . '<br> <b> ' . __('case.Filing Date') . ': </b>' . formatDate($row->filling_date);

                return $case;
            })

            ->addColumn('plaintiff_clients', function ($row) {
                $client = '';
                if (!$row->layout || $row->layout == 1) {

                    $client .= '<a href="' . route('client.show', [$row->plaintiff_client ? $row->plaintiff_client->id : $row->clientLayout2->id]) . '"><b>' . __('case.Name') . '</b>:' .
                    $row->plaintiff_client->name . '</a> <br> <b>' . __('case.Mobile') . ': </b>' .
                    $row->plaintiff_client->mobile . '<br><b>' . __('case.Email') .
                    ' : </b>' . $row->plaintiff_client->email . '<br>
                                <b>' . __('case.Address') . '
                                    : </b>' . $row->plaintiff_client->address . ' , ' . $row->plaintiff_client->city->name . ' ' . ', ' . $row->plaintiff_client->state->name;

                } elseif ($row->layout == 2) {
                    if ($row->client_type == 'petitionar') {
                        $client .= '<a href="' . route('client.show', $row->clientLayout2->id) . '"><b>' . __('case.Name') . '</b>:'
                        . $row->clientLayout2->name . '</a> <br>
                            <b>' . __('case.Mobile') . '
                                : </b>' . $row->clientLayout2->mobile . '<br>
                            <b>' . __('case.Email') . '
                                : </b>' . $row->clientLayout2->email . '<br>
                            <b>' . __('case.Address') .
                        ' : </b>' . $row->clientLayout2->address . ', ' . $row->clientLayout2->city->name . ', ' . $row->clientLayout2->state->name;
                    } else {
                        foreach ($row->caseParticipants->take(2) as $key => $p) {
                            $client .= '<b>' . __('case.Name') . '</b>:' . $p->name . '<br>';
                            $client .= '<b>' . __('case.Advocate') . '</b>:' . $p->advocate;
                            if ($key == 0) {
                                $client .= '<br>';
                            }
                        }
                    }
                }
                return $client;
            })

            ->addColumn('opposite_clients', function ($row) {
                $client = '';
                if (!$row->layout || $row->layout == 1) {

                    $client .= '<a href="' . route('client.show', [$row->opposite_client->id]) . '"><b>' . __('case.Name') . '</b>:' . $row->opposite_client->name . '</a> <br>
                            <b> ' . __('case.Mobile') . '
                                : </b> ' . $row->opposite_client->mobile . '<br>
                            <b>' . __('case.Email') . ': </b>' . $row->opposite_client->email .
                    '<br>
                            <b>' . __('case.Address') . '
                                : </b>' . $row->opposite_client->address . ', ' . $row->opposite_client->city->name . '' . ', ' . $row->opposite_client->state->name;

                } elseif ($row->layout == 2) {
                    if ($row->client_type != 'petitionar') {
                        $client .= '<a href="' . route('client.show', $row->clientLayout2->id) . '"><b>' . __('case.Name') . '</b>:'
                        . $row->clientLayout2->name . '</a> <br>
                            <b>' . __('case.Mobile') . '
                                : </b>' . $row->clientLayout2->mobile . '<br>
                            <b>' . __('case.Email') . '
                                : </b>' . $row->clientLayout2->email . '<br>
                            <b>' . __('case.Address') .
                        ' : </b>' . $row->clientLayout2->address . ', ' . $row->clientLayout2->city->name . ', ' . $row->clientLayout2->state->name;
                    } else {
                        foreach ($row->caseParticipants->take(2) as $key => $p) {
                            $client .= '<b>' . __('case.Name') . '</b>:' . $p->name . '<br>';
                            $client .= '<b>' . __('case.Advocate') . '</b>:' . $p->advocate;
                            if ($key == 0) {
                                $client .= '<br>';
                            }

                        }
                    }
                }
                return $client;
            })

            ->addColumn('details', function ($row) {

                if ($row->court) {
                    $detail = '<a href="' . route('master.court.show', [$row->court_id]) . '"><b>' . __('case.Court') . '</b>:
                        ' . $row->court->name . '</a><br><a href="' . route('category.court.show', [$row->court_category_id]) . '"><b>' . __('case.Category') . '</b>:' . $row->court->court_category->name . '</a><br> <b>'
                    . __('case.Room No') . ': </b>' . $row->court->room_number . ' <br><b>' . __('case.Address')
                    . ': </b>' . $row->court->location . ', ' . $row->court->city->name . ', ' . $row->court->state->name;
                } else {
                    $detail = '';
                }
                return $detail;
            })
            ->addColumn('action', function ($row) use ($request) {

                return view('case.inc.case_actions', ['model' => $row]);

            })
            ->rawColumns(['case', 'opposite_clients', 'plaintiff_clients', 'details', 'action'])
            ->make(true);
    }
}
