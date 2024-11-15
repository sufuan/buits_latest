   <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
       <!-- Sidenav Toggle Button-->
       <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>
       <!-- Navbar Brand-->

       <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="index.html">SB Admin Pro</a>

       <form class="form-inline me-auto d-none d-lg-block me-3">
           <div class="input-group input-group-joined input-group-solid">
               <input class="form-control pe-0" type="search" placeholder="Search" aria-label="Search" />
               <div class="input-group-text"><i data-feather="search"></i></div>
           </div>
       </form>
       <!-- Navbar Items-->
       <ul class="navbar-nav align-items-center ms-auto">
           <!-- Documentation Dropdown-->

           <!-- Navbar Search Dropdown-->
           <!-- * * Note: * * Visible only below the lg breakpoint-->
           <li class="nav-item dropdown no-caret me-3 d-lg-none">
               <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="searchDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="search"></i></a>
               <!-- Dropdown - Search-->
               <div class="dropdown-menu dropdown-menu-end p-3 shadow animated--fade-in-up" aria-labelledby="searchDropdown">
                   <form class="form-inline me-auto w-100">
                       <div class="input-group input-group-joined input-group-solid">
                           <input class="form-control pe-0" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                           <div class="input-group-text"><i data-feather="search"></i></div>
                       </div>
                   </form>
               </div>
           </li>
           <!-- Alerts Dropdown-->
           <li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
               @php
               $notifications = Auth::guard('admin')->user()->unreadNotifications;
               @endphp

               <a class="btn btn-icon btn-transparent-dark dropdown-toggle position-relative" id="navbarDropdownAlerts" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   <i data-feather="bell"></i>
                   @if($notifications->count())
                   <span class="badge bg-danger position-absolute top-0 start-100 translate-middle p-2 ">
                       {{ $notifications->count() }}
                   </span>
                   @endif
               </a>

               <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownAlerts">
                   <h6 class="dropdown-header dropdown-notifications-header">
                       <i class="me-2" data-feather="bell"></i>
                       Alerts Center
                   </h6>

                   @if($notifications->count())
                   @foreach($notifications as $notification)
                   <a class="dropdown-item" href="{{ route('admin.notifications.read', $notification->id) }}">
                       <div class="dropdown-item-icon bg-warning"><i data-feather="activity"></i></div>
                       {{ $notification->data['message'] }}
                       <div class="dropdown-item-text small">Registered at {{ $notification->created_at->diffForHumans() }}</div>
                   </a>
                   @endforeach
                   <a class="dropdown-item text-center" href="{{ route('admin.notifications.markAllAsRead') }}">
                       Mark all as read
                   </a>
                   @else
                   <a class="dropdown-item" href="#">
                       <div class="dropdown-item-text small">No new notifications</div>
                   </a>
                   @endif
               </div>
           </li>


           <!-- Messages Dropdown-->
           <li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
               <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownMessages" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="mail"></i></a>
               <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownMessages">
                   <h6 class="dropdown-header dropdown-notifications-header">
                       <i class="me-2" data-feather="mail"></i>
                       Message Center
                   </h6>

               </div>
           </li>
           <!-- User Dropdown-->
           <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
               <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="{{ asset('assets/img/illustrations/profiles/profile-1.png') }}" /></a>
               <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                   <h6 class="dropdown-header d-flex align-items-center">
                       <img class="dropdown-user-img" src="{{ asset('assets/img/illustrations/profiles/profile-2.png') }}" />
                       <div class="dropdown-user-details">
                           <div class="dropdown-user-details-name">
                               {{ optional(Auth::guard('admin')->user())->name }}
                           </div>
                       </div>
                   </h6>
                   <div class="dropdown-divider"></div>
                   <a class="dropdown-item" href="#!">
                       <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                       Account
                   </a>


                   <a class="dropdown-item" href="{{ route('admin.logout.submit') }}" onclick="event.preventDefault();
                      document.getElementById('admin-logout-form').submit();">
                       <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                       Logout
                   </a>
                   <form id="admin-logout-form" action="{{ route('admin.logout.submit') }}" method="POST" style="display: none;">
                       @csrf
                   </form>
               </div>
           </li>
       </ul>
   </nav>