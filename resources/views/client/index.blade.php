@extends('layouts.master', ['title' => __('client.Client')])

@section('mainContent')


    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header xs_mb_0">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('client.Client List') }}</h3>
                            <ul class="d-flex">
                                @if(permissionCheck('client.store'))
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                           href="{{ route('client.create') }}"><i class="ti-plus"></i>{{ __
                        ('client.New Client') }}</a></li>
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
                                <table class="table Crm_table_active3 data-table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.SL') }}</th>
                                        <th>{{ __('client.Client') }}</th>
                                        <th>{{ __('client.Contact') }}</th>
                                        <th>{{ __('client.Category') }}</th>
                                        <th>{{ __('client.Address') }}</th>
                                        <th>{{ __('common.Actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{-- @foreach($models as $model)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <a href="{{ route('client.show', $model->id) }}">{{ $model->name }}
                                                  @if(moduleStatusCheck('ClientLogin'))  [{{ $model->type }}] @endif
                                                </a>
                                            </td>
                                            <td>
                                                {{ __('client.Mobile') }}: {{ $model->mobile }} <br>
                                                {{ __('client.Email') }}: {{ $model->email }}
                                            </td>
                                            <td>{{ @$model->category->name }}</td>
                                            <td>
                                                {!! $model->address ? $model->address  .', <br>' : '' !!}
                                                {{ $model->state ? $model->state->name .', ' : ''}}
                                                {{ $model->city ? $model->city->name .', ' : '' }}
                                                {{ $model->country ? $model->country->name : '' }}
                                            </td>

                                            <td>


                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        {{ __('common.Select') }}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenu2">
                                                        @if(moduleStatusCheck('ClientLogin'))
                                                            @if(permissionCheck('client.legal-contract.assign'))
                                                                <a href="{{ route('client.legal-contract.assign', [$model->id]) }}"
                                                                    class="dropdown-item edit_brand">{{__('client.Legal Contract')}}</a>
                                                            @endif
                                                        @endif
                                                        @if(permissionCheck('client.show'))
                                                            <a href="{{ route('client.show', $model->id) }}"
                                                               class="dropdown-item edit_brand">{{__('common.Show')}}</a>
                                                        @endif
                                                        @if(permissionCheck('client.edit'))
                                                            <a href="{{ route('client.edit', $model->id) }}"
                                                               class="dropdown-item edit_brand">{{__('common.Edit')}}</a>
                                                        @endif
                                                        @if(permissionCheck('client.destroy'))
                                                            <span id="delete_item" data-id="{{ $model->id }}" data-url="{{ route
                                                                    ('client.destroy', $model->id)
                                                                    }}"
                                                                  class="dropdown-item"><i class="icon-trash"></i>
                                                                        {{ __('common.Delete') }} </span>
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


                @include('partials.delete_modal')
            </div>
        </div>
    </section>

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
   $('.data-table').DataTable({
                 processing: true,
                 serverSide: true,
                 "ajax": $.fn.dataTable.pipeline( {
                       url: "{{ route('client_list_datatable') }}",
                       pages: 2 // number of pages to cache

                   } ),
                   columns: [
                           {data: 'DT_RowIndex', name: 'id'},
                           {data: 'name', name: 'name'},
                           {data: 'email_mobile', name: 'email'},
                           {data: 'category', name: 'category.name'},
                           {data: 'address', name: 'address'},
                           {data: 'action', name: 'action', orderable: false, searchable: false},
                           {data: 'mobile', name: 'mobile',visible:false}
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

