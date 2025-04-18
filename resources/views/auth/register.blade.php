<!doctype html>

<html lang="es" data-bs-theme="dark">
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

              <form id="formAuthentication" class="mb-5" action="{{ route('register.store') }}" method="POST"
              data-ajax-validated="true">
                @csrf
                <div class="form-floating form-floating-outline mb-5">
                  <input
                    type="text"
                    class="form-control"
                    id="firstname"
                    name="firstname"
                    placeholder="Enter your name"
                    required 
                    data-fs-validate="true"
                    data-fs-required="true"
                    data-fs-minlength="3"
                    data-fs-error-required= {{__('register.firstname_error_required')  }}
                    data-fs-error-minlength={{__('register.firstname_error_min')}}/>
                  <label for="name">{{__('register.firstname')}}</label>
                </div>
                <div class="form-floating form-floating-outline mb-5">
                  <input
                    type="text"
                    class="form-control"
                    id="lastname"
                    name="lastname"
                    placeholder="Enter your lastname"
                    required
                    data-fs-validate="true"
                    data-fs-required="true"
                    data-fs-minlength="3"
                    data-fs-error-required= {{__('register.lastname_error_required')  }}
                    data-fs-error-minlength={{__('register.lastname_error_min')}}/>
                  <label for="name">{{__('register.lastname')}}</label>
                </div>
                <div class="form-floating form-floating-outline mb-5">
                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required />
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
                        required />
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
                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                    <label class="form-check-label" for="terms-conditions">
                      {{__('register.agree')}}
                      <a href="javascript:void(0);">{{ __('register.privacy') }}</a>
                    </label>
                  </div>
                </div>
                <button class="btn btn-primary d-grid w-100 mb-5">{{ __('register.sign_up') }}</button>
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

    <!-- / Content -->

 

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->


    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
 

    <!-- Page JS -->

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
      const formValidator = new Formshield("#formAuthentication");
    });
    </script>
  </body>
</html>
