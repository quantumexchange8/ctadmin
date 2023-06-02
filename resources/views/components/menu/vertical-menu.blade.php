{{--

/**
*
* Created a new component <x-menu.vertical-menu/>.
*
*/

--}}


<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo">
                    <a href="{{getRouterValue();}}/dashboard/analytics">
                        <img src="{{Vite::asset('resources/images/ct-logo2.png')}}" class="navbar-logo logo-dark" alt="logo">
                        <img src="{{Vite::asset('resources/images/ct-logo.png')}}" class="navbar-logo logo-light" alt="logo">
                    </a>
                </div>
                <div class="nav-item theme-text">
                    <a href="{{getRouterValue();}}/dashboard/analytics" class="nav-link"> CurrentTech </a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                </div>
            </div>
        </div>
        @if (!Request::is('collapsible-menu/*'))
            <div class="profile-info">
                <div class="user-info">
                    <div class="profile-img">
                        <img src="{{Vite::asset('resources/images/profile-30.png')}}" alt="avatar">
                    </div>
                    <div class="profile-content">
                        <h6 class="">{{ auth()->user()->user_fullname }}</h6>
                        <p class="">{{ auth()->user()->user_role == 1 ? 'Admin' : 'User' }}</p>
                    </div>
                </div>
            </div>
        @endif
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu {{ Request::is('*/dashboard/*') ? "active" : "" }}">
                <a href="#dashboard" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/dashboard/*') ? "true" : "false" }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Dashboard</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('*/dashboard/*') ? "show" : "" }}" id="dashboard" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('analytics') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/dashboard/analytics"> Analytics </a>
                    </li>
                    <li class="{{ Request::routeIs('sales') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/dashboard/sales"> Sales </a>
                    </li>
                </ul>
            </li>

            <!-- Categories -->
            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>CATEGORIES</span></div>
            </li>

            <li class="menu {{ Request::is('*/category/*') || Request::is('*/web_template_category/*') ? "active" : "" }}">
                <a href="#category" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/category/*') ? "true" : "false" }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>Category</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('*/category/*') || Request::is('*/web_template_category/*') ? "show" : "" }}" id="category" data-bs-parent="#accordionExample">
                    <li class="{{ Request::is('*/category/category_add') || Request::is('*/category/category_edit/*') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/category/category_add"> Form </a>
                    </li>
                    <li class="{{ Request::routeIs('category_listing') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/category/category_listing"> Listing </a>
                    </li>
                    <li class="{{ Request::routeIs('*/web_template_category/*') ? 'active' : '' }}">
                        <a href="#web-template" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/web_template_category/*') ? "true" : "false" }}" class="dropdown-toggle collapsed"> Web Template <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                        <ul class="collapse list-unstyled sub-submenu {{ Request::is('*/web_template_category/*') ? "show" : "" }}" id="web-template" data-bs-parent="#pages">
                            <li class="{{ Request::is('*/web_template_category/web_template_category_add') || Request::is('*/web_template/web_template_add/*') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/web_template_category/web_template_category_add"> Form </a>
                            </li>
                            <li class="{{ Request::is('*/web_template_category/web_template_category_listing') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/web_template_category/web_template_category_listing"> List </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <!-- End Categories -->

            <!-- Products -->
            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>PRODUCTS</span></div>
            </li>

            <li class="menu {{ Request::is('*/product/*') ? "active" : "" }}">
                <a href="#product" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/product/*') ? "true" : "false" }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                        <span>Product</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('*/product/*') ? "show" : "" }}" id="product" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('product_add') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/product/product_add"> Form </a>
                    </li>
                    <li class="{{ Request::routeIs('product_listing') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/product/product_listing"> Listing </a>
                    </li>
                </ul>
            </li>

            <!-- End Products -->

            <!-- Orders -->
            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>ORDERS</span></div>
            </li>

            <li class="menu {{ Request::is('*/order/*') ? "active" : "" }}">
                <a href="#order" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/order/*') ? "true" : "false" }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        <span>Order</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('*/order/*') ? "show" : "" }}" id="order" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('order_add') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/order/order_add"> Form </a>
                    </li>
                    <li class="{{ Request::routeIs('order_listing') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/order/order_listing"> Listing </a>
                    </li>
                </ul>
            </li>

            <li class="menu {{ Request::is('*/report/*') ? "active" : "" }}">
                <a href="#invoice" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/report/*') ? "true" : "false" }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>Report</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('*/report/*') ? "show" : "" }}" id="invoice" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('report_listing') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/report/report_listing"> Listing </a>
                    </li>
                    <li class="{{ Request::routeIs('invoice-preview') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/app/invoice/preview"> Preview </a>
                    </li>
                    <li class="{{ Request::routeIs('invoice-add') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/app/invoice/add"> Add </a>
                    </li>
                    <li class="{{ Request::routeIs('invoice-edit') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/app/invoice/edit"> Edit </a>
                    </li>
                </ul>
            </li>
            <!-- End Products -->

            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>USER AND PAGES</span></div>
            </li>

            <li class="menu {{ Request::is('*/user/*') ? "active" : "" }}">
                <a href="#users" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/user/*') ? "true" : "false" }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span>User</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('*/user/*') ? "show" : "" }}" id="users" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('user_add') || Request::is('*/user_edit/*') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/user/user_add"> Form </a>
                    </li>
                    <li class="{{ Request::routeIs('user_listing') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/user/user_listing"> Listing </a>
                    </li>
                </ul>
            </li>

        </ul>

    </nav>

</div>
