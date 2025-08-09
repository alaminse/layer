@extends('layouts.master', ['title' => 'Subscription Details'])

@section('mainContent')
<section class="mb-40 student-details">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-3">
                <div class="main-title">
                    <h3 class="mb-20">Subscription Details</h3>
                </div>
                <div class="student-meta-box">
                    @if($subscription->banner && file_exists(public_path($subscription->banner)))
                        <img height="250" width="350"
                             src="{{ asset('public/' . $subscription->banner) }}"
                             alt="{{ $subscription->name }}">
                    @else
                        <img height="250" width="350"
                             src="{{ asset('public/backEnd/img/staff.jpg') }}"
                             alt="Default Image">
                    @endif

                    <div class="white-box">
                        <div class="single-meta mt-10">
                            <div class="d-flex justify-content-between">
                                <div class="name">Name</div>
                                <div class="value">{{ $subscription->name }}</div>
                            </div>
                        </div>

                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">Price</div>
                                <div class="value">{{ $subscription->price }} ৳</div>
                            </div>
                        </div>

                        @if($subscription->offer_price)
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">Offer Price</div>
                                <div class="value">{{ $subscription->offer_price }} ৳</div>
                            </div>
                        </div>
                        @endif

                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">{{ __('common.Status') }}</div>
                                <div class="value">
                                    @if($subscription->status) <span class="badge badge-success">Active</span>
                                    @else <span class="badge badge-danger">Inactive</span> @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Right Side - Details Tab -->
            <div class="col-lg-9 staff-details">
                <ul class="nav nav-tabs tabs_scroll_nav" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#subscriptionDetails" role="tab" data-toggle="tab">
                           Details
                        </a>
                    </li>
                    @can('subscriprion-edit')
                        <li class="nav-item edit-button">
                            <a href="{{ route('subscriptions.edit', $subscription->id) }}" class="primary-btn small fix-gr-bg">
                                {{ __('common.Edit') }}
                            </a>
                        </li>
                    @endcan
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade show active" id="subscriptionDetails">
                        <div class="white-box">
                            <h4 class="stu-sub-head">Subscription Description</h4>
                            {!! $subscription->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
