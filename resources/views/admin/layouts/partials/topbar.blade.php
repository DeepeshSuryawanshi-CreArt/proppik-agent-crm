<header class="">
     <div class="topbar">
          <div class="container-fluid">
               <div class="navbar-header">
                    <div class="d-flex align-items-center gap-2">
                         <!-- Menu Toggle Button -->
                         <div class="topbar-item">
                              <button type="button" class="button-toggle-menu topbar-button">
                                   <i class="ri-menu-2-line fs-24"></i>
                              </button>
                         </div>

                         <!-- App Search-->
                         <form class="app-search d-none d-md-block me-auto">
                              <div class="position-relative">
                                   <input type="search" class="form-control border-0" placeholder="Search..."
                                        autocomplete="off" value="">
                                   <i class="ri-search-line search-widget-icon"></i>
                              </div>
                         </form>
                    </div>

                    <div class="d-flex align-items-center gap-1">

                         <!-- Theme Color (Light/Dark) -->
                         <div class="topbar-item">
                              <a href="#" class="topbar-button">
                                   <i class="ri-calendar-todo-line fs-24"></i>
                              </a>
                         </div>


                         <!-- Theme Color (Light/Dark) -->
                         <div class="topbar-item">
                              <button type="button" class="topbar-button" id="light-dark-mode">
                                   <i class="ri-moon-line fs-24 light-mode"></i>
                                   <i class="ri-sun-line fs-24 dark-mode"></i>
                              </button>
                         </div>

                         <!-- Category -->
                         <div class="dropdown topbar-item d-none d-lg-flex">
                              <button type="button" class="topbar-button" data-toggle="fullscreen">
                                   <i class="ri-fullscreen-line fs-24 fullscreen"></i>
                                   <i class="ri-fullscreen-exit-line fs-24 quit-fullscreen"></i>
                              </button>
                         </div>

                         <!-- Theme Setting -->
                         <div class="topbar-item d-none d-md-flex">
                              <button type="button" class="topbar-button" id="theme-settings-btn"
                                   data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas"
                                   aria-controls="theme-settings-offcanvas">
                                   <i class="ri-settings-4-line fs-24"></i>
                              </button>
                         </div>

                         <!-- User -->
                         <div class="dropdown topbar-item">
                              <a type="button" class="topbar-button" id="page-header-user-dropdown"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                   <span class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                             style="width: 32px; height: 32px; font-size: 14px; font-weight: 600;">
                                             ADMIN
                                        </div>
                                   </span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-end">
                                   <!-- item-->
                                   <h6 class="dropdown-header">Welcome Admin!</h6>

                                   <a class="dropdown-item" href="#">
                                        <iconify-icon icon="solar:user-broken"
                                             class="align-middle me-2 fs-18"></iconify-icon><span
                                             class="align-middle">My Profile</span>
                                   </a>

                                   <a class="dropdown-item" href="">
                                        <iconify-icon icon="solar:lock-password-broken"
                                             class="align-middle me-2 fs-18"></iconify-icon><span
                                             class="align-middle">Change Password</span>
                                   </a>

                                   <a class="dropdown-item" href="">
                                        <iconify-icon icon="solar:calendar-broken"
                                             class="align-middle me-2 fs-18"></iconify-icon><span
                                             class="align-middle">My Schedules</span>
                                   </a>

                                   <div class="dropdown-divider my-1"></div>

                                   <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                                        <iconify-icon icon="solar:logout-3-broken"
                                             class="align-middle me-2 fs-18"></iconify-icon><span
                                             class="align-middle">Logout</span>
                                   </a>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</header>

<form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
     @csrf
</form>