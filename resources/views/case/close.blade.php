@extends('layouts.master', ['title' => __('case.Case')])

@section('mainContent')

<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header xs_mb_0">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px" >{{ __('case.Closed Case') }}</h3>
                            <ul class="d-flex">
                                <li>

                                </li>
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
                                  
                                    </tbody>
                                </table>
                            </div>
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
    var type = "Close";
   $('.case-data-table').DataTable({
                    
                 processing: true,
                 serverSide: true,
                 "ajax": $.fn.dataTable.pipeline( {
                       url: SET_DOMAIN + '/case-list-datatable/'+type,
                       pages: 2 // number of pages to cache
                       
                   } ),
                   columns: [
                           {data: 'id', name: 'id'},                  
                           {data: 'case', name: 'case'},                  
                           {data: 'client', name: 'client'},
                           {data: 'details', name: 'details'},
                           {data: 'action', name: 'action', orderable: false, searchable: false},
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

