<!-- Main Sidebar Container -->
<aside class="app-sidebar shadow bg-body-tertiary">
    <!-- Brand Logo -->
    <div class="sidebar-brand">
        <a href="#" class="brand-link">
            <img src="{{ asset('image/logo.png') }}" alt="BSU Logo" class="brand-image opacity-75 shadow">
            <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
        </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar-wrapper">
        <!-- Sidebar Menu -->
        <nav class="mt-2" aria-label="Main navigation">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" data-accordion="false" id="navigation">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

                {{-- Dashboard --}}
                {{-- <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link @if (Route::current()->getName() == 'dashboard') active @endif">
                        <i class="nav-icon bi bi-house-fill"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li> --}}


                {{-- User Access --}}
                <li class="nav-item">
                    <a href="{{ route('users.index') }}"
                        class="nav-link @if (Route::current()->getName() == 'users.*') active @endif">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>
                            User Management
                        </p>
                    </a>
                </li>
                {{-- Faculty --}}
                <li class="nav-item">
                    <a href="{{ route('faculties.index') }}"
                        class="nav-link @if (Route::current()->getName() == 'faculties.*') active @endif">
                        <i class="nav-icon bi bi-diagram-3-fill text-danger"></i>
                        <p>
                            Faculty Management
                        </p>
                    </a>
                </li>
                {{-- Programme --}}
                <li class="nav-item">
                    <a href="{{ route('programmes.index') }}"
                        class="nav-link @if (Route::current()->getName() == 'programmes.*') active @endif">
                        <i class="nav-icon bi bi-mortarboard-fill"></i>
                        <p>
                            Programme Management
                        </p>
                    </a>
                </li>
                {{-- Intake --}}
                <li class="nav-item">
                    <a href="{{ route('intakes.index') }}"
                        class="nav-link @if (Route::current()->getName() == 'intakes.*') active @endif">
                        <i class="nav-icon bi bi-calendar-event-fill"></i>
                        <p>
                            Intake Management
                        </p>
                    </a>
                </li>
                {{-- Applicant --}}
                <li class="nav-item">
                    <a href="{{ route('applicants.index') }}"
                        class="nav-link @if (Route::current()->getName() == 'applicants.*') active @endif">
                        <i class="nav-icon bi bi-person-vcard-fill"></i>
                        <p>
                            Applicant Management
                        </p>
                    </a>
                </li>
                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
