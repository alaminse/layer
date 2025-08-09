@extends('layouts.master', ['title' => __('case.Case')])

@section('mainContent')


    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header xs_mb_0">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('case.' . $page_title . ' Case') }}</h3>
                            <ul class="d-flex">
                                @if (permissionCheck('case.store'))
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                            href="{{ route('case.create') }}"><i
                                                class="ti-plus"></i>{{ __('case.New Case') }}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active3 case-data-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('common.SL') }}</th>
                                            <th scope="col">{{ __('case.Case') }}</th>
                                            <th scope="col">{{ __('case.Client') }}</th>
                                            <th scope="col">{{ __('case.Details') }}</th>
                                            <th scope="col">{{ __('common.Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($models as $model)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>
                                                    <b>{{ __('case.Case No.') }}: </b>
                                                    {{ $model->case_category ? $model->case_category->name : '' }}
                                                    /{{ $model->case_no }} <br>
                                                    @if ($model->case_category_id)
                                                        <a
                                                            href="{{ route('category.case.show', $model->case_category_id) }}"><b>{{ __('case.Category') }}
                                                                :
                                                            </b>
                                                            {{ $model->case_category ? $model->case_category->name : '' }}
                                                        </a>
                                                    @else
                                                        <b>{{ __('case.Category') }}: </b>
                                                        {{ $model->case_category ? $model->case_category->name : '' }}
                                                    @endif
                                                    <br>
                                                    <a href="{{ route('case.show', $model->id) }}"><b>{{ __('case.Title') }}
                                                            : </b>{{ $model->title }}
                                                    </a>
                                                    <br>
                                                    <b>{{ __('case.Next Hearing Date') }}
                                                        : </b> {{ formatDate($model->hearing_date) }} <br>
                                                    <b>{{ __('case.Filing Date') }}
                                                        : </b> {{ formatDate($model->filling_date) }}
                                                </td>
                                                <td>
                                                    @if ($model->layout == 1)
                                                        @if ($model->client == 'Plaintiff' and $model->plaintiff_client)
                                                            <a
                                                                href="{{ route('client.show', $model->plaintiff_client ? $model->plaintiff_client->id : $model->clientLayout2->id) }}"><b>{{ __('case.Name') }}</b>:
                                                                {{ $model->plaintiff_client->name }}</a> <br>
                                                            <b>{{ __('case.Mobile') }}
                                                                : </b> {{ $model->plaintiff_client->mobile }} <br>
                                                            <b>{{ __('case.Email') }}
                                                                : </b> {{ $model->plaintiff_client->email }} <br>
                                                            <b>{{ __('case.Address') }}
                                                                : </b> {{ $model->plaintiff_client->address }}
                                                            {{ $model->plaintiff_client->city ? ', ' . $model->plaintiff_client->city->name : '' }}
                                                            {{ $model->plaintiff_client->state ? ', ' . $model->plaintiff_client->state->name : '' }}
                                                        @elseif($model->client == 'Opposite' and $model->opposite_client)
                                                            <a
                                                                href="{{ route('client.show', $model->opposite_client->id) }}"><b>{{ __('case.Name') }}</b>:
                                                                {{ $model->opposite_client->name }}</a> <br>
                                                            <b>{{ __('case.Mobile') }}
                                                                : </b> {{ $model->opposite_client->mobile }} <br>
                                                            <b>{{ __('case.Email') }}: </b>
                                                            {{ $model->opposite_client->email }}
                                                            <br>
                                                            <b>{{ __('case.Address') }}
                                                                : </b> {{ $model->opposite_client->address }}
                                                            {{ $model->opposite_client->city ? ', ' . $model->opposite_client->city->name : '' }}
                                                            {{ $model->opposite_client->state ? ', ' . $model->opposite_client->state->name : '' }}
                                                        @endif
                                                    @elseif($model->layout == 2)
                                                        <a href="{{ route('client.show', $model->clientLayout2->id) }}"><b>{{ __('case.Name') }}</b>:
                                                            {{ $model->clientLayout2->name }}</a> <br>
                                                        <b>{{ __('case.Mobile') }}
                                                            : </b> {{ $model->clientLayout2->mobile }} <br>
                                                        <b>{{ __('case.Email') }}
                                                            : </b> {{ $model->clientLayout2->email }} <br>
                                                        <b>{{ __('case.Address') }}
                                                            : </b> {{ $model->clientLayout2->address }}
                                                        {{ $model->clientLayout2->city ? ', ' . $model->clientLayout2->city->name : '' }}
                                                        {{ $model->clientLayout2->state ? ', ' . $model->clientLayout2->state->name : '' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($model->court)
                                                        <a href="{{ route('master.court.show', $model->court_id) }}"><b>{{ __('case.Court') }}</b>:
                                                            {{ $model->court->name }} </a><br>
                                                        <a
                                                            href="{{ route('category.court.show', $model->court_category_id) }}">
                                                            <b>{{ __('case.Category') }}</b>:
                                                            {{ $model->court->court_category ? $model->court->court_category->name : '' }}
                                                        </a><br>
                                                        <b>{{ __('case.Room No') }}: </b>
                                                        {{ $model->court->room_number }}
                                                        <br>
                                                        <b>{{ __('case.Address') }}: </b>
                                                        {{ $model->court->location }}
                                                        {{ $model->court->city ? ', ' . $model->court->city->name : '' }}
                                                        {{ $model->court->state ? ', ' . $model->court->state->name : '' }}
                                                    @endif
                                                </td>


                                                <td>


                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            {{ __('common.Select') }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="dropdownMenu2">
                                                            <a href="{{ route('case.show', $model->id) }}"
                                                                class="dropdown-item"><i class="icon-file-eye"></i>
                                                                {{ __('common.View') }}</a>
                                                            @if (!$model->judgement)
                                                                @if (permissionCheck('case.edit'))
                                                                    <a href="{{ route('case.edit', $model->id) }}"
                                                                        class="dropdown-item"><i
                                                                            class="icon-pencil mr-2"></i>{{ __('common.Edit') }}
                                                                    </a>
                                                                @endif
                                                                @if (permissionCheck('date.store'))
                                                                    <a href="{{ route('date.create', ['case' => $model->id]) }}"
                                                                        class="dropdown-item"><i
                                                                            class="icon-calendar3 mr-2"></i>{{ __('case.New Date') }}
                                                                    </a>
                                                                @endif
                                                                @if (permissionCheck('putlist.store'))
                                                                    <a href="{{ route('putlist.create', ['case' => $model->id]) }}"
                                                                        class="dropdown-item"><i
                                                                            class="icon-calendar3 mr-2"></i>{{ __('case.New Put Up Date') }}
                                                                    </a>
                                                                @endif
                                                                @if (permissionCheck('lobbying.store'))
                                                                    <a href="{{ route('lobbying.create', ['case' => $model->id]) }}"
                                                                        class="dropdown-item"><i
                                                                            class="icon-calendar3 mr-2"></i>{{ __('case.New Lobbying Date') }}
                                                                    </a>
                                                                @endif
                                                                @if (permissionCheck('judgement.store'))
                                                                    <a href="{{ route('judgement.create', ['case' => $model->id]) }}"
                                                                        class="dropdown-item"><i
                                                                            class="icon-calendar3 mr-2"></i>{{ __('case.New Judgement Date') }}
                                                                    </a>
                                                                @endif
                                                            @endif
                                                            @if (permissionCheck('case.destroy'))
                                                                <span id="delete_item" data-id="{{ $model->id }}"
                                                                    data-url="{{ route('case.destroy', $model->id) }}"
                                                                    class="dropdown-item"><i class="icon-trash"></i>
                                                                    {{ __('common.Delete') }}
                                                                </span>
                                                            @endif

                                                        </div>
                                                    </div>


                                                </td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('case.inc.assign_lawyer_modal')
@stop
@push('admin.scripts')

@include('backEnd.partials.server_side_datatable')

<script src="{{asset('public/backEnd/')}}/vendors/js/dataTables.buttons.min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/dataTables.rowReorder.min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/dataTables.responsive.min.js"></script>
<script>
//
// DataTables initialisation
//
$(document).ready(function() {
    $(document).on('click','.assignLawyer', function(){
        let caseid = $(this).data('case_id');
        $('#case_id').val(caseid);
        $('#assignLawyerModal').modal('show');
    })
    var type = "{{ $status ?? 'AllCase' }}";
   $('.case-data-table').DataTable({

                 processing: true,
                 serverSide: true,
                 "ajax": $.fn.dataTable.pipeline( {
                       url: SET_DOMAIN + '/case-list-datatable/'+type,
                       pages: 2 // number of pages to cache

                   } ),
                   columns: [
                           {data: 'DT_RowIndex', name: 'serial_no'},
                           {data: 'case', name: 'case', orderable: false, searchable: false},
                           {data: 'client', name: 'client', orderable: false, searchable: false},
                           {data: 'details', name: 'details', orderable: false, searchable: false},
                           {data: 'action', name: 'action', orderable: false, searchable: false, width: 100},
                           {data: 'case_no', name: 'case_no', visible:false},
                           {data: 'hearing_date', name: 'hearing_date',visible:false},
                           {data: 'title', name: 'title', visible:false},
                           {data: 'case_category', name: 'case_category.name', visible:false},
                           {data: 'court', name: 'court.name', visible:false},
                           {data: 'client_category', name: 'client_category.name', visible:false}
                       ],
                   bLengthChange: false,
                   bDestroy: true,
                   language: {
                   search: "<i class='ti-search'></i>",
                   searchPlaceholder: "Quick Search",
                   paginate: {
                       next: "<i class='ti-arrow-right'></i>",
                       previous: "<i class='ti-arrow-left'></i>",
                   },
                   },
                   dom: "Bfrtip",
                   buttons: [{
                       extend: "copyHtml5",
                       text: '<i class="fa fa-files-o"></i>',
                       title: $("#logo_title").val(),
                       titleAttr: "Copy",
                       exportOptions: {
                           columns: ':visible:not(.not-export-col)'
                       },
                   },
                   {
                       extend: "excelHtml5",
                       text: '<i class="fa fa-file-excel-o"></i>',
                       titleAttr: "Excel",
                       title: $("#logo_title").val(),
                       margin: [10, 10, 10, 0],
                       exportOptions: {
                           columns: ':visible:not(.not-export-col)'
                       },
                   },
                   {
                       extend: "csvHtml5",
                       text: '<i class="fa fa-file-text-o"></i>',
                       titleAttr: "CSV",
                       exportOptions: {
                           columns: ':visible:not(.not-export-col)'
                       },
                   },
                   {
                       extend: "pdfHtml5",
                       text: '<i class="fa fa-file-pdf-o"></i>',
                       title: $("#logo_title").val(),
                       titleAttr: "PDF",
                       exportOptions: {
                           columns: ':visible:not(.not-export-col)'
                       },
                       orientation: "landscape",
                       pageSize: "A4",
                       margin: [0, 0, 0, 12],
                       alignment: "center",
                       header: true,
                       customize: function(doc) {
                           doc.content[1].margin = [100, 0, 100, 0]; //left, top, right, bottom
                           doc.content.splice(1, 0, {
                               margin: [0, 0, 0, 12],
                               alignment: "center",
                               image: "data:image/png;base64," + $("#logo_img").val(),
                           });
                       },
                   },
                   {
                       extend: "print",
                       text: '<i class="fa fa-print"></i>',
                       titleAttr: "Print",
                       title: $("#logo_title").val(),
                       exportOptions: {
                           columns: ':visible:not(.not-export-col)'
                       },
                   },
                   {
                       extend: "colvis",
                       text: '<i class="fa fa-columns"></i>',
                       postfixButtons: ["colvisRestore"],
                   },
               ],
               columnDefs: [{
                   visible: false,
               }, ],
               responsive: true,
             });
} );
       </script>

@endpush
