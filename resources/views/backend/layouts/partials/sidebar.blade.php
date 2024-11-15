@php
$usr = Auth::guard('admin')->user();
@endphp
<nav class=" sidenav shadow-right sidenav-dark">
    <div class="sidenav-menu">


        <div class="nav accordion" id="accordionSidenav">
            <!-- Sidenav Menu Heading (Account)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <div class="sidenav-menu-heading d-sm-none">Account</div>
            <!-- Sidenav Link (Alerts)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <a class="nav-link d-sm-none" href="#!">
                <div class="nav-link-icon"><i data-feather="bell"></i></div>
                Alerts
                <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
            </a>
            <!-- Sidenav Link (Messages)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <a class="nav-link d-sm-none" href="#!">
                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                Messages
                <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
            </a>








            <!-- Sidenav Menu Heading (Roles)-->
            @if ($usr->can('role.create') || $usr->can('role.view') || $usr->can('role.edit') || $usr->can('role.delete'))
            <div class="sidenav-menu-heading">Roles</div>
            <!-- Sidenav Accordion (Roles)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseRoles" aria-expanded="false" aria-controls="collapseRoles">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Roles & Permission
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseRoles" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav">
                    @if ($usr->can('role.view'))
                    <a class="nav-link {{ Route::is('admin.roles.index') || Route::is('admin.roles.edit') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
                        All Roles
                    </a>
                    @endif
                    @if ($usr->can('role.create'))
                    <a class="nav-link {{ Route::is('admin.roles.create') ? 'active' : '' }}" href="{{ route('admin.roles.create') }}">
                        Create Roles
                    </a>
                    @endif
                </nav>
            </div>
            @endif





            <!-- Sidenav Menu Heading (User) -->
            @if ($usr->can('user.create') || $usr->can('user.view') || $usr->can('user.edit') || $usr->can('user.delete'))
            <div class="sidenav-menu-heading">User</div>

            <!-- Sidenav Accordion (User) -->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                User Management

                <!-- Show unread notifications badge on the main link if there are any -->
                @if ($unreadNotificationsCount > 0)
                <span class="badge rounded-pill bg-danger mx-1" style="font-size: 0.50rem; padding: 0.25em 0.4em;">New</span>
                @endif

                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>

            <div class="collapse" id="collapseUsers" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav">
                    @if ($usr->can('user.view'))
                    <a class="nav-link {{ Route::is('admin.users.index') || Route::is('admin.users.edit') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        All Users
                    </a>
                    @endif

                    @if ($usr->can('user.create'))
                    <a class="nav-link {{ Route::is('admin.users.create') ? 'active' : '' }}" href="{{ route('admin.users.create') }}">
                        Create User
                    </a>
                    @endif

                    @if ($usr->can('user.approve'))
                    <a class="nav-link {{ Route::is('admin.users.approvallist') ? 'active' : '' }}" href="{{ route('admin.users.approvallist') }}?markAsRead=true">
                        New User Request
                        @if ($unreadNotificationsCount > 0)
                        <span class="position-relative ms-2">
                            <span class="badge rounded-circle bg-danger border border-light">
                                {{ $unreadNotificationsCount }}
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </span>
                        @endif
                    </a>
                    @endif

                </nav>
            </div>
            @endif


            <!-- Sidenav Menu Heading (Admin)-->
            @if ($usr->can('admin.create') || $usr->can('admin.view') || $usr->can('admin.edit') || $usr->can('admin.delete'))
            <div class="sidenav-menu-heading">Admin</div>
            <!-- Sidenav Accordion (Admin)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseAdmins" aria-expanded="false" aria-controls="collapseAdmins">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Admin Management
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseAdmins" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav">
                    @if ($usr->can('admin.view'))
                    <a class="nav-link {{ Route::is('admin.admins.index') || Route::is('admin.admins.edit') ? 'active' : '' }}" href="{{ route('admin.admins.index') }}">
                        All Admins
                    </a>
                    @endif
                    @if ($usr->can('admin.create'))
                    <a class="nav-link {{ Route::is('admin.admins.create') ? 'active' : '' }}" href="{{ route('admin.admins.create') }}">
                        Create Admin
                    </a>
                    @endif
                </nav>
            </div>
            @endif





            <!-- Sidenav Menu Heading (Events)-->
            @if ($usr->can('events.create') || $usr->can('events.view') || $usr->can('events.edit') || $usr->can('events.delete'))
            <div class="sidenav-menu-heading">Events</div>
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseEvents" aria-expanded="false" aria-controls="collapseEvents">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Events Management
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseEvents" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav">
                    @if ($usr->can('events.view'))
                    <a class="nav-link {{ Route::is('events.index') ? 'active' : '' }}" href="{{ route('events.index') }}">
                        All Events
                    </a>
                    @endif
                    @if ($usr->can('events.create'))
                    <a class="nav-link {{ Route::is('events.store') ? 'active' : '' }}" href="{{ route('events.store') }}">
                        Create Events
                    </a>
                    @endif
                </nav>
            </div>
            @endif



            <!-- Sidenav Menu Heading (Volunteers) -->
            @if ($usr->can('volunteers.view') || $usr->can('volunteers.edit') || $usr->can('volunteers.update'))
            <div class="sidenav-menu-heading">Volunteers</div>
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseVolunteers" aria-expanded="false" aria-controls="collapseVolunteers">
                <div class="nav-link-icon"><i data-feather="users"></i></div>
                Volunteer Management
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseVolunteers" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav">
                    @if ($usr->can('volunteers.view'))

                    <!-- Link for showing all volunteers -->
                    <a class="nav-link {{ Route::is('admin.pendingvolunteers') ? 'active' : '' }}" href="{{ route('admin.pendingvolunteers') }}">
                        Volunteers Approval
                    </a>
                    @endif


                </nav>
            </div>
            @endif




            @if ($usr->can('forms.create') || $usr->can('forms.view') || $usr->can('forms.edit') || $usr->can('forms.delete') || $usr->can('forms.update'))
            <div class="sidenav-menu-heading">Form Builder</div>
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseFormBuilder" aria-expanded="false" aria-controls="collapseFormBuilder">
                <div class="nav-link-icon"><i data-feather="file-text"></i></div>
                Form Management
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseFormBuilder" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav">
                    @if ($usr->can('forms.view'))
                    <!-- Link for viewing all forms -->
                    <a class="nav-link {{ Route::is('formbuilder.index') ? 'active' : '' }}" href="{{ route('formbuilder.index') }}">
                        All Forms
                    </a>
                    @endif
                    @if ($usr->can('forms.create'))
                    <!-- Link for creating a new form -->
                    <a class="nav-link {{ Route::is('formbuilder.create') ? 'active' : '' }}" href="{{ route('formbuilder.create') }}">
                        Create Form
                    </a>
                    @endif
                    @if ($usr->can('forms.edit'))
                    <!-- Link for editing a form -->
                    <a class="nav-link {{ Route::is('formbuilder.edit', ['id' => 1]) ? 'active' : '' }}" href="{{ route('formbuilder.edit', ['id' => 1]) }}">
                        Edit Form
                    </a>
                    @endif
                    @if ($usr->can('forms.update'))
                    <!-- Link for updating a form -->
                    <a class="nav-link {{ Route::is('formbuilder.update', ['id' => 1]) ? 'active' : '' }}" href="{{ route('formbuilder.update', ['id' => 1]) }}">
                        Update Form
                    </a>
                    @endif
                    @if ($usr->can('forms.delete'))
                    <!-- Link for deleting a form -->
                    <a class="nav-link {{ Route::is('formbuilder.delete', ['id' => 1]) ? 'active' : '' }}" href="{{ route('formbuilder.delete', ['id' => 1]) }}">
                        Delete Form
                    </a>
                    @endif
                </nav>
            </div>
            @endif



            @if ($usr->can('settings.view') )
            <!-- Sidenav Menu Heading (Settings) -->
            <div class="sidenav-menu-heading">Settings</div>
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="false" aria-controls="collapseSettings">
                <div class="nav-link-icon"><i data-feather="settings"></i></div>
                Settings
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseSettings" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav">
                    <!-- Link for Volunteer settings -->
                    <a class="nav-link {{ Route::is('admin.settings.volunteer') ? 'active' : '' }}" href="{{ route('admin.settings.volunteer') }}">
                        Volunteer Settings
                    </a>

                    <!-- Link for Frontend CMS settings -->
                    <a class="nav-link {{ Route::is('admin.settings.frontend') ? 'active' : '' }}" href="{{ route('admin.settings.frontend') }}">
                        Frontend CMS Settings
                    </a>
                </nav>
            </div>
         @endif

           
          
        </div>
    </div>
    <!-- Sidenav Footer-->

</nav>