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
                        <a class="dropdown-item" href="{{ route('dashboard.language', ['lang' => 'en']) }}">
                            <span class="align-middle">{{__('dashboard.english')}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('dashboard.language', ['lang' => 'es']) }}">
                            <span class="align-middle">{{__('dashboard.spanish')}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <span class="align-middle">{{__('dashboard.portuguese')}}</span>
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
                  <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                      <i class="ri-dashboard-line ri-22px"></i>
                  </a>
                  <meta name="csrf-token" content="{{ csrf_token() }}">
                  <ul class="dropdown-menu dropdown-menu-end mt-3 py-2" style="width: 300px;">
                    <li class="dropdown-header"><span class="align-middle text-body">Shortcuts</span></li>
                    <table class="table table-bordered mb-0 text-center">
                          <tbody>
                              <tr>
                                  <td>
                                      <a class="d-block text-decoration-none py-2 text-body" href="javascript:void(0)" data-ajax-source="/widgets/create/messages" data-ajax-method="repalceHtml" data-ajax-container="span#content-wrapper">
                                          <i class="ri-mail-line ri-22px d-block mb-1"></i>
                                          <span class="align-middle">New message</span>
                                      </a>
                                  </td>
                                  <td>
                                      <a class="d-block text-decoration-none py-2 text-body" href="javascript:void(0)" data-ajax-source="/widgets/create/users" data-ajax-method="repalceHtml" data-ajax-container="span#content-wrapper">
                                          <i class="ri-user-add-line ri-22px d-block mb-1"></i>
                                          <span class="align-middle">New user registered</span>
                                      </a>
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                      <a class="d-block text-decoration-none py-2 text-body" href="javascript:void(0)" data-ajax-source="/widgets/create/settings" data-ajax-method="repalceHtml" data-ajax-container="span#content-wrapper">
                                          <i class="ri-settings-3-line ri-22px d-block mb-1"></i>
                                          <span class="align-middle">Settings updated</span>
                                      </a>
                                  </td>
                                  <td>
                                      <a class="d-block text-decoration-none py-2 text-body" href="javascript:void(0)" data-ajax-source="/widgets/create/analytics" data-ajax-method="repalceHtml" data-ajax-container="span#content-wrapper">
                                          <i class="ri-bar-chart-line ri-22px d-block mb-1"></i>
                                          <span class="align-middle">Analytics</span>
                                      </a>
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                      <a class="d-block text-decoration-none py-2 text-body" href="javascript:void(0)" data-ajax-source="/widgets/create/reports" data-ajax-method="repalceHtml" data-ajax-container="span#content-wrapper">
                                          <i class="ri-pie-chart-line ri-22px d-block mb-1"></i>
                                          <span class="align-middle">Reports</span>
                                      </a>
                                  </td>
                                  <td>
                                      <a class="d-block text-decoration-none py-2 text-body" href="javascript:void(0)" data-ajax-source="/widgets/create/team" data-ajax-method="repalceHtml" data-ajax-container="span#content-wrapper">
                                          <i class="ri-group-line ri-22px d-block mb-1"></i>
                                          <span class="align-middle">Team Overview</span>
                                      </a>
                                  </td>
                              </tr>
                          </tbody>
                    </table>
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
                    <img src="{{ asset( $user->avatar) }}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex align-items-center">
                          <div class="flex-shrink-0 me-2">
                            <div class="avatar avatar-online">
                            <img src="{{ asset(  $user->avatar) }}" alt class="w-px-40 h-auto rounded-circle" />
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
                          <span class="align-middle">{{ __("{$value['name']}") }}</span>
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
                          <small class="align-middle">{{ __('dashboard.logout') }}</small>
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
          <script>
            (function() {
              function initializeThemeToggle() {
                const themeToggle = document.getElementById("theme-toggle");
                const themeIcon = document.getElementById("theme-icon");
                if (themeToggle && themeIcon) {
                  setupThemeToggle(themeToggle, themeIcon, document.documentElement);
                }
              }

              if (typeof $ !== 'undefined' && $.isReady) {
                initializeThemeToggle();
              } else if (typeof $ !== 'undefined') {
                $(document).ready(initializeThemeToggle);
              } else {
                document.addEventListener('DOMContentLoaded', initializeThemeToggle);
              }
            })();
           
          </script>
          