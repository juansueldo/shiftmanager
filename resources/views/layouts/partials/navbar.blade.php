<nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="ri-menu-fill ri-24px"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search --
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="ri-search-line ri-22px me-2"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..." />
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <li class="nav-item navbar-dropdown dropdown me-3">
                  <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                      data-bs-toggle="dropdown">
                      <i class="ri-translate-2 ri-22px"></i>
                  </a>
                <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                    <li>
                        <a class="dropdown-item" href="#">
                            <span class="align-middle">English</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <span class="align-middle">Spanish</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <span class="align-middle">Portuges</span>
                        </a>
                    </li>
                </ul>
                </li>

                <li class="nav-item me-3">
                  <a id="theme-toggle" class="nav-link hide-arrow p-0" href="javascript:void(0);" data-theme="default">
                      <i id="theme-icon" class="ri-moon-line ri-22px"></i>
                  </a>
                </li>

                
                <li class="nav-item navbar-dropdown dropdown me-3">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <i class="ri-dashboard-line ri-22px"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="ri-mail-line ri-22px me-2"></i>
                            <span class="align-middle">New message</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="ri-user-add-line ri-22px me-2"></i>
                            <span class="align-middle">New user registered</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="ri-settings-3-line ri-22px me-2"></i>
                            <span class="align-middle">Settings updated</span>
                        </a>
                    </li>
                </ul>
                </li>
                
                <li class="nav-item navbar-dropdown dropdown me-3">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <i class="ri-notification-3-line ri-22px"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="ri-mail-line ri-22px me-2"></i>
                            <span class="align-middle">New message</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="ri-user-add-line ri-22px me-2"></i>
                            <span class="align-middle">New user registered</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="ri-settings-3-line ri-22px me-2"></i>
                            <span class="align-middle">Settings updated</span>
                        </a>
                    </li>
                </ul>
                </li>
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a
                    class="nav-link dropdown-toggle hide-arrow p-0"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex align-items-center">
                          <div class="flex-shrink-0 me-2">
                            <div class="avatar avatar-online">
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                          <h6 class="mb-0 small">{{ $user->firstname }} {{ $user->lastname }}</h6>
                            <small class="text-muted">Admin</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    @foreach ($navbar as $value)
                      <li>
                        <a class="dropdown-item" href="javascript:void(0);" class="menu-link" 
                          data-ajax-source="{{ $value['data-ajax-source'] }}" 
                          data-ajax-method="{{ $value['data-ajax-method'] }}" 
                          data-ajax-container="{{ $value['data-ajax-container'] }}">
                          <i class="{{ $value['icon'] }} ri-22px me-2"></i>
                          <span class="align-middle">{{ $value['name'] }}</span>
                        </a>
                      </li>
                    @endforeach
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <div class="d-grid px-4 pt-2 pb-1">
                      <form action="{{ route('login.destroy') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger d-flex w-100" href="javascript:void(0);">
                          <small class="align-middle">Logout</small>
                          <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                        </button>
                      </div>
                      </form>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>