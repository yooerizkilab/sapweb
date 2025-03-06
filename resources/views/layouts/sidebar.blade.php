<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i class="fas fa-star-of-david"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'Laravel') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Nav::isRoute('home') }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>

    <!-- Nav Item - Business Partners Management Collapse Menu -->
    <li class="nav-item {{ request()->routeIs(['business-master.*']) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBusinessPartners"
            aria-expanded="true" aria-controls="collapseBusinessPartners">
            <i class="fas fa-fw fa-users"></i>
            <span>Business Partners</span>
        </a>
        <div id="collapseBusinessPartners" class="collapse {{ request()->routeIs(['business-master.*']) ? 'show' : '' }}" aria-labelledby="headingBusinessPartners"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('business-master.index') ? 'active' : '' }}" href="{{ route('business-master.index') }}">{{ __('Business Master') }}</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - A/R Sales -->
    <li class="nav-item {{ request()->routeIs(['sales-quotation.*', 'sales-order.*', 'delivery.*', 'invoice.*']) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSales"
            aria-expanded="true" aria-controls="collapseSales">
            <i class="fas fa-fw fa-cart-plus"></i>
            <span>A/R Sales</span>
        </a>
        <div id="collapseSales" class="collapse {{ request()->routeIs(['sales-quotation.*', 'sales-order.*', 'delivery.*', 'invoice.*']) ? 'show' : '' }}" aria-labelledby="headingSales"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('sales-quotation.*') ? 'active' : '' }}" href="{{ route('sales-quotation.index') }}">{{ __('Sales Quotation') }}</a>
                <a class="collapse-item {{ request()->routeIs('sales-order.*') ? 'active' : '' }}" href="{{ route('sales-order.index') }}">{{ __('Sales Order') }}</a>
                <a class="collapse-item {{ request()->routeIs('delivery.*') ? 'active' : '' }}" href="{{ route('delivery.index') }}">{{ __('Delivery') }}</a>
                <a class="collapse-item {{ request()->routeIs('invoice.*') ? 'active' : '' }}" href="{{ route('invoice.index') }}">{{ __('A/R Invoice') }}</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - A/P Purchasing -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePurchasing"
            aria-expanded="true" aria-controls="collapsePurchasing">
            <i class="fas fa-fw fa-cart-arrow-down"></i>
            <span>A/P Purchasing</span>
        </a>
        <div id="collapsePurchasing" class="collapse" aria-labelledby="headingPurchasing"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="">{{ __('Purchases Request') }}</a>
            </div>
        </div>  
    </li>

    <!-- Nav Item - Inventory -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInventory"
            aria-expanded="true" aria-controls="collapseInventory">
            <i class="fas fa-fw fa-truck-loading"></i>
            <span>Inventory</span>
        </a>
        <div id="collapseInventory" class="collapse" 
            aria-labelledby="headingInventory" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="">{{ __('Item Master Data') }}</a>
                <a class="collapse-item collapsed" href="#" data-toggle="collapse" data-target="#collapseLevel3"
                    aria-expanded="false" aria-controls="collapseLevel3">
                    Inventory Transaction
                </a>
                <div id="collapseLevel3" class="collapse" 
                    aria-labelledby="headingLevel3" data-parent="#collapseInventory">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="">{{ __('Goods Receipt') }}</a>
                        <a class="collapse-item" href="">{{ __('Goods Issue') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </li>

    <!-- Nav Item - Production -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduction"
            aria-expanded="true" aria-controls="collapseProduction">
            <i class="fas fa-fw fa-industry"></i>
            <span>Production</span>
        </a>
        <div id="collapseProduction" class="collapse" aria-labelledby="headingProduction"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="">{{ __('Bill of Materials') }}</a>
                <a class="collapse-item" href="">{{ __('Production Order') }}</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        {{ __('Settings') }}
    </div>

    <!-- Nav Item - Profile -->
    <li class="nav-item {{ Nav::isRoute('profile') }}">
        <a class="nav-link" href="{{ route('profile') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>{{ __('Profile') }}</span>
        </a>
    </li>

    <!-- Nav Item - About -->
    <li class="nav-item {{ Nav::isRoute('about') }}">
        <a class="nav-link" href="{{ route('about') }}">
            <i class="fas fa-fw fa-hands-helping"></i>
            <span>{{ __('About') }}</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>