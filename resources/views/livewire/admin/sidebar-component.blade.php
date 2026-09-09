<div>
    <aside class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div>
                <h4 class="logo-text">{{ config('app.name') }}</h4>
            </div>
            <div class="toggle-icon ms-auto"> <i class="bi bi-list"></i>
            </div>
        </div>
        <!--navigation-->
        <ul class="metismenu" id="menu">
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="fa-solid fa-shop"></i>
                    </div>
                    <div class="menu-title">{{ __('Products') }}</div>
                </a>
                <ul>
                    <li> <a href="{{ route('admin.products') }}"><i class="bi bi-circle"></i>{{ __('All Products') }}</a>
                    </li>
                    <li> <a href="{{ route('admin.add-products') }}"><i class="bi bi-circle"></i>{{ __('Add Products') }}</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div class="menu-title">{{ __('Category & Brands') }}</div>
                </a>
                <ul>
                    <li> <a href="{{ route('admin.categories') }}"><i class="bi bi-circle"></i>{{ __('All Categories') }}</a>
                    </li>
                    <li> <a href="{{ route('admin.add-categories') }}"><i class="bi bi-circle"></i>{{ __('Add Category') }}</a>
                    </li>
                </ul>
                <ul>
                    <li> <a href="{{ route('admin.brands') }}"><i class="bi bi-circle"></i>{{ __('All Brands') }}</a>
                    </li>
                    <li> <a href="{{ route('admin.add-brands') }}"><i class="bi bi-circle"></i>{{ __('Add Brands') }}</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="fa-solid fa-gear"></i>
                    </div>
                    <div class="menu-title">{{ __('Settings') }}</div>
                </a>
                <ul>
                    <li> <a href="{{ route('admin.settings') }}"><i class="bi bi-circle"></i>{{ __('General Setting') }}</a></li>
                    <li> <a href="{{ route('admin.settings.about') }}"><i class="bi bi-circle"></i>{{ __('About Setting') }}</a></li>
                    <li> <a href="{{ route('admin.settings.payment') }}"><i class="bi bi-circle"></i>{{ __('Payment Setting') }}</a></li>
                    <li> <a href="{{ route('admin.settings.meta') }}"><i class="bi bi-circle"></i>{{ __('Meta Setting') }}</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div class="menu-title">{{ __('Orders') }}</div>
                </a>
                <ul>
                    <li> <a href="{{route('admin.orders')}}"><i class="bi bi-circle"></i>{{ __('All Orders') }}</a></li>
                    <li> <a href="{{ route('admin.payment-review') }}"><i class="bi bi-circle"></i>{{ __('Payment Review') }}</a></li>
                </ul>
            </li>
        </ul>
        <!--end navigation-->
    </aside>
</div>
