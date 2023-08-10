<!-- main-header -->
<!-- main-header opened -->
<div class="main-header nav nav-item hor-header">
    <div class="container">
        <div class="main-header-left ">
            <a class="animated-arrow horizontal-toggle horizontal-navtoggle"><span></span></a><!-- sidebar-toggle-->
            <a class="header-brand" href="{{ url('/') }}">
                <img src="assets/img/brand/LMS.png" class="desktop-logo">
            </a>
        </div><!-- search -->
        <div class="main-header-right">
           {{--  <ul class="nav">
                <li class="">
                    <div class="dropdown  nav-itemd-none d-md-flex">
                        <a href="#" class="d-flex  nav-item nav-link pe-0 country-flag1" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="avatar country-Flag me-0 align-self-center bg-transparent"><img
                                    src="https://laravel.spruko.com/valex/ltr/assets/img/flags/us_flag.jpg"
                                    alt="img"></span>
                            <div class="my-auto">
                                <strong class="me-2 ms-2 my-auto">English</strong>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow" x-placement="bottom-end">
                            <a href="#" class="dropdown-item d-flex ">
                                <span class="avatar  me-3 align-self-center bg-transparent"><img
                                        src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0d/Flag_of_Saudi_Arabia.svg/800px-Flag_of_Saudi_Arabia.svg.png"
                                        alt="img"></span>
                                <div class="d-flex">
                                    <span class="mt-2">Arabic</span>
                                </div>
                            </a>

                        </div>
                    </div>
                </li>
            </ul>
            <ul class="nav">
                <div class="nav-item full-screen fullscreen-button">
                    <a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                            class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3">
                            </path>
                        </svg></a>
                </div>
            </ul>--}}
            <ul class="nav">
                <a target="_blank" href="http://192.168.43.138/clinic/index.php?user_session={{ Auth::user()->id }}">
                    <b class="btn btn-main-primary pd-x-20">
                        <i class="fas fa-stethoscope"></i>
                        Clinic
                    </b>
                </a>
                {{-- <button class="btn btn-main-primary pd-x-20" type="submit">Clinic</button>--}}
            </ul>

            <ul class="nav">
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <b class="label text-danger ">
                        <i class="bx bx-log-out"></i>
                        Sign Out
                    </b>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                       
                    </form>  
                </a>
            </ul>
            <div class="nav nav-item  navbar-nav-right ms-auto">

               {{-- <div class="dropdown nav-item main-header-message ">
                    <a class="new nav-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg><span class=" pulse-danger"></span></a>
                    <div class="dropdown-menu">
                        <div class="menu-header-content bg-primary text-start">
                            <div class="d-flex">
                                <h6 class="dropdown-title mb-1 tx-15 text-white fw-semibold">Messages</h6>
                                <span class="badge rounded-pill bg-warning ms-auto my-auto float-end">Mark All
                                    Read</span>
                            </div>
                            <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">You have 4
                                unread messages</p>
                        </div>
                        <div class="main-message-list chat-scroll">
                            <a href="#" class="p-3 d-flex border-bottom">
                                <div class="  drop-img  cover-image  "
                                    data-bs-image-src="https://laravel.spruko.com/valex/ltr/assets/img/faces/3.jpg">
                                    <span class="avatar-status bg-teal"></span>
                                </div>
                                <div class="wd-90p">
                                    <div class="d-flex">
                                        <h5 class="mb-1 name">Petey Cruiser</h5>
                                    </div>
                                    <p class="mb-0 desc">I'm sorry but i'm not sure how to help you with
                                        that......</p>
                                    <p class="time mb-0 text-start float-start ms-2 mt-2">Mar 15 3:55 PM</p>
                                </div>
                            </a>
                            <a href="#" class="p-3 d-flex border-bottom">
                                <div class="drop-img cover-image"
                                    data-bs-image-src="https://laravel.spruko.com/valex/ltr/assets/img/faces/2.jpg">
                                    <span class="avatar-status bg-teal"></span>
                                </div>
                                <div class="wd-90p">
                                    <div class="d-flex">
                                        <h5 class="mb-1 name">Jimmy Changa</h5>
                                    </div>
                                    <p class="mb-0 desc">All set ! Now, time to get to you now......</p>
                                    <p class="time mb-0 text-start float-start ms-2 mt-2">Mar 06 01:12 AM</p>
                                </div>
                            </a>
                            <a href="#" class="p-3 d-flex border-bottom">
                                <div class="drop-img cover-image"
                                    data-bs-image-src="https://laravel.spruko.com/valex/ltr/assets/img/faces/9.jpg">
                                    <span class="avatar-status bg-teal"></span>
                                </div>
                                <div class="wd-90p">
                                    <div class="d-flex">
                                        <h5 class="mb-1 name">Graham Cracker</h5>
                                    </div>
                                    <p class="mb-0 desc">Are you ready to pickup your Delivery...</p>
                                    <p class="time mb-0 text-start float-start ms-2 mt-2">Feb 25 10:35 AM</p>
                                </div>
                            </a>
                            <a href="#" class="p-3 d-flex border-bottom">
                                <div class="drop-img cover-image"
                                    data-bs-image-src="https://laravel.spruko.com/valex/ltr/assets/img/faces/12.jpg">
                                    <span class="avatar-status bg-teal"></span>
                                </div>
                                <div class="wd-90p">
                                    <div class="d-flex">
                                        <h5 class="mb-1 name">Donatella Nobatti</h5>
                                    </div>
                                    <p class="mb-0 desc">Here are some products ...</p>
                                    <p class="time mb-0 text-start float-start ms-2 mt-2">Feb 12 05:12 PM</p>
                                </div>
                            </a>
                            <a href="#" class="p-3 d-flex border-bottom">
                                <div class="drop-img cover-image"
                                    data-bs-image-src="https://laravel.spruko.com/valex/ltr/assets/img/faces/5.jpg">
                                    <span class="avatar-status bg-teal"></span>
                                </div>
                                <div class="wd-90p">
                                    <div class="d-flex">
                                        <h5 class="mb-1 name">Anne Fibbiyon</h5>
                                    </div>
                                    <p class="mb-0 desc">I'm sorry but i'm not sure how...</p>
                                    <p class="time mb-0 text-start float-start ms-2 mt-2">Jan 29 03:16 PM</p>
                                </div>
                            </a>
                        </div>
                        <div class="text-center dropdown-footer">
                            <a href="https://laravel.spruko.com/valex/ltr/chat">VIEW ALL</a>
                        </div>
                    </div>
                </div>  
                <div class="dropdown nav-item main-header-notification">
                    <a class="new nav-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg><span class=" pulse"></span></a>
                    <div class="dropdown-menu">
                        <div class="menu-header-content bg-primary text-start">
                            <div class="d-flex">
                                <h6 class="dropdown-title mb-1 tx-15 text-white fw-semibold">Notifications</h6>
                                <span class="badge rounded-pill bg-warning ms-auto my-auto float-end">Mark All
                                    Read</span>
                            </div>
                            <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">You have 4
                                unread Notifications</p>
                        </div>
                        <div class="main-notification-list Notification-scroll">
                            <a class="d-flex p-3 border-bottom" href="#">
                                <div class="notifyimg bg-pink">
                                    <i class="la la-file-alt text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="notification-label mb-1">New files available</h5>
                                    <div class="notification-subtext">10 hour ago</div>
                                </div>
                                <div class="ms-auto">
                                    <i class="las la-angle-right text-end text-muted"></i>
                                </div>
                            </a>
                            <a class="d-flex p-3 border-bottom" href="#">
                                <div class="notifyimg bg-purple">
                                    <i class="la la-gem text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="notification-label mb-1">Updates Available</h5>
                                    <div class="notification-subtext">2 days ago</div>
                                </div>
                                <div class="ms-auto">
                                    <i class="las la-angle-right text-end text-muted"></i>
                                </div>
                            </a>
                            <a class="d-flex p-3 border-bottom" href="#">
                                <div class="notifyimg bg-success">
                                    <i class="la la-shopping-basket text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="notification-label mb-1">New Order Received</h5>
                                    <div class="notification-subtext">1 hour ago</div>
                                </div>
                                <div class="ms-auto">
                                    <i class="las la-angle-right text-end text-muted"></i>
                                </div>
                            </a>
                            <a class="d-flex p-3 border-bottom" href="#">
                                <div class="notifyimg bg-warning">
                                    <i class="la la-envelope-open text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="notification-label mb-1">New review received</h5>
                                    <div class="notification-subtext">1 day ago</div>
                                </div>
                                <div class="ms-auto">
                                    <i class="las la-angle-right text-end text-muted"></i>
                                </div>
                            </a>
                            <a class="d-flex p-3 border-bottom" href="#">
                                <div class="notifyimg bg-danger">
                                    <i class="la la-user-check text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="notification-label mb-1">22 verified registrations</h5>
                                    <div class="notification-subtext">2 hour ago</div>
                                </div>
                                <div class="ms-auto">
                                    <i class="las la-angle-right text-end text-muted"></i>
                                </div>
                            </a>
                            <a class="d-flex p-3 border-bottom" href="#">
                                <div class="notifyimg bg-primary">
                                    <i class="la la-check-circle text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="notification-label mb-1">Project has been approved</h5>
                                    <div class="notification-subtext">4 hour ago</div>
                                </div>
                                <div class="ms-auto">
                                    <i class="las la-angle-right text-end text-muted"></i>
                                </div>
                            </a>
                        </div>
                        <div class="dropdown-footer">
                            <a href="https://laravel.spruko.com/valex/ltr/notification">VIEW ALL</a>
                        </div>
                    </div>
                </div>
                <div class="nav-item full-screen fullscreen-button">
                    <a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                            class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3">
                            </path>
                        </svg></a>
                </div>
                <div class="dropdown main-profile-menu nav nav-item nav-link">
                    <a class="profile-user d-flex" href=""><img alt=""
                            src="https://laravel.spruko.com/valex/ltr/assets/img/faces/6.jpg"></a>
                    <div class="dropdown-menu">
                        <div class="main-header-profile bg-primary p-3">
                            <div class="d-flex wd-100p">
                                <div class="main-img-user"><img alt=""
                                        src="https://laravel.spruko.com/valex/ltr/assets/img/faces/6.jpg" class="">
                                </div>
                                <div class="ms-3 my-auto">
                                    <h6>{{ Auth::user()->name }}</h6><span>{{ Auth::user()->email }}</span>
                                </div>
                            </div>
                        </div>
                        <a class="dropdown-item" href="https://laravel.spruko.com/valex/ltr/profile"><i
                                class="bx bx-user-circle"></i>Profile</a>
                        <a class="dropdown-item" href="https://laravel.spruko.com/valex/ltr/editprofile"><i
                                class="bx bx-cog"></i> Edit Profile</a>
                        <a class="dropdown-item" href=""><i class="bx bxs-inbox"></i>Inbox</a>
                        <a class="dropdown-item" href=""><i class="bx bx-envelope"></i>Messages</a>
                        <a class="dropdown-item" href=""><i class="bx bx-slider-alt"></i> Account
                            Settings</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                class="bx bx-log-out"></i>Sign Out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
--}}
            </div>

        </div>

    </div>
</div>
<!-- /main-header -->
<!-- main-header -->


<!-- /centerlogo-header closed -->
<!--/main-header -->

<!-- main-header -->
<!--Horizontal-main -->
<div class="sticky">
    <div class="horizontal-main hor-menu clearfix side-header">
        <div class="horizontal-mainwrapper container clearfix">
            <!--Nav-->
            <nav class="horizontalMenu clearfix">

                <ul class="horizontalMenu-list">

                    <li aria-haspopup="true"><a href="{{ url('/') }}" class=""><i
                                class="fas fa-tachometer-alt"></i>Dashboard</a></li>


                    @can('Administration')
                    <li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fas fa-tools"></i>
                            Administration<i class="fe fe-chevron-down horizontal-icon"></i></a>
                        <ul class="sub-menu">
                            @can('Branches')
                            <li aria-haspopup="true" class="sub-menu-sub"><a href="#">Branches</a>
                                <ul class="sub-menu">
                                    @can('Regions')
                                    <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'regions')) }}"
                                            class="slide-item">Regions</a>
                                    </li>
                                    @endcan

                                    @can('Branches')
                                    <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'branches')) }}"
                                            class="slide-item">Branches</a></li>
                                    @endcan

                                    @can('Clinical Units')
                                    <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'open_Clinical_units')) }}"
                                            class="slide-item">Clinical Units</a></li>
                                    @endcan

                                    @can('Clinical Group
                                    Comments')
                                    <li aria-haspopup="true"><a href="#" class="slide-item">Clinical Group
                                            Comments</a></li>
                                    @endcan
                                </ul>
                            </li>
                            @endcan

                            @can('Administrator')
                            <li aria-haspopup="true" class="sub-menu-sub"><a href="#">Administrator</a>
                                <ul class="sub-menu">
                                    @can('Users Roles')
                                    <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'roles')) }}"
                                            class="slide-item">Manage Users Roles</a>
                                    </li>
                                    @endcan

                                    @can('Manage Users')
                                    <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'users')) }}"
                                            class="slide-item">Manage Users</a>
                                    </li>
                                    @endcan

                                </ul>
                            </li>
                            @endcan
{{-- Manage Call Center --}}
                            @can('Manage Analyzers')
                            <li aria-haspopup="true" class="sub-menu-sub"><a href="#">Call Center Managment</a>
                                <ul class="sub-menu">
                                    <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'App_General_Setting')) }}"
                                        class="slide-item">App. General Setting</a>
                                </li>
                                <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'appBranches')) }}"
                                    class="slide-item">App. Branches</a>
                            </li>
                                    <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'open_Area')) }}"
                                        class="slide-item">Manage Areas</a>
                                </li>
                                <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'open_LabTechDrivers')) }}"
                                    class="slide-item">Manage MLT (HS Drivers)</a>
                            </li>
                            <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'open_AppUsers')) }}"
                                class="slide-item">Manage App. User</a>
                        </li>
                                
                                </ul>
                            </li>
                            @endcan

                            @can('Manage Analyzers')
                            <li aria-haspopup="true" class="sub-menu-sub"><a href="#">Analyzers</a>
                                <ul class="sub-menu">
                                   
                                    <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'Analyzers')) }}"
                                            class="slide-item">Manage Analyzers</a>
                                    </li>
                                    
                                </ul>
                            </li>
                            @endcan

                            @can('Services Setup')
                            <li aria-haspopup="true" class="sub-menu-sub"><a href="#">Services Setup</a>
                                <ul class="sub-menu">
                                    @can('Samples')
                                    <li aria-haspopup="true" class="slide-item sub-menu-sub"><a href="#">Samples</a>
                                        <ul class="sub-menu">
                                            @can('Sample Types')
                                            <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'sample_types')) }}"
                                                    class="slide-item">Sample Types</a></li>
                                            @endcan
                                            {{-- <li aria-haspopup="true"><a href="#" class="slide-item">Sample
                                                    Status</a></li> --}}
                                            @can('Monitor Sample Location Requests')
                                            <li aria-haspopup="true"><a
                                                    href="{{ url('/' . ($page = 'sampleLocation')) }}"
                                                    class="slide-item">Sample
                                                    Location Request</a>
                                            </li>
                                            @endcan
                                            @can('Monitor Sample Location Requests')
                                            <li aria-haspopup="true"><a
                                                    href="{{ url('/' . ($page = 'monitor_sampleLocation')) }}"
                                                    class="">Monitor
                                                    Sample
                                                    Location Requests</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </li>
                                    @endcan

                                    @can('Tests')
                                    <li aria-haspopup="true" class="slide-item sub-menu-sub"><a href="#">Tests</a>
                                        <ul class="sub-menu">
                                            @can('Units of Measure')
                                            <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'units')) }}"
                                                    class="slide-item">Units of Measure</a>
                                            </li>
                                            @endcan

                                            @can('Manage Tests')
                                            <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'tests')) }}"
                                                    class="slide-item">Manage Tests</a>
                                            </li>
                                            @endcan

                                            @can('Organisms')
                                            <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'organisms')) }}"
                                                    class="slide-item">Organisms</a>
                                            </li>
                                            @endcan

                                            @can('Antibiotic')
                                            <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'antibiotics')) }}"
                                                    class="slide-item">Antibiotic</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </li>
                                    @endcan
                                    @can('Services')
                                    <li aria-haspopup="true" class="slide-item sub-menu-sub"><a href="#">Services</a>
                                        <ul class="sub-menu">
                                            @can('Manage Services')
                                            <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'services')) }}"
                                                    class="slide-item">Manage Services</a>
                                            </li>
                                            @endcan
                                            @can('Manage Extra Services')
                                            <li aria-haspopup="true"><a
                                                    href="{{ url('/' . ($page = 'extra_services')) }}"
                                                    class="slide-item">Manage Extra Services</a>
                                            </li>
                                            @endcan
                                            @can('Assign Service To Processing Unit')
                                            <li aria-haspopup="true"><a
                                                    href="{{ url('/' . ($page = 'assign_service_to_processing_unit')) }}"
                                                    class=""> Assign Service To Processing Unit</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcan
                            @can('General Setup')
                            <li aria-haspopup="true" class="sub-menu-sub"><a href="#">General Setup</a>
                                <ul class="sub-menu">
                                    @can('Preparation')
                                    <li aria-haspopup="true" class="slide-item sub-menu-sub"><a href="#">Preparation
                                        </a>
                                        <ul class="sub-menu">
                                            @can('Questions')
                                            <li aria-haspopup="true"><a
                                                    href="{{ url('/' . ($page = 'preparation_questions')) }}"
                                                    class="slide-item">Questions</a></li>
                                            @endcan
                                            @can('Cancel Reasons')
                                            <li aria-haspopup="true"><a
                                                    href="{{ url('/' . ($page = 'cancel_reasons')) }}"
                                                    class="slide-item">Cancel Reasons</a></li>
                                            @endcan
                                        </ul>
                                    </li>
                                    @endcan
                                    @can('Non Clinical Users')
                                    <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'NonClinicalUsers')) }}"
                                            class="slide-item">Non Clinical Users</a>
                                    </li>
                                    <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'referringDoctors')) }}"
                                        class="slide-item">Referring Doctors</a>
                                </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcan

                            @can('Financial')
                            <li aria-haspopup="true" class="sub-menu-sub"><a href="#">Financial</a>
                                <ul class="sub-menu">
                                    @can('Price Lists')
                                    <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'price_lists')) }}"
                                            class="slide-item">Price Lists</a>
                                    </li>
                                    @endcan
                                    @can('Financial')
                                    <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'payers')) }}"
                                            class="slide-item">Payers</a></li>
                                    @endcan
                                    @can('Contract Classifications')
                                    <li aria-haspopup="true"><a
                                            href="{{ url('/' . ($page = 'contract_classifications')) }}"
                                            class="slide-item">Contract Classifications </a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcan
                            @can('Financial')
                            <li aria-haspopup="true" class="slide-item sub-menu-sub"><a href="#">Treasuries</a>
                                <ul class="sub-menu">
                                    @can('Manage Treasuries')
                                    <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'treasuries')) }}"
                                            class="slide-item">Manage Treasuries</a></li>
                                    @endcan
                                    @can('Treasury Requests')
                                    <li aria-haspopup="true"><a
                                            href="{{ url('/' . ($page = 'open_treasuries_requests')) }}"
                                            class="slide-item">Treasury Requests</a></li>
                                    @endcan
                                    @can('Handling Treasury Request')
                                    <li aria-haspopup="true"><a
                                            href="{{ url('/' . ($page = 'open_handle_treasuries_requests')) }}"
                                            class="">Handling Treasury Request</a></li>
                                   
                                    @endcan
                                </ul>
                            </li>
                            @endcan
                            @can('Discount Comments')
                            <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'discount_comments')) }}"
                                    class="slide-item">Discount Comments</a></li>
                            @endcan
                            @can('Currencies')
                            <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'currencies')) }}"
                                    class="slide-item">Currencies</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcan

                    @can('Registration')
                    <li aria-haspopup="true">
                        @can('Registration')
                        <a href="#" class="sub-icon">
                            <i class="fas fa-keyboard"></i></i>Registration<i
                                class="fe fe-chevron-down horizontal-icon"></i></a>
                        @endcan
                        <ul class="sub-menu">
                            @can('Patient Registration')
                            <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'registration')) }}"
                                    class="slide-item">Patient Registration</a></li>

                            @endcan
                            @can('Search Registration')
                            <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'searchregistration')) }}"
                                    class="slide-item">Search Registration</a></li>
                            @endcan

                            @can('Search Registration')
                            <li ><a href="#">----- House Call Services -----</a></li>        

                            <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'homeservices?pagename=newRegistration')) }}"
                                class="slide-item">Create Home Services</a></li>        

                            <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'homeservices')) }}"
                                    class="slide-item">Search Home Services</a></li>
                            
                            @endcan
                            
                        </ul>
                    </li>
                    @endcan

                    @can('Financial')
                    <li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fas fa-comment-dollar"></i>
                            Financial<i class="fe fe-chevron-down horizontal-icon"></i></a>
                        <ul class="sub-menu">
                            @can('Search Payment')
                            <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'SearchPayment')) }}"
                                    class="slide-item">Search Payment</a></li>
                            @endcan

                            @can('Receipt List')
                            <li aria-haspopup="true"><a
                                    href="{{ url('/' . ($page = 'SearchPayment?pagename=Receipt_List')) }}"
                                    class="slide-item">Receipt List</a></li>
                            @endcan

                            @can('Claims')
                            <li aria-haspopup="true" class="slide-item sub-menu-sub"><a href="#">Claims</a>
                                <ul class="sub-menu">
                                    @can('Financial Claims')
                                    <li aria-haspopup="true"><a
                                            href="{{ url('/' . ($page = 'SearchPayment?pagename=Financial_Claim')) }}"
                                            class="slide-item">Financial Claims</a></li>
                                    @endcan

                                    @can('Monthly Claims')
                                    <li aria-haspopup="true"><a
                                            href="{{ url('/' . ($page = 'open_treasuries_requests')) }}"
                                            class="slide-item">Monthly Claims</a></li>
                                    @endcan
                                </ul>
                            </li>
                            @endcan


                        </ul>
                    </li>
                    @endcan

                    @can('Results')
                    <li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fas fa-poll"></i> Results<i
                                class="fe fe-chevron-down horizontal-icon"></i></a>
                        <ul class="sub-menu">
                            @can('Search Results')
                            <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'results')) }}"
                                    class="slide-item">Search Results</a></li>
                            @endcan

                            @can('Results delivery')
                            <li aria-haspopup="true"><a
                                    href="{{ url('/' . ($page = 'results?pagename=Results_Delivery')) }}"
                                    class="slide-item">Results delivery</a></li>
                            @endcan

                            @can('Resend result by Web/Fax/Mail')
                            <li aria-haspopup="true"><a href="#"
                                    class="slide-item">Resend result by Web/Fax/Mail</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcan

                    @can('Work Lists')
                    <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'results?pagename=WorkLists')) }}"
                            class="sub-icon"><i class="fas fa-briefcase"></i> Work Lists </a>
                    </li>
                    @endcan
                    {{-- <li aria-haspopup="true"><a href="#" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                class="side-menu__icon" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0V0z" fill="none" />
                                <path d="M6.26 9L12 13.47 17.74 9 12 4.53z" opacity=".3" />
                                <path
                                    d="M19.37 12.8l-7.38 5.74-7.37-5.73L3 14.07l9 7 9-7zM12 2L3 9l1.63 1.27L12 16l7.36-5.73L21 9l-9-7zm0 11.47L6.26 9 12 4.53 17.74 9 12 13.47z" />
                            </svg> Lab<i class="fe fe-chevron-down horizontal-icon"></i></a>
                        <div class="horizontal-megamenu clearfix">
                            <div class="container">
                                <div class="mega-menubg hor-mega-menu">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-12 col-xs-12 link-list">

                                            <ul>
                                                <li>
                                                    <h3 class="fs-14 fw-bold mb-1 mt-2">Search Results</h3>
                                                </li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/alerts"
                                                        class="slide-item">Results delivery</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/avatar"
                                                        class="slide-item">Resend result by Web/Fax/Mail</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/breadcrumbs"
                                                        class="slide-item">Breadcrumbs</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/buttons"
                                                        class="slide-item">Buttons</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/badge"
                                                        class="slide-item">Badge</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/dropdown"
                                                        class="slide-item">Dropdown</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/thumbnails"
                                                        class="slide-item">Thumbnails</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/images"
                                                        class="slide-item">Images</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/list-group"
                                                        class="slide-item">List Group</a></li>

                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-12 col-xs-12 link-list">
                                            <ul>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/navigation"
                                                        class="slide-item">Navigation</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/pagination"
                                                        class="slide-item">Pagination</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/popover"
                                                        class="slide-item">Popover</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/progress"
                                                        class="slide-item">Progress</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/spinners"
                                                        class="slide-item">Spinners</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/media-object"
                                                        class="slide-item">Media Object</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/typography"
                                                        class="slide-item">Typography</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/tooltip"
                                                        class="slide-item">Tooltip</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/toast"
                                                        class="slide-item">Toast</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/tags"
                                                        class="slide-item">Tags</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-12 col-xs-12 link-list">
                                            <ul>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/tabs"
                                                        class="slide-item">Tabs</a></li>
                                                <li>
                                                    <h3 class="fs-14 fw-bold mb-1 mt-2">Apps</h3>
                                                </li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/cards"
                                                        class="slide-item">Cards</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/draggablecards"
                                                        class="slide-item">Draggablecards</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/rangeslider"
                                                        class="slide-item">Range-slider</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/calendar"
                                                        class="slide-item">Calendar</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/contacts"
                                                        class="slide-item">Contacts</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/image-compare"
                                                        class="slide-item">Image-compare</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/notification"
                                                        class="slide-item">Notification</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/widget-notification"
                                                        class="slide-item">Widget-notification</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-12 col-xs-12 link-list">
                                            <ul>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/treeview"
                                                        class="slide-item">Treeview</a></li>
                                                <li>
                                                    <h3 class="fs-14 fw-bold mb-1 mt-2">Icons <span
                                                            class="badge bg-danger ">New</span></h3>
                                                </li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/icons"
                                                        class="slide-item">Icons</a></li>
                                                <li>
                                                    <h3 class="fs-14 fw-bold mb-1 mt-2">Maps</h3>
                                                </li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/map-leaflet"
                                                        class="slide-item">Mapel Maps</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/map-vector"
                                                        class="slide-item">Vector Maps</a></li>

                                                <li>
                                                    <h3 class="fs-14 fw-bold mb-1 mt-2">Tables</h3>
                                                </li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/table-basic"
                                                        class="slide-item">Basic Tables</a></li>
                                                <li aria-haspopup="true"><a
                                                        href="https://laravel.spruko.com/valex/ltr/table-data"
                                                        class="slide-item">Data Tables</a></li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>--}}
                    {{-- <li aria-haspopup="true"><a href="#" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                class="side-menu__icon" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M12 4c-4.41 0-8 3.59-8 8s3.59 8 8 8c.28 0 .5-.22.5-.5 0-.16-.08-.28-.14-.35-.41-.46-.63-1.05-.63-1.65 0-1.38 1.12-2.5 2.5-2.5H16c2.21 0 4-1.79 4-4 0-3.86-3.59-7-8-7zm-5.5 9c-.83 0-1.5-.67-1.5-1.5S5.67 10 6.5 10s1.5.67 1.5 1.5S7.33 13 6.5 13zm3-4C8.67 9 8 8.33 8 7.5S8.67 6 9.5 6s1.5.67 1.5 1.5S10.33 9 9.5 9zm5 0c-.83 0-1.5-.67-1.5-1.5S13.67 6 14.5 6s1.5.67 1.5 1.5S15.33 9 14.5 9zm4.5 2.5c0 .83-.67 1.5-1.5 1.5s-1.5-.67-1.5-1.5.67-1.5 1.5-1.5 1.5.67 1.5 1.5z"
                                    opacity=".3" />
                                <path
                                    d="M12 2C6.49 2 2 6.49 2 12s4.49 10 10 10c1.38 0 2.5-1.12 2.5-2.5 0-.61-.23-1.21-.64-1.67-.08-.09-.13-.21-.13-.33 0-.28.22-.5.5-.5H16c3.31 0 6-2.69 6-6 0-4.96-4.49-9-10-9zm4 13h-1.77c-1.38 0-2.5 1.12-2.5 2.5 0 .61.22 1.19.63 1.65.06.07.14.19.14.35 0 .28-.22.5-.5.5-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.14 8 7c0 2.21-1.79 4-4 4z" />
                                <circle cx="6.5" cy="11.5" r="1.5" />
                                <circle cx="9.5" cy="7.5" r="1.5" />
                                <circle cx="14.5" cy="7.5" r="1.5" />
                                <circle cx="17.5" cy="11.5" r="1.5" />
                            </svg> Advanced UI <i class="fe fe-chevron-down horizontal-icon"></i></a>
                        <ul class="sub-menu">
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/accordion"
                                    class="slide-item"> Accordion</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/carousel"
                                    class="slide-item">Carousel</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/collapse"
                                    class="slide-item">Collapse</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/modals"
                                    class="slide-item">Modals</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/timeline"
                                    class="slide-item">Timeline</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/sweet-alert"
                                    class="slide-item">Sweet Alert</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/rating"
                                    class="slide-item">Ratings</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/counters"
                                    class="slide-item">Counters</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/search"
                                    class="slide-item">Search</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/userlist"
                                    class="slide-item"> Userlist</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/blog"
                                    class="slide-item">Blog</a></li>
                            <li aria-haspopup="true" class="sub-menu-sub"><a href="#">Submenu</a>
                                <ul class="sub-menu">
                                    <li aria-haspopup="true"><a href="#" class="slide-item">Submenu-01</a>
                                    </li>
                                    <li aria-haspopup="true" class="slide-item sub-menu-sub"><a href="#">Submenu-02</a>
                                        <ul class="sub-menu">
                                            <li aria-haspopup="true"><a href="#" class="slide-item">SubmenuLevel-01</a>
                                            </li>
                                            <li aria-haspopup="true"><a href="#" class="slide-item">SubmenuLevel-02</a>
                                            </li>
                                            <li aria-haspopup="true"><a href="#" class="slide-item">SubmenuLevel-02</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/form-layouts"
                                            class="slide-item">Submenu-03</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>--}}
                    @can('Sample Track')
                    <li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fas fa-route"></i> Sample
                            Track <i class="fe fe-chevron-down horizontal-icon"></i></a>
                        <ul class="sub-menu">
                            @can('Receive Sample')
                            <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'receive_sample')) }}"
                                    class="slide-item">Receive Sample</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcan

                    @can('Tools')
                    <li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fas fa-toolbox"></i></i>
                            Tools <i class="fe fe-chevron-down horizontal-icon"></i></a>
                        <ul class="sub-menu">
                            @can('Reprint sample details')
                            <li aria-haspopup="true"><a href="{{ url('/' . ($page = 'reprint_sample_details')) }}"
                                    class="slide-item">Reprint sample details</a></li>
                            @endcan
                            @can('Change Processing Unit')
                            <li aria-haspopup="true"><a
                                href="{{ url('/' . ($page = 'tools?pagename=change_processing_unit')) }}"
                                class="slide-item">Change Processing Unit</a></li>
                            @endcan
                            @can('Sample Splitting')
                            <li aria-haspopup="true"><a
                                href="{{ url('/' . ($page = 'tools?pagename=sample_plitting')) }}"
                                class="slide-item">Sample Splitting</a></li>
                            @endcan
                            
                        </ul>
                    </li>
                    @endcan
                    @can('Reports')
                    <li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fas fa-poll"></i>
                        Reports <i class="fe fe-chevron-down horizontal-icon"></i></a>
                                <ul class="sub-menu">
                                    <li aria-haspopup="true"><a
                                        href="{{ url('/' . ($page = 'service_income_report')) }}"
                                            class="slide-item">Service income</a></li>
                                    <li aria-haspopup="true"><a
                                            href="{{ url('/' . ($page = 'patients_income_report')) }}"
                                            class="slide-item">Patients Income</a></li>
                                    <li aria-haspopup="true"><a
                                            href="{{ url('/' . ($page = 'header_paper')) }}"
                                            class="">Header Paper</a></li>

                                            <li aria-haspopup="true"><a
                                                href="{{ url('/' . ($page = 'homeservices?pagename=AppReviews')) }}"
                                                class="">App Reviews</a></li>
                                </ul>
                    </li>
                    @endcan

                    {{-- <li aria-haspopup="true"><a href="#" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                enable-background="new 0 0 24 24" class="side-menu__icon" viewBox="0 0 24 24">
                                <g>
                                    <rect fill="none" />
                                </g>
                                <g>
                                    <g />
                                    <g>
                                        <path
                                            d="M21,5c-1.11-0.35-2.33-0.5-3.5-0.5c-1.95,0-4.05,0.4-5.5,1.5c-1.45-1.1-3.55-1.5-5.5-1.5S2.45,4.9,1,6v14.65 c0,0.25,0.25,0.5,0.5,0.5c0.1,0,0.15-0.05,0.25-0.05C3.1,20.45,5.05,20,6.5,20c1.95,0,4.05,0.4,5.5,1.5c1.35-0.85,3.8-1.5,5.5-1.5 c1.65,0,3.35,0.3,4.75,1.05c0.1,0.05,0.15,0.05,0.25,0.05c0.25,0,0.5-0.25,0.5-0.5V6C22.4,5.55,21.75,5.25,21,5z M3,18.5V7 c1.1-0.35,2.3-0.5,3.5-0.5c1.34,0,3.13,0.41,4.5,0.99v11.5C9.63,18.41,7.84,18,6.5,18C5.3,18,4.1,18.15,3,18.5z M21,18.5 c-1.1-0.35-2.3-0.5-3.5-0.5c-1.34,0-3.13,0.41-4.5,0.99V7.49c1.37-0.59,3.16-0.99,4.5-0.99c1.2,0,2.4,0.15,3.5,0.5V18.5z" />
                                        <path
                                            d="M11,7.49C9.63,6.91,7.84,6.5,6.5,6.5C5.3,6.5,4.1,6.65,3,7v11.5C4.1,18.15,5.3,18,6.5,18 c1.34,0,3.13,0.41,4.5,0.99V7.49z"
                                            opacity=".3" />
                                    </g>
                                    <g>
                                        <path
                                            d="M17.5,10.5c0.88,0,1.73,0.09,2.5,0.26V9.24C19.21,9.09,18.36,9,17.5,9c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,10.69,16.18,10.5,17.5,10.5z" />
                                        <path
                                            d="M17.5,13.16c0.88,0,1.73,0.09,2.5,0.26V11.9c-0.79-0.15-1.64-0.24-2.5-0.24c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,13.36,16.18,13.16,17.5,13.16z" />
                                        <path
                                            d="M17.5,15.83c0.88,0,1.73,0.09,2.5,0.26v-1.52c-0.79-0.15-1.64-0.24-2.5-0.24c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,16.02,16.18,15.83,17.5,15.83z" />
                                    </g>
                                </g>
                            </svg>Pages <i class="fe fe-chevron-down horizontal-icon"></i></a>
                        <ul class="sub-menu">
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/profile"
                                    class="slide-item">Profile</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/editprofile"
                                    class="slide-item">Edit-profile</a></li>
                            <li aria-haspopup="true" class="sub-menu-sub"><a href="#">Mail</a>
                                <ul class="sub-menu">
                                    <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/mail"
                                            class="slide-item">Mail-inbox</a></li>
                                    <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/mail-compose"
                                            class="slide-item">Mail-compose</a></li>
                                    <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/mail-read"
                                            class="slide-item">Mail-read</a></li>
                                    <li aria-haspopup="true"><a
                                            href="https://laravel.spruko.com/valex/ltr/mail-settings"
                                            class="slide-item">Mail-settings</a></li>
                                    <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/chat"
                                            class="slide-item">Chat</a></li>

                                </ul>
                            </li>
                            <li aria-haspopup="true" class="sub-menu-sub"><a href="#">Forms</a>
                                <ul class="sub-menu">
                                    <li aria-haspopup="true"><a
                                            href="https://laravel.spruko.com/valex/ltr/form-elements"
                                            class="slide-item">Form Elements</a></li>
                                    <li aria-haspopup="true"><a
                                            href="https://laravel.spruko.com/valex/ltr/form-advanced"
                                            class="slide-item">Advanced Forms</a></li>
                                    <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/form-layouts"
                                            class="slide-item">Form Layouts</a></li>
                                    <li aria-haspopup="true"><a
                                            href="https://laravel.spruko.com/valex/ltr/form-validation"
                                            class="slide-item">Form Validation</a></li>
                                    <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/form-wizards"
                                            class="slide-item">Form Wizards</a></li>
                                    <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/form-editor"
                                            class="slide-item">WYSIWYG Editor</a></li>
                                </ul>
                            </li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/invoice"
                                    class="slide-item">Invoice</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/todotask"
                                    class="slide-item">Todotask</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/pricing"
                                    class="slide-item">Pricing</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/gallery"
                                    class="slide-item">Gallery</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/faq"
                                    class="slide-item">Faqs</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/emptypage"
                                    class="slide-item">Empty Page</a></li>
                        </ul>
                    </li>

                    <li aria-haspopup="true"><a href="#" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                class="side-menu__icon" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0V0z" fill="none" />
                                <path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"
                                    opacity=".3" />
                                <path
                                    d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z" />
                            </svg> Custom <i class="fe fe-chevron-down horizontal-icon"></i></a>
                        <ul class="sub-menu">
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/signin"
                                    class="slide-item">Sign In</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/signup"
                                    class="slide-item">Sign Up</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/forgot"
                                    class="slide-item">Forgot Password</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/reset"
                                    class="slide-item">Reset Password</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/lockscreen"
                                    class="slide-item">Lock screen</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/underconstruction"
                                    class="slide-item">UnderConstruction</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/error404"
                                    class="slide-item">404 Error</a></li>
                            <li aria-haspopup="true"><a href="https://laravel.spruko.com/valex/ltr/error500"
                                    class="slide-item">500 Error</a></li>
                        </ul>
                    </li> --}}
                </ul>
            </nav>
            <!--Nav-->
        </div>
    </div>
</div>
<!--Horizontal-main -->
<!--/main-header -->