<!-- sidebar part here -->
<nav id="sidebar" class="sidebar ">

    <div class="sidebar-header update_sidebar">
        <a class="large_logo" href="{{ url('/home') }}">
            <img src="{{ asset(config('configs.site_logo')) }}" alt="">
        </a>
        <a class="mini_logo" href="{{ url('/home') }}">
            <img src="{{ asset(config('configs.site_logo')) }}" alt="">
        </a>
        <a id="close_sidebar" class="d-lg-none">
            <i class="ti-close"></i>
        </a>
    </div>
    @if (moduleStatusCheck('AdvSaas') && SaasDomain()!='main' && !hasActiveSaasPlan() )
        <ul id="sidebar_menu">
            <li>
                <a href="#" class="has-arrow" aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-university"></span>
                    </div>
                    <div class="nav_title">
                        <span>{{ __('saas.Saas Management') }}</span>
                    </div>
                </a>

                <ul>
                    <li>
                        <a href="{{route('saas.my_plan')}}">{{__('saas.My Plan')}}</a>
                    </li>
                </ul>
            </li>
        </ul>
    @else
        @if (auth()->user()->role_id)
            <ul id="sidebar_menu">

                <li>
                    <a class="{{ spn_active_link('home') }}" href="{{ url('/home') }}">
                        <div class="nav_icon_small">
                            <span class="fas fa-th"></span>
                        </div>
                        <div class="nav_title">
                            <span>{{ __('dashboard.Dashboard') }}</span>
                        </div>
                    </a>
                </li>

                @if (moduleStatusCheck('AdvSaas') && SaasDomain()!='main')
                    <li>
                        <a href="#" class="has-arrow" aria-expanded="false">
                            <div class="nav_icon_small">
                                <span class="fas fa-university"></span>
                            </div>
                            <div class="nav_title">
                                <span>{{ __('saas.Saas Management') }}</span>
                            </div>
                        </a>

                        <ul>
                            <li>
                                <a href="{{route('saas.my_plan')}}">{{__('saas.My Plan')}}</a>
                            </li>
                        </ul>
                    </li>

                @endif

                @can('contact.index')

                    @php
                        $contact = ['contact.index', 'contact.create', 'contact.edit', 'contact.show'];
                        $category = ['contact.category.index', 'contact.category.create', 'contact.category.edit', 'contact.category.show'];
                        $nav = array_merge($contact, $category);
                    @endphp

                    <li class="{{ spn_nav_item_open($nav, 'mm-active') }}">
                        <a href="javascript:" class="has-arrow"
                           aria-expanded="{{ spn_nav_item_open($nav, 'true') }}">
                            <div class="nav_icon_small">
                                <span class="far fa-address-book"></span>
                            </div>
                            <div class="nav_title">
                                <span>{{ __('contact.Contact') }}</span>
                            </div>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('contact.index') }}"
                                   class="{{ spn_active_link($contact, 'active') }}">
                                    {{ __('contact.Contact List') }}</a>
                            </li>
                            @can ('contact.category.index')
                                <li>
                                    <a href="{{ route('category.contact.index') }}"
                                       class="{{ spn_active_link($category, 'active') }}">{{ __('contact.Contact  Category') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can ('client.index')
                    @php
                        $legalContracts = ['legal.contract.index','client.legal-contracts.view','legal.contract.assign','legal.contract.create','legal.contract.edit','legal.contract.show'];
                        $client = ['client.index', 'client.create', 'client.edit', 'client.show','client.legal-contract.assign'];
                        $category = ['client.category.index', 'client.category.create', 'client.category.edit', 'client.category.show'];
                        $nav = array_merge($client, $category, $legalContracts, ['client.settings','client.pending.list',]);

                    @endphp

                    <li class="{{ spn_nav_item_open($nav, 'mm-active') }}">

                        <a href="javascript:" class="has-arrow"
                           aria-expanded="{{ spn_nav_item_open($nav, 'true') }}">
                            <div class="nav_icon_small">
                                <span class="fas fa-users"></span>
                            </div>
                            <div class="nav_title">
                                <span>{{ __('client.Client') }}</span>
                            </div>
                        </a>
                        <ul>
                            @can ('client.index')
                                <li>
                                    <a href="{{ route('client.index') }}"
                                       class="{{ spn_active_link($client, 'active') }}">
                                        {{ __('client.Client List') }}</a>
                                </li>
                            @endcan

                            @can ('client.category.index')
                                <li>
                                    <a href="{{ route('category.client.index') }}"
                                       class="{{ spn_active_link($category, 'active') }}">{{ __('client.Category') }}</a>
                                </li>
                            @endcan
                            @if(moduleStatusCheck('ClientLogin'))
                                @includeIf('clientlogin::menu')
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- @if (permissionCheck('case.index'))
                    @php
                        $case = ['case.index', 'case.edit', 'case.show', 'date.create', 'date.edit', 'putlist.create', 'putlist.edit', 'judgement.create', 'judgement.edit', 'case.court.change', 'date.send_mail'];
                        $category = ['category.case.index', 'category.case.create', 'category.case.edit', 'category.case.show'];

                        $nav = array_merge($case, $category, ['causelist.index', 'case.create', 'judgement.index', 'judgement.closed', 'judgement.reopen', 'judgement.close', 'case.filter', 'case.pending-case']);
                    @endphp

                    <li class="{{ spn_nav_item_open($nav, 'mm-active') }}">

                        <a href="javascript:" class="has-arrow"
                           aria-expanded="{{ spn_nav_item_open($nav, 'true') }}">
                            <div class="nav_icon_small">

                                <span class="fas fa-list-ul"></span>
                            </div>
                            <div class="nav_title">
                                <span>{{ __('case.Case') }}</span>
                            </div>
                        </a>
                        <ul>
                            @if (permissionCheck('causelist.index'))
                                <li>
                                    <a href="{{ route('causelist.index') }}"
                                       class="{{ spn_active_link('causelist.index', 'active') }}">
                                        {{ __('case.Cause List') }}</a>
                                </li>
                            @endif

                            <li>
                                <a href="{{ route('case.index') }}"
                                   class="{{ (isset($page_title) and $page_title != 'Running') ? 'active' : '' }}">
                                    <span> {{ __('case.All Case') }} </span>
                                    <span class="demo_addons">{{ $all_cases }}</span>
                                </a>

                            </li>
                            <li>
                                <a href="{{ route('case.index', ['status' => 'Running']) }}"
                                   class="{{ (isset($page_title) and $page_title == 'Running') ? 'active' : '' }}">
                                    {{ __('case.Running Case') }}

                                    <span class="demo_addons">
                                    {{ $running_cases }}
                                </span>
                                </a>


                            </li>
                            @if(permissionCheck('case.store'))
                                <li>
                                    <a href="{{ route('case.create') }}"
                                       class="{{ spn_active_link('case.create', 'active') }}"> {{ __('case.Add New Case') }}</a>
                                </li>
                            @endif
                            @if(moduleStatusCheck('ClientLogin'))
                                <li>
                                    <a href="{{ route('case.pending-case') }}"
                                       class="{{ (isset($page_title) and $page_title == 'Pending') ? 'active' : '' }}">
                                        {{ __('case.Pending Case') }}

                                        @if (config('app.app_sync'))
                                            <span class="demo_addons addon"> Addon </span>
                                        @endif

                                    </a>
                                </li>
                            @endif
                            @if (permissionCheck('category.case.index'))
                                <li>
                                    <a href="{{ route('category.case.index') }}"
                                       class="{{ spn_active_link($category, 'active') }}">{{ __('case.Case  Category') }}</a>
                                </li>
                            @endif
                            @if (permissionCheck('category.subcase.index'))
                                <li>
                                    <a href="{{ route('category.subcase.index') }}"
                                       class="{{ spn_active_link($category, 'active') }}">Case Sub Category</a>
                                </li>
                            @endif

                            @if (permissionCheck('judgement.index'))
                                <li>
                                    <a href="{{ route('judgement.index') }}"
                                       class="{{ spn_active_link(['judgement.index', 'judgement.reopen', 'judgement.close'], 'active') }}">
                                        {{ __('case.Judgement Case') }}
                                        <span class="demo_addons">
                                        {{ $judgement_cases }}
                                    </span>
                                    </a>

                                </li>
                            @endif
                            @if (permissionCheck('judgement.closed'))
                                <li>
                                    <a href="{{ route('judgement.closed') }}"
                                       class="{{ spn_active_link(['judgement.closed'], 'active') }}">
                                        {{ __('case.Closed Case') }}
                                        <span class="demo_addons">
                                        {{ $closed_cases }}
                                    </span>
                                    </a>
                                </li>
                            @endif

                            @if (permissionCheck('case.filter'))
                                <li>
                                    <a href="{{ route('case.filter') }}"
                                       class="{{ spn_active_link(['case.filter'], 'active') }}">
                                        {{ __('case.Filter Case') }}</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif --}}

                {{-- @if (permissionCheck('lawyer.index'))
                    @php
                        $lawyer = ['lawyer.index', 'lawyer.create', 'lawyer.edit', 'lawyer.show'];
                    @endphp

                    <li class="{{ spn_active_link($lawyer, 'mm-active') }}">
                        <a href="{{ route('lawyer.index') }}">
                            <div class="nav_icon_small">
                                <span class="fas fa-users"></span>
                            </div>
                            <div class="nav_title">
                                <span> {{ __('lawyer.Opposite Lawyer') }}</span>
                            </div>
                        </a>
                    </li>
                @endif --}}


                {{-- @if (permissionCheck('lobbying.index'))
                    <li class="{{ spn_active_link(['lobbying.index', 'lobbying.edit', 'lobbying.show'], 'mm-active') }}">
                        <a href="{{ route('lobbying.index') }}">
                            <div class="nav_icon_small">
                                <span class="fas fa-th"></span>
                            </div>
                            <div class="nav_title">
                                <span> {{ __('case.Lobbying List') }}</span>
                            </div>
                        </a>
                    </li>
                @endif --}}
                {{-- @if (permissionCheck('putlist.index'))
                    <li class="{{ spn_active_link('putlist.index', 'mm-active') }}">
                        <a href="{{ route('putlist.index') }}">
                            <div class="nav_icon_small">
                                <span class="fas fa-th"></span>
                            </div>
                            <div class="nav_title">
                                <span> {{ __('case.Put Up Date List') }}</span>
                            </div>
                        </a>
                    </li>
                @endif --}}



                {{-- @if (permissionCheck('court.index'))
                    @php
                        $court = ['master.court.index', 'master.court.edit', 'master.court.show', 'master.court.create'];
                        $category = ['category.court.index', 'category.court.create', 'category.court.edit', 'category.court.show'];
                        $nav = array_merge($court, $category);
                    @endphp

                    <li class="{{ spn_nav_item_open($nav, 'mm-active') }}">
                        <a href="javascript:" class="has-arrow"
                           aria-expanded="{{ spn_nav_item_open($nav, 'true') }}">
                            <div class="nav_icon_small">
                                <span class="fas fa-gavel"></span>
                            </div>
                            <div class="nav_title">
                                <span>{{ __('court.Court') }}</span>
                            </div>
                        </a>
                        <ul>
                            @if (permissionCheck('master.court.index'))
                                <li>
                                    <a href="{{ route('master.court.index') }}"
                                       class="{{ spn_active_link($court, 'active') }}">
                                        {{ __('court.Court List') }}</a>
                                </li>
                            @endif
                            @if (permissionCheck('category.court.index'))
                                <li>
                                    <a href="{{ route('category.court.index') }}"
                                       class="{{ spn_active_link($category, 'active') }}">
                                        {{ __('court.Court Category') }}</a>
                                </li>
                            @endif

                        </ul>
                    </li>

                @endif --}}
                {{-- @if(moduleStatusCheck('Appointment'))
                    @includeIf('appointment::menu')
                @else
                    @if (permissionCheck('appointment.index'))
                        @php
                            $appoinment = ['appointment.index', 'appointment.create', 'appointment.edit', 'appointment.show'];
                        @endphp
                        @if (Route::has('appointment.index'))
                            <li class="{{ spn_active_link($appoinment, 'mm-active') }}">
                                <a href="{{ route('appointment.index') }}">
                                    <div class="nav_icon_small">
                                        <span class="far fa-handshake"></span>
                                    </div>
                                    <div class="nav_title">
                                        <span> {{ __('appointment.Appointment') }}</span>
                                    </div>
                                </a>
                            </li>
                        @endif
                    @endif
                @endif --}}
                {{-- @if(moduleStatusCheck('Zoom'))
                    @if (permissionCheck('zoom'))
                        @include('zoom::menu.zoom')
                    @endif
                @endif --}}
                {{-- @include('task::menu') --}}
                {{-- @include('todo::menu') --}}
                @include('partials.hr-menu')
                {{-- @include('leave::menu') --}}
                {{-- @if(moduleStatusCheck('CasePrint'))
                    @includeIf('caseprint::menu')
                @endif --}}


                {{-- @if (permissionCheck('setup'))
                    @php
                        $stage = ['master.stage.index', 'master.stage.edit', 'master.stage.show', 'master.stage.create'];
                        $act = ['master.act.index', 'master.act.edit', 'master.act.show', 'master.act.create'];
                        $city = ['setup.city.index', 'setup.city.edit', 'setup.city.show', 'setup.city.create'];
                        $state = ['setup.state.index', 'setup.state.edit', 'setup.state.show', 'setup.state.create'];
                        $country = ['setup.country.index', 'setup.country.edit', 'setup.country.show', 'setup.country.create'];

                        $nav = array_merge($stage, $act, $city, $state, $country);
                    @endphp

                    <li class="{{ spn_nav_item_open($nav, 'mm-active') }}">
                        <a href="javascript:" class="has-arrow"
                           aria-expanded="{{ spn_nav_item_open($nav, 'true') }}">
                            <div class="nav_icon_small">
                                <span class="fas fa-user"></span>
                            </div>
                            <div class="nav_title">
                                <span>{{ __('common.Setup') }}</span>
                            </div>
                        </a>
                        <ul>
                            @if (permissionCheck('master.stage.index'))
                                <li>
                                    <a href="{{ route('master.stage.index') }}"
                                       class="{{ spn_active_link($stage, 'active') }}">
                                        {{ __('case.Case Stage') }}</a>
                                </li>
                            @endif
                            @if (permissionCheck('master.act.index'))
                                <li>
                                    <a href="{{ route('master.act.index') }}"
                                       class="{{ spn_active_link($act, 'active') }}">{{ __('case.Act') }}</a>
                                </li>
                            @endif
                            @if (permissionCheck('setup.city.index') && !moduleStatusCheck('AdvSaas'))
                                <li>
                                    <a href="{{ route('setup.city.index') }}"
                                       class="{{ spn_active_link($city, 'active') }}">{{ __('setting.City') }}</a>
                                </li>
                            @endif

                            @if (permissionCheck('setup.state.index') && !moduleStatusCheck('AdvSaas'))
                                <li>
                                    <a href="{{ route('setup.state.index') }}"
                                       class="{{ spn_active_link($state, 'active') }}">{{ __('setting.State') }}</a>
                                </li>
                            @endif

                            @if (permissionCheck('setup.country.index') && !moduleStatusCheck('AdvSaas'))
                                <li>
                                    <a href="{{ route('setup.country.index') }}"
                                       class="{{ spn_active_link($country, 'active') }}">{{ __('court.Country') }}</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif --}}


                {{-- @if(moduleStatusCheck('CustomField'))
                    @includeIf('customfield::menu')
                @endif --}}

                {{-- @if(moduleStatusCheck('Finance'))
                    @includeIf('finance::menu')
                @endif --}}

                {{-- @if(moduleStatusCheck('EmailTemplate'))
                    @includeIf('emailtemplate::menu')
                @endif --}}

                {{-- @includeIf('setting::menu') --}}
            </ul>
        @else
            @if(moduleStatusCheck('ClientLogin'))
                @includeIf('clientlogin::sidebar')
            @endif
        @endif
    @endif
</nav>
<!-- sidebar part end -->
