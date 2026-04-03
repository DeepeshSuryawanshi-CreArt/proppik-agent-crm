<div class="main-nav">
     <!-- Sidebar Logo -->
     <div class="logo-box">
          <a href="{{ route('dashboard') }}" class="logo-dark">
               <img src="{{ asset('public/assets/logo/logo-sm-1.svg') }}" class="logo-sm" alt="logo sm"
                    style="height: 100% !important;">
               <img src="{{ asset('public/assets/logo/logo.svg') }}" class="logo-lg" alt="logo dark"
                    style="height: 100% !important;">
          </a>

          <a href="{{ route('dashboard') }}" class="logo-light">
               <img src="{{ asset('public/assets/logo/w-logo-sm-1.svg') }}" class="logo-sm" alt="logo sm"
                    style="height: 100% !important;">
               <img src="{{ asset('public/assets/logo/w-logo.svg') }}" class="logo-lg" alt="logo light"
                    style="height: 100% !important;">
          </a>
     </div>

     <!-- Menu Toggle Button (sm-hover) -->
     <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
          <i class="ri-menu-2-line fs-24 button-sm-hover-icon"></i>
     </button>

     <div class="scrollbar" data-simplebar>

          <ul class="navbar-nav" id="navbar-nav">

               <li class="menu-title">Menu</li>

               <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                         href="{{ route('dashboard') }}">
                         <span class="nav-icon">
                              <i class="ri-dashboard-2-line"></i>
                         </span>
                         <span class="nav-text">Dashboards</span>
                    </a>
               </li>

               <li class="nav-item">
                    <a class="nav-link" href="">
                         <span class="nav-icon">
                              <i class="ri-user-line"></i>
                         </span>
                         <span class="nav-text">Customers</span>
                    </a>
               </li>

               <li class="nav-item">
                    <a class="nav-link" href="">
                         <span class="nav-icon">
                              <i class="ri-contacts-book-3-line"></i>
                         </span>
                         <span class="nav-text">Bookings</span>
                    </a>
               </li>




               <li class="menu-title">System</li>


               <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                         <span class="nav-icon">
                              <i class="ri-user-line"></i>
                         </span>
                         <span class="nav-text">Users</span>
                    </a>
               </li>

               <li class="nav-item">
                    <a class="nav-link " href="">
                         <span class="nav-icon">
                              <i class="ri-id-card-line"></i>
                         </span>
                         <span class="nav-text">Roles</span>
                    </a>
               </li>

               <li class="nav-item">
                    <a class="nav-link " href="{{ route('admin.permissions.index') }}">
                         <span class="nav-icon">
                              <i class="ri-lock-2-line"></i>
                         </span>
                         <span class="nav-text">Permissions</span>
                    </a>
               </li>

               <li class="nav-item d-none">
                    <a class="nav-link" href="">
                         <span class="nav-icon">
                              <i class="ri-book-line"></i>
                         </span>
                         <span class="nav-text">Activity Log</span>
                    </a>
               </li>

               <li class="nav-item">
                    <a class="nav-link" href="">
                         <span class="nav-icon">
                              <i class="ri-calendar-event-line"></i>
                         </span>
                         <span class="nav-text">Holidays</span>
                    </a>
               </li>

               <li class="nav-item">
                    <a class="nav-link " href="">
                         <span class="nav-icon">
                              <i class="ri-home-gear-line"></i>
                         </span>
                         <span class="nav-text">Settings</span>
                    </a>
               </li>

          </ul>
     </div>
</div>