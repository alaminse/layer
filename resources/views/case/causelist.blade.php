@extends('layouts.master', ['title' => __('case.Cause List')])

@section('mainContent')


    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('case.Cause List') }}
                                @isset($start_date)
                                    | {{ __('case.Date') }} :{{ formatDate($start_date) }}
                                @endisset
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="white_box_50px box_shadow_white">

                        {!! Form::open(['route' => 'cause-list-datatable', 'method' => 'get', 'id' => 'content_form']) !!}

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="primary_input mb-15">
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    {{ Form::text('date_range', null, ['class' => 'primary_input_field primary-input form-control', 'required', 'placeholder' => __('common.select_criteria'), 'data-parsley-errors-container' => '#date_range_error', 'id' => 'date_range', 'readonly']) }}

                                                </div>
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                        <span id="date_range_error"></span>
                                    </div>

                                </div>
                            </div>
                            <input type="hidden" id="start">
                            <input type="hidden" id="end">
                            <div class="col-lg-6 mt-10">
                                <button type="submit" class="primary-btn small fix-gr-bg submit">
                                    <span class="ti-search pr-2"></span>
                                    {{ __('common.Search') }}</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('case.Cause List') }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    {{-- <div class="text-center" id="loader">
                        <img src="{{ asset('public/backEnd/img/demo_wait.gif') }}" alt="">
                    </div> --}}

                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table" >
                            <table class="table Crm_table_active3 cause-data-table">
                                <thead>
                                <tr>                            
                                    <th scope="col">{{ __('common.SL') }}</th>
                                    <th>{{ __('case.Case') }}</th>
                                    <th>{{ __('case.Client') }}</th>
                                    <th>{{ __('case.Details') }}</th>
                                    <th class="noprint">{{ __('common.Actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                               
                            
                                </tbody>
                            </table>
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

    let causeListDataTable = $('.cause-data-table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    url: SET_DOMAIN + '/cause-list-datatable',
                    data: function(d){
                        d.start_date = $("#start").val();
                        d.end_date = $("#end").val();
                    }

                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'case',
                        name: 'case',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'client',
                        name: 'client',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'details',
                        name: 'details',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: 100
                    },
                    {data: 'case_no', name: 'case_no',visible:false},
                    {data: 'hearing_date', name: 'hearing_date',visible:false},
                    {data: 'title', name: 'title',visible:false}
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
        $('input[name="date_range"]').daterangepicker({
            ranges: {
                {!! json_encode(__('calender.Today')) !!}: [moment(), moment()],
                {!! json_encode(__('calender.Yesterday')) !!}: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                {!! json_encode(__('calender.Last 7 Days')) !!}: [moment().subtract(6, 'days'), moment()],
                {!! json_encode(__('calender.Last 30 Days')) !!}: [moment().subtract(29, 'days'), moment()],
                {!! json_encode(__('calender.This Month')) !!}: [moment().startOf('month'), moment().endOf('month')],
                {!! json_encode(__('calender.Last Month')) !!}: [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')]
            },
            "locale": {
                "separator": {!! json_encode(__('calender.separator')) !!},
                "applyLabel": {!! json_encode(__('calender.applyLabel')) !!},
                "cancelLabel": {!! json_encode(__('calender.cancelLabel')) !!},
                "fromLabel": {!! json_encode(__('calender.fromLabel')) !!},
                "toLabel": {!! json_encode(__('calender.toLabel')) !!},
                "customRangeLabel": {!! json_encode(__('calender.customRangeLabel')) !!},
                "weekLabel": {!! json_encode(__('calender.weekLabel')) !!},
                "daysOfWeek": {!! json_encode(__('calender.daysMin')) !!},
                "monthNames": {!! json_encode(__('calender.months')) !!}
            },
            "startDate": moment().subtract(7, 'days'),
            "endDate": moment()
        }, function(start, end, label) {
            $('#start').val(start.format('YYYY-MM-DD'))
            $('#end').val(end.format('YYYY-MM-DD'))
            causeListDataTable.ajax.reload();
        });



        $(document).ready(function() {
            let start_date = moment().subtract(7, 'days').format('YYYY-MM-DD');
            let end_date = moment().format('YYYY-MM-DD');
            $('#start').val(start_date)
            $('#end').val(end_date);
            causeListDataTable.ajax.reload();
        });


        $(document).on('submit', '#content_form', function(e) {
            e.preventDefault();
            causeListDataTable.ajax.reload();
        });


        

    </script>
@endpush
