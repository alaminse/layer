{{-- @if(permissionCheck('setting.index')) --}}
    @php
        $lang = ['languages.index', 'languages.edit', 'languages.show', 'languages.create' , 'language.translate_view'];
        $social = ['setting.social.index'];
        $nav = array_merge(['setting', 'modulemanager.index'],  ['setting.updatesystem'], $social)
    @endphp

    <li class="{{ spn_nav_item_open($nav, 'mm-active') }}">
        <a href="javascript:" class="has-arrow" aria-expanded="{{ spn_nav_item_open($nav, 'true') }}">
            <div class="nav_icon_small">

                <span class="fa fa-cog"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('setting.Settings') }}</span>
            </div>
        </a>
        <ul>
            <li>
                <a href="{{url('setting')}}"
                   class="{{ spn_active_link('setting', 'active') }}">  {{ __('setting.General Settings') }}</a>
            </li>

            {{-- @if(permissionCheck('modulemanager.index') && !moduleStatusCheck('AdvSaas')) --}}
            @if(!moduleStatusCheck('AdvSaas'))
                <li>
                    <a href="{{ route('modulemanager.index') }}"
                       class="{{ spn_active_link('modulemanager.index', 'active') }}">{{ __('common.Module Manager') }}</a>
                </li>
            @endif

            {{-- @if(permissionCheck('languages.index') && !moduleStatusCheck('AdvSaas')) --}}
            @if(!moduleStatusCheck('AdvSaas'))
                <li>
                    <a href="{{ route('languages.index') }}"
                       class="{{ spn_active_link($lang, 'active') }}">{{ __('common.Language') }}</a>
                </li>
            @endif
            @if(moduleStatusCheck('ClientLogin'))
                {{-- @if(permissionCheck('setting.social.index')) --}}
                    <li>
                        <a href="{{ route('setting.social.index') }}"
                        class="{{ spn_active_link($lang, 'active') }}">

                            {{ __('client.Social Login') }}
                                @if (config('app.app_sync'))
                                    <span class="demo_addons addon mr-4"> Addon </span>
                                @endif

                        </a>
                    </li>
                {{-- @endif --}}
            @endif


            {{-- @if(permissionCheck('setting.updatesystem') && !moduleStatusCheck('AdvSaas')) --}}
            @if(!moduleStatusCheck('AdvSaas'))
                <li>
                    <a href="{{ route('setting.updatesystem') }}"
                       class="{{ spn_active_link('setting.updatesystem', 'active') }}">{{ __('setting.Update') }}</a>
                </li>
            @endif

        </ul>
    </li>


{{-- @endif --}}
{{-- @if(permissionCheck('style.index')) --}}
    @php
        $theme = ['themes.index', 'themes.edit', 'themes.show', 'themes.create'];
        $nav = array_merge($theme)
    @endphp

    <li class="{{ spn_nav_item_open($nav, 'mm-active') }}">
        <a href="javascript:" class="has-arrow" aria-expanded="{{ spn_nav_item_open($nav, 'true') }}">
            <div class="nav_icon_small">

                <span class="fas fa-store"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('setting.Styles') }}</span>
            </div>
        </a>
        <ul>
            {{-- @if(permissionCheck('themes.index')) --}}
                <li>
                    <a href="{{ route('themes.index') }}"
                       class="{{ spn_active_link($theme, 'active') }}">{{ __('setting.Theme Customization') }}</a>
                </li>
            {{-- @endif --}}

        </ul>
    </li>

{{-- @endif --}}

{{-- @if(permissionCheck('utilities') && !moduleStatusCheck('AdvSaas')) --}}
@if(!moduleStatusCheck('AdvSaas'))
    <li class="{{ spn_active_link('utilities', 'mm-active') }}">
        <a href="{{ route('utilities') }}">
            <div class="nav_icon_small">
                <span class="fas fa-store"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('setting.Utilities') }}</span>
            </div>
        </a>
    </li>
@endif


