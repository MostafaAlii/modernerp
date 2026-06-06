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
                <!-- Start Inv Uoms -->
                <li class="nav-item nav-hasmenu {{ is_open(['admin.invUoms.index']) }}">
                    <a href="#!" class="nav-link">
                        <span class="nav-icon"><i class="ti ti-scale"></i></span>
                        <span class="nav-text">{{ trans('dashboard/inv_uom.inv_uoms') }}</span>
                        <span class="nav-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="nav-submenu">
                        <li class="nav-item">
                            <a class="nav-link {{ is_active('admin.invUoms.index') }}" href="{{ route('admin.invUoms.index') }}">
                                {{ trans('dashboard/inv_uom.inv_uoms') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Inv Uoms -->
                <!-- Start Categories -->
                <li class="nav-item nav-hasmenu {{ is_open(['admin.categories.index']) }}">
                    <a href="#!" class="nav-link">
                        <span class="nav-icon"><i class="ti ti-layout-grid"></i></span>
                        <span class="nav-text">{{ trans('dashboard/categories.categories') }}</span>
                        <span class="nav-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="nav-submenu">
                        <li class="nav-item">
                            <a class="nav-link {{ is_active('admin.categories.index') }}" href="{{ route('admin.categories.index') }}">
                                {{ trans('dashboard/categories.categories') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Categories -->

                <!-- Start Sales Units -->
                <li class="nav-item nav-hasmenu {{ is_open(['admin.sales_units.index']) }}">
                    <a href="#!" class="nav-link">
                        <span class="nav-icon"><i class="ti ti-ruler"></i></span>
                        <span class="nav-text">{{ trans('dashboard/sales_units.sales_units') }}</span>
                        <span class="nav-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="nav-submenu">
                        <li class="nav-item">
                            <a class="nav-link {{ is_active('admin.sales_units.index') }}"
                            href="{{ route('admin.sales_units.index') }}">
                                {{ trans('dashboard/sales_units.sales_units') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Sales Units -->
                <!-- Start Sizes -->
                <li class="nav-item nav-hasmenu {{ is_open(['admin.sizes.index']) }}">
                    <a href="#!" class="nav-link">
                        <span class="nav-icon"><i class="ti ti-resize"></i></span>
                        <span class="nav-text">{{ trans('dashboard/sizes.sizes') }}</span>
                        <span class="nav-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="nav-submenu">
                        <li class="nav-item">
                            <a class="nav-link {{ is_active('admin.sizes.index') }}"
                            href="{{ route('admin.sizes.index') }}">
                                {{ trans('dashboard/sizes.sizes') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Sizes -->
            </ul>
        </div>
    </div>
</aside>
<!-- { navigation menu } end -->
