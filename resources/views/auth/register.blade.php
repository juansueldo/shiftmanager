<!doctype html>
<html lang="es" data-bs-theme="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Shiftmanager | Register</title>

    <meta name="description" content="" />

    <!-- Favicon --><link rel="icon" type="image/x-icon" href="{{ asset('img/logo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />

      <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite([
        'resources/js/app.js',
        'resources/css/app.css', 
        'resources/assets/css/theme-default.css', 
        'resources/assets/css/core.css', 
        'resources/assets/css/pages/page-auth.css',
        'resources/assets/fonts/remixicon/remixicon.css',
        'resources/assets/js/theme.js',
        'resources/js/helpers.js',
        'resources/assets/js/request.js',
        'resources/js/menu.js',
        'resources/js/config.js',
        'resources/assets/js/validation.js',
        'resources/js/main.js'])
  </head>

  <body>
    <!-- Content -->

    <div class="position-relative">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6 mx-4">
          <!-- Register Card -->
          <div class="card p-7">
            <!-- Logo -->
            <div class="app-brand justify-content-center mt-5">
              <a href="index.html" class="app-brand-link gap-3">
                <span class="app-brand-logo demo">
                  <span style="color: var(--bs-primary)">
                  <img src="{{ asset('img/logo.png') }}" alt="logo" width="70" height="70" class="rounded-circle" />
                  </span>
                </span>
              </a>
            </div>
            <!-- /Logo -->
            <div class="card-body mt-1">
              <h4 class="mb-1">{{__('register.title')}} 🚀</h4>

              <!-- Google Registration Button -->
              <div class="mb-4">
                <a href="{{ route('auth.google') }}" class="btn btn-outline-primary d-grid w-100 mb-4">
                  <div class="d-flex align-items-center justify-content-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" class="me-2">
                      <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                      <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                      <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                      <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    {{__('register.continue_with_google')}}
                  </div>
                </a>
              </div>

              <!-- Divider -->
              <div class="divider my-5">
                <div class="divider-text">{{__('register.or')}}</div>
              </div>

              <form id="formAuthentication" class="mb-5"  
              action="{{ route('register.store') }}"
              data-ajax-validated="true"
              method="POST">
                @csrf
                <div class="form-floating form-floating-outline mb-5">
                  <input
                    type="text"
                    class="form-control"
                    id="firstname"
                    name="firstname"
                    placeholder="Enter your name"
                    data-fs-validate="true"
                    data-fs-required="true"
                    data-fs-minlength="3"
                    data-fs-error-required="{{__('register.firstname_error_required')  }}"
                    data-fs-error-minlength="{{__('register.firstname_error_min')}}"/>
                  <label for="name">{{__('register.firstname')}}</label>
                </div>
                <div class="form-floating form-floating-outline mb-5">
                  <input
                    type="text"
                    class="form-control"
                    id="lastname"
                    name="lastname"
                    placeholder="Enter your lastname"
                    data-fs-validate="true"
                    data-fs-required="true"
                    data-fs-minlength="3"
                    data-fs-error-required="{{__('register.lastname_error_required')  }}"
                    data-fs-error-minlength="{{__('register.lastname_error_min')}}"/>
                  <label for="name">{{__('register.lastname')}}</label>
                </div>
                <div class="form-floating form-floating-outline mb-5">
                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" />
                  <label for="email">{{__('register.email')}}</label>
                </div>
                <div class="mb-5 form-password-toggle">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input
                        type="password"
                        id="password"
                        class="form-control"
                        name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password"
                        data-fs-validate="true"
                        data-fs-minlength="8"
                        data-fs-required="true"
                        data-pattern= "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$"
                        data-fs-error-required= "{{ __('register.password_error_required') }}"
                        data-fs-error-pattern= "{{ __('register.password_pattern') }}"
                        data-fs-error-minlength= "{{ __('register.password_minlength') }}" />
                      <label for="password">{{__('register.password')}}</label>
                    </div>
                    <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line ri-20px"></i></span>
                  </div>
                </div>
                <div class="mb-5 form-password-toggle">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input
                        type="password"
                        id="password_confirmation"
                        class="form-control"
                        name="password_confirmation"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password_confirmation"
                        required />
                      <label for="password_confirmation">{{ __('register.confirm_password') }}</label>
                    </div>
                    <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line ri-20px"></i></span>
                  </div>
                </div>

                <div class="mb-5 py-2">
                  <div class="form-check mb-0">
                  <input 
                      class="form-check-input" 
                      type="checkbox" 
                      id="terms-conditions" 
                      name="terms" 
                      
                    />

                    <label class="form-check-label" for="terms-conditions">
                      {{__('register.agree')}}
                      <a href="javascript:void(0);">{{ __('register.privacy') }}</a>
                    </label>
                  </div>
                </div>
                <button type="submit" id="submit-register" disabled="true" class="btn btn-primary d-grid w-100 mb-5">{{ __('register.sign_up') }}</button>
              </form>

              <p class="text-center mb-5">
                <span>{{__('register.already_have_account')}}</span>
                <a href="{{ route('login') }}"  >
                  <span>{{ __('register.sign_in') }}</span>
                </a>
              </p>
            </div>
          </div>
          <!-- Register Card -->
          
        </div>
      </div>
    </div>
    @include('layouts.partials.alert', ['session'=> $session ?? ''])
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
      const formValidator = new Formshield("#formAuthentication");
      const checkterms = document.getElementById('terms-conditions');
      const submitRegister = document.getElementById('submit-register');
      checkterms.addEventListener('change', function() {
        if (checkterms.checked) {
          submitRegister.disabled = false;
        } else {
          submitRegister.disabled = true;
        }
      });
    });
    </script>

    <script>
        (function() {
            applySavedTheme(document.documentElement)
        })();       
    </script>
  </body>
</html>