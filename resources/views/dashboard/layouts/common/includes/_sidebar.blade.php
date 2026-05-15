<!-- { navigation menu } start -->
<aside class="app-sidebar app-light-sidebar">
    <div class="app-navbar-wrapper">
        <div class="brand-link brand-logo">
            <a href="{{ guard_dashboard_route() }}" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                <img src="{{ $logo }}" alt="" class="logo logo-lg" width="223" height="35" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="app-navbar">
                <li class="nav-item {{ is_active('admin.dashboard') }}">
                    <a href="{{ guard_dashboard_route() }}" class="nav-link">
                        <span class="nav-icon">
                            <i class="ti ti-layout-2"></i>
                        </span>
                        <span class="nav-text">{{trans('dashboard/header.main_dashboard') }}</span>

                    </a>
                </li>
                <!-- Start AdminPanelSetting -->
                <li class="nav-item nav-hasmenu {{ is_open(['admin.mainSettings.index']) }}">
                    <a href="#!" class="nav-link"><span class="nav-icon"><i class="ti ti-layout-2"></i></span><span
                            class="nav-text">{{ trans('dashboard/sidebar.admin_main_settings_sidebar_title') }}</span><span class="nav-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="nav-submenu">
                        <li class="nav-item">
                            <a class="nav-link {{ is_active('admin.mainSettings.index') }}" href="{{route('admin.mainSettings.index')}}">{{ trans('dashboard/sidebar.main_settings_sidebar_title') }}</a>
                        </li>
                    </ul>
                </li>
                <!-- End AdminPanelSetting -->
                
                    
                @ownerOnly
                <!-- Start Client -->
                <li class="nav-item nav-hasmenu {{ is_open(['admin.clients.index']) }}">
                    <a href="#!" class="nav-link"><span class="nav-icon"><i class="ti ti-award"></i></span><span class="nav-text">{{
                            trans('dashboard/sidebar.admin_client_sidebar_title') }}</span><span class="nav-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="nav-submenu">
                        <li class="nav-item">
                            <a class="nav-link {{ is_active('admin.clients.index') }}"
                                href="{{route('admin.clients.index')}}">{{
                                trans('dashboard/sidebar.client_sidebar_title')
                                }}</a>
                        </li>
                    </ul>
                </li>
                <!-- End Client -->
                @endOwnerOnly

                <li class="nav-item nav-hasmenu {{ is_open(['admin.treasuries.index']) }}">
                    <a href="#!" class="nav-link">
                        <span class="nav-icon"><i class="ti ti-building-bank"></i></span>
                        <span class="nav-text">{{ trans('dashboard/treasury.treasuries') }}</span>
                        <span class="nav-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="nav-submenu">
                        <li class="nav-item">
                            <a class="nav-link {{ is_active('admin.treasuries.index') }}"
                            href="{{ route('admin.treasuries.index') }}">
                                {{ trans('dashboard/treasury.treasuries') }}
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Start SalesMatrialType -->
                <li class="nav-item nav-hasmenu {{ is_open(['admin.salesMatrialTypes.index']) }}">
                    <a href="#!" class="nav-link">
                        <span class="nav-icon"><i class="ti ti-tag"></i></span>
                        <span class="nav-text">{{ trans('dashboard/sales_matrial_type.sales_matrial_types') }}</span>
                        <span class="nav-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="nav-submenu">
                        <li class="nav-item">
                            <a class="nav-link {{ is_active('admin.salesMatrialTypes.index') }}"
                                href="{{ route('admin.salesMatrialTypes.index') }}">
                                {{ trans('dashboard/sales_matrial_type.sales_matrial_types') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End SalesMatrialType -->

                <!-- Start Stores -->
                <li class="nav-item nav-hasmenu {{ is_open(['admin.stores.index']) }}">
                    <a href="#!" class="nav-link">
                        <span class="nav-icon"><i class="ti ti-building-warehouse"></i></span>
                        <span class="nav-text">{{ trans('dashboard/store.stores') }}</span>
                        <span class="nav-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="nav-submenu">
                        <li class="nav-item">
                            <a class="nav-link {{ is_active('admin.stores.index') }}" href="{{ route('admin.stores.index') }}">
                                {{ trans('dashboard/store.stores') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Stores -->
            </ul>
        </div>
    </div>
</aside>
<!-- { navigation menu } end -->
