@extends('layouts.master', ['title' => 'Subscriptions'])

@section('mainContent')


    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header xs_mb_0">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">Subscriptions List</h3>
                            <ul class="d-flex">
                                @can('subscription.create')
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                            href="{{ route('subscriptions.create') }}"><i class="ti-plus"></i>New
                                            Subscription</a></li>
                                @endcan
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <div class="row">
                                @foreach ($data as $subscription)
                                    <div class="col-md-3 col-sm-6 mb-4">
                                        <div class="card h-100 shadow-sm border-0">
                                            @if ($subscription->banner)
                                                <img src="{{ asset('public/' . $subscription->banner) }}"
                                                    class="card-img-top" alt="{{ $subscription->name }}" height="240"
                                                    width="350">
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $subscription->name }}</h5>
                                                <p class="card-text">{!! Str::limit($subscription->description, 100) !!}</p>

                                                <div class="mb-2">
                                                    <strong>Price:</strong>
                                                    @if ($subscription->offer_price)
                                                        <span
                                                            class="text-muted text-decoration-line-through">{{ $subscription->price }}
                                                            ৳</span>
                                                        <span class="text-success">{{ $subscription->offer_price }} ৳</span>
                                                    @else
                                                        <span>{{ $subscription->price }} ৳</span>
                                                    @endif
                                                </div>

                                                <div class="d-flex align-items-end flex-column bd-highlight">
                                                    <div class="dropdown CRM_dropdown d-inline ml-1">
                                                        <button class="btn btn-secondary dropdown-toggle mb-1"
                                                            type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            {{ __('common.Select') }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="dropdownMenu2">
                                                            @can('subscribtion.edit')
                                                                <a href="{{ route('subscriptions.edit', $subscription->id) }}"
                                                                    class="dropdown-item" >@lang('common.Edit')</a>
                                                            @endcan
                                                            @can('subscribtion.edit')
                                                                <a href="{{ route('subscriptions.show', $subscription->id) }}"
                                                                    class="dropdown-item" >@lang('common.Show')</a>
                                                            @endcan
                                                            @can('subscribtion.delete')
                                                                <a href="#" class="dropdown-item" type="button"
                                                                    data-toggle="modal" href="#"
                                                                    data-id="{{ @$subscription->id }}"
                                                                    data-target="#deleteItem_{{ @$subscription->id }}">@lang('role.Delete')</a>
                                                            @endcan

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @include('backEnd.partials.deleteModalMessage',[
                                        'item_id' => @$subscription->id,
                                        'item_name' => 'subscription',
                                        'route_url' => route('subscriptions.destroy',$subscription->id)])
                                @endforeach
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
    <script src="{{ asset('public/backEnd/') }}/vendors/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/vendors/js/dataTables.rowReorder.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/vendors/js/dataTables.responsive.min.js"></script>
@endpush
