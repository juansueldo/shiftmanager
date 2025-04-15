<!doctype html>
<html
  lang="en"
  class=" layout-navbar-fixed layout-wide "
  dir="ltr"
  data-skin="default"
  data-assets-path="../../assets/"
  data-template="front-pages"
  data-bs-theme="light">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex" />
    
      <title>Demo: Landing Page - Front Pages | Materio - Bootstrap Dashboard PRO</title>
    

      <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.png') }}" />
    @vite([
        'resources/css/app.css', 
        'resources/assets/css/theme-default.css', 
        'resources/assets/css/core.css', 
        'resources/assets/css/demo.css',
        'resources/assets/fonts/remixicon/remixicon.css',
        'resources/assets/css/pages/front-page.css',
        'resources/assets/css/pages/front-page-landing.css',
        'resources/assets/css/pages/core-landing.css',
        'resources/js/app.js',
        'resources/assets/js/request.js',
        'resources/assets/js/theme.js',
        'resources/assets/js/calendar.js',
        'resources/assets/js/datatable.js',
        'resources/assets/js/validation.js',
        'resources/js/front-config.js',
        'resources/js/front-main.js',
        'resources/js/front-page-langing.js',
        'resources/js/helpers.js',
        'resources/js/menu.js',
        'resources/js/config.js',
        'resources/js/main.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />
      <!-- Canonical SEO -->
      
      
      <!-- ? PROD Only: Google Tag Manager (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
      <script>
        (function (w, d, s, l, i) {
          w[l] = w[l] || [];
          w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });
          var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s),
            dl = l != 'dataLayer' ? '&l=' + l : '';
          j.async = true;
          j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
          f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5DDHKGP');
      </script>
      <!-- End Google Tag Manager -->
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />


    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css -->
    
   

    <!-- Page CSS -->
    
  <link rel="stylesheet" href="../../assets/vendor/css/pages/front-page-landing.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />


    <!-- Menu waves for no-customizer fix -->


    <!-- Core CSS -->


    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    
      <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js. -->
      <script src="../../assets/vendor/js/template-customizer.js"></script>
    
    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->
    
      <script src="../../assets/js/front-config.js"></script>
    
  </head>

  <body>
    
      <!-- ?PROD Only: Google Tag Manager (noscript) (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
      <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0" style="display: none; visibility: hidden"></iframe>
      </noscript>
      <!-- End Google Tag Manager (noscript) -->
    
    


<script src="../../assets/vendor/js/dropdown-hover.js"></script>
  <script src="../../assets/vendor/js/mega-dropdown.js"></script><!-- Navbar: Start -->
<nav class="layout-navbar shadow-none py-0">
  <div class="container">
    <div class="navbar navbar-expand-lg landing-navbar px-3 px-md-8">
      <!-- Menu logo wrapper: Start -->
      <div class="navbar-brand app-brand demo d-flex py-0 me-4 me-xl-6">
        <!-- Mobile menu toggle: Start-->
        <button class="navbar-toggler border-0 px-0 me-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <i class="icon-base ri ri-menu-fill icon-lg align-middle text-heading fw-medium"></i>
        </button>
        <!-- Mobile menu toggle: End-->
        <a href="landing-page.html" class="app-brand-link">
          <span class="app-brand-logo demo">
  <span class="text-primary">
    <svg width="30" height="24" viewBox="0 0 250 196" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" clip-rule="evenodd" d="M12.3002 1.25469L56.655 28.6432C59.0349 30.1128 60.4839 32.711 60.4839 35.5089V160.63C60.4839 163.468 58.9941 166.097 56.5603 167.553L12.2055 194.107C8.3836 196.395 3.43136 195.15 1.14435 191.327C0.395485 190.075 0 188.643 0 187.184V8.12039C0 3.66447 3.61061 0.0522461 8.06452 0.0522461C9.56056 0.0522461 11.0271 0.468577 12.3002 1.25469Z" fill="currentColor" />
      <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd" d="M0 65.2656L60.4839 99.9629V133.979L0 65.2656Z" fill="black" />
      <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd" d="M0 65.2656L60.4839 99.0795V119.859L0 65.2656Z" fill="black" />
      <path fill-rule="evenodd" clip-rule="evenodd" d="M237.71 1.22393L193.355 28.5207C190.97 29.9889 189.516 32.5905 189.516 35.3927V160.631C189.516 163.469 191.006 166.098 193.44 167.555L237.794 194.108C241.616 196.396 246.569 195.151 248.856 191.328C249.605 190.076 250 188.644 250 187.185V8.09597C250 3.64006 246.389 0.027832 241.935 0.027832C240.444 0.027832 238.981 0.441882 237.71 1.22393Z" fill="currentColor" />
      <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd" d="M250 65.2656L189.516 99.8897V135.006L250 65.2656Z" fill="black" />
      <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd" d="M250 65.2656L189.516 99.0497V120.886L250 65.2656Z" fill="black" />
      <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2787 1.18923L125 70.3075V136.87L0 65.2465V8.06814C0 3.61223 3.61061 0 8.06452 0C9.552 0 11.0105 0.411583 12.2787 1.18923Z" fill="currentColor" />
      <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2787 1.18923L125 70.3075V136.87L0 65.2465V8.06814C0 3.61223 3.61061 0 8.06452 0C9.552 0 11.0105 0.411583 12.2787 1.18923Z" fill="white" fill-opacity="0.15" />
      <path fill-rule="evenodd" clip-rule="evenodd" d="M237.721 1.18923L125 70.3075V136.87L250 65.2465V8.06814C250 3.61223 246.389 0 241.935 0C240.448 0 238.99 0.411583 237.721 1.18923Z" fill="currentColor" />
      <path fill-rule="evenodd" clip-rule="evenodd" d="M237.721 1.18923L125 70.3075V136.87L250 65.2465V8.06814C250 3.61223 246.389 0 241.935 0C240.448 0 238.99 0.411583 237.721 1.18923Z" fill="white" fill-opacity="0.3" />
    </svg>
  </span>
</span>
          <span class="app-brand-text demo menu-text fw-semibold ms-2 ps-1">Shiftmanager</span>
        </a>
      </div>
      <!-- Menu logo wrapper: End -->
      <!-- Menu wrapper: Start -->
      <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
        <button class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <i class="icon-base ri ri-close-fill"></i>
        </button>
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link fw-medium" aria-current="page" href="landing-page.html#landingHero">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-medium" href="landing-page.html#landingFeatures">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-medium" href="landing-page.html#landingTeam">Team</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-medium" href="landing-page.html#landingFAQ">FAQ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-medium" href="landing-page.html#landingContact">Contact us</a>
          </li>
          <li class="nav-item mega-dropdown
  ">
            <a href="javascript:void(0);" class="nav-link dropdown-toggle navbar-ex-14-mega-dropdown mega-dropdown fw-medium" aria-expanded="false" data-bs-toggle="mega-dropdown" data-trigger="hover">
              <span data-i18n="Pages">Pages</span>
            </a>
            <div class="dropdown-menu p-4 p-xl-8">
              <div class="row gy-4">
                <div class="col-12 col-lg">
                  <div class="h6 d-flex align-items-center mb-2 mb-lg-4">
                    <div class="avatar avatar-sm flex-shrink-0 me-2">
                      <span class="avatar-initial rounded bg-label-primary">
                        <i class="icon-base ri ri-layout-grid-line"></i>
                      </span>
                    </div>
                    <span class="ps-1">Other</span>
                  </div>
                  <ul class="nav flex-column">
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="pricing-page.html">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        <span data-i18n="Pricing">Pricing</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="payment-page.html">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        <span data-i18n="Payment">Payment</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="checkout-page.html">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        <span data-i18n="Checkout">Checkout</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="help-center-landing.html">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        <span data-i18n="Help Center">Help Center</span>
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="col-12 col-lg">
                  <div class="h6 d-flex align-items-center mb-2 mb-lg-4">
                    <div class="avatar avatar-sm flex-shrink-0 me-2">
                      <span class="avatar-initial rounded bg-label-primary">
                        <i class="icon-base ri ri-lock-unlock-line"></i>
                      </span>
                    </div>
                    <span class="ps-1">Auth Demo</span>
                  </div>
                  <ul class="nav flex-column">
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/auth-login-basic.html" target="_blank">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        Login (Basic)
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/auth-login-cover.html" target="_blank">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        Login (Cover)
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/auth-register-basic.html" target="_blank">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        Register (Basic)
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/auth-register-cover.html" target="_blank">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        Register (Cover)
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/auth-register-multisteps.html" target="_blank">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        Register (Multi-steps)
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/auth-forgot-password-basic.html" target="_blank">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        Forgot Password (Basic)
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/auth-forgot-password-cover.html" target="_blank">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        Forgot Password (Cover)
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/auth-reset-password-basic.html" target="_blank">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        Reset Password (Basic)
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/auth-reset-password-cover.html" target="_blank">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        Reset Password (Cover)
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="col-12 col-lg">
                  <div class="h6 d-flex align-items-center mb-2 mb-lg-4">
                    <div class="avatar avatar-sm flex-shrink-0 me-2">
                      <span class="avatar-initial rounded bg-label-primary">
                        <i class="icon-base ri ri-image-fill"></i>
                      </span>
                    </div>
                    <span class="ps-1">Other</span>
                  </div>
                  <ul class="nav flex-column">
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/pages-misc-error.html" target="_blank">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        Error
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/pages-misc-under-maintenance.html" target="_blank">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        Under Maintenance
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/pages-misc-comingsoon.html" target="_blank">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        Coming Soon
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/pages-misc-not-authorized.html" target="_blank">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        Not Authorized
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/auth-verify-email-basic.html" target="_blank">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        Verify Email (Basic)
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/auth-verify-email-cover.html" target="_blank">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        Verify Email (Cover)
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/auth-two-steps-basic.html" target="_blank">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        Two Steps (Basic)
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mega-dropdown-link" href="../vertical-menu-template/auth-two-steps-cover.html" target="_blank">
                        <i class="icon-base ri ri-circle-line icon-12px me-2"></i>
                        Two Steps (Cover)
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="col-lg-4 d-none d-lg-block">
                  <div class="bg-body nav-img-col p-2">
                    <img src="../../assets/img/front-pages/misc/nav-item-col-img-light.png" class="img-fluid scaleX-n1-rtl w-100" alt="nav item col image" data-app-light-img="front-pages/misc/nav-item-col-img-light.png" data-app-dark-img="front-pages/misc/nav-item-col-img-dark.png" />
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-medium" href="../vertical-menu-template/index.html" target="_blank">Admin</a>
          </li>
        </ul>
      </div>
      <div class="landing-menu-overlay d-lg-none"></div>
      <!-- Menu wrapper: End -->
      <!-- Toolbar: Start -->
      <ul class="navbar-nav flex-row align-items-center ms-auto">
        
          <!-- Style Switcher -->
          <li class="nav-item me-3">
                  <a id="theme-toggle" class="nav-link hide-arrow p-0" href="javascript:void(0);" data-theme="default">
                      <i id="theme-icon" class="ri-moon-line ri-22px"></i>
                  </a>
                </li>
          <!-- / Style Switcher-->
        
        <!-- navbar button: Start -->
        <li>
          <a href="../vertical-menu-template/auth-login-cover.html" class="btn btn-primary px-2 px-sm-4 px-lg-2 px-xl-4" target="_blank"> <span class="icon-base ri ri-user-line me-md-1 icon-18px"></span><span class="d-none d-md-block">Login/Register</span></a>
        </li>
        <!-- navbar button: End -->
      </ul>
      <!-- Toolbar: End -->
    </div>
  </div>
</nav>
<!-- Navbar: End -->


<!-- Sections:Start -->

  <div data-bs-spy="scroll" class="scrollspy-example">
    <!-- Hero: Start -->
    <section id="landingHero" class="section-py landing-hero position-relative">
      <img src="{{asset('img/front-pages/backgrounds/cta-bg.png')}}" alt="hero background" class="position-absolute top-0 start-0 w-100 h-100 z-n1" data-speed="1" data-app-light-img="front-pages/backgrounds/hero-bg-light.png" data-app-dark-img="front-pages/backgrounds/hero-bg-dark.png" />
      <div class="container">
        <div class="hero-text-box text-center">
          <h2 class="text-primary hero-title mb-4">All in one sass application for your business</h2>
          <h2 class="h6 mb-8 lh-md">No coding required to make customisations.<br />The live customiser has everything your marketing need.</h2>
          <a href="#landingPricing" class="btn btn-lg btn-primary">Get early access</a>
        </div>
        <div class="position-relative hero-animation-img">
          <a href="../vertical-menu-template/dashboards-crm.html" target="_blank">
            <div class="hero-dashboard-img text-center">
              <img src="../../assets/img/front-pages/landing-page/hero-dashboard-light.png" alt="hero dashboard" class="animation-img" data-speed="2" data-app-light-img="front-pages/landing-page/hero-dashboard-light.png" data-app-dark-img="front-pages/landing-page/hero-dashboard-dark.png" />
            </div>
            <div class="position-absolute hero-elements-img">
              <img src="../../assets/img/front-pages/landing-page/hero-elements-light.png" alt="hero elements" class="animation-img" data-speed="4" data-app-light-img="front-pages/landing-page/hero-elements-light.png" data-app-dark-img="front-pages/landing-page/hero-elements-dark.png" />
            </div>
          </a>
        </div>
      </div>
    </section>
    <!-- Hero: End -->

    <!-- Useful features: Start -->
    <section id="landingFeatures" class="section-py landing-features">
      <div class="container">
        <h6 class="text-center d-flex justify-content-center align-items-center mb-6">
          <img src="../../assets/img/front-pages/icons/section-title-icon.png" alt="section title icon" class="me-2" height="19" />
          <span class="text-uppercase">Useful features</span>
        </h6>
        <h5 class="text-center mb-2"><span class="h4 fw-bold">Everything you need</span> to start your next project</h5>
        <p class="text-center fw-medium mb-4 mb-md-12">Not just a set of tools, the package includes ready-to-deploy conceptual application.</p>
        <div class="features-icon-wrapper row gx-0 gy-12 gx-sm-6">
          <div class="col-lg-4 col-sm-6 text-center features-icon-box">
            <div class="features-icon mb-4">
              <img src="../../assets/img/front-pages/icons/laptop-charging.png" alt="laptop charging" />
            </div>
            <h5 class="mb-2">Quality Code</h5>
            <p class="features-icon-description">Code structure that all developers will easily understand and fall in love with.</p>
          </div>
          <div class="col-lg-4 col-sm-6 text-center features-icon-box">
            <div class="features-icon mb-4">
              <img src="../../assets/img/front-pages/icons/transition-up.png" alt="transition up" />
            </div>
            <h5 class="mb-2">Continuous Updates</h5>
            <p class="features-icon-description">Free updates for the next 12 months, including new demos and features.</p>
          </div>
          <div class="col-lg-4 col-sm-6 text-center features-icon-box">
            <div class="features-icon mb-4">
              <img src="../../assets/img/front-pages/icons/edit.png" alt="edit" />
            </div>
            <h5 class="mb-2">Stater-Kit</h5>
            <p class="features-icon-description">Start your project quickly without having to remove unnecessary features.</p>
          </div>
          <div class="col-lg-4 col-sm-6 text-center features-icon-box">
            <div class="features-icon mb-4">
              <img src="../../assets/img/front-pages/icons/3d-select-solid.png" alt="3d select solid" />
            </div>
            <h5 class="mb-2">API Ready</h5>
            <p class="features-icon-description">Just change the endpoint and see your own data loaded within seconds.</p>
          </div>
          <div class="col-lg-4 col-sm-6 text-center features-icon-box">
            <div class="features-icon mb-4">
              <img src="../../assets/img/front-pages/icons/lifebelt.png" alt="lifebelt" />
            </div>
            <h5 class="mb-2">Excellent Support</h5>
            <p class="features-icon-description">An easy-to-follow doc with lots of references and code examples.</p>
          </div>
          <div class="col-lg-4 col-sm-6 text-center features-icon-box">
            <div class="features-icon mb-4">
              <img src="../../assets/img/front-pages/icons/google-docs.png" alt="google docs" />
            </div>
            <h5 class="mb-2">Well Documented</h5>
            <p class="features-icon-description">An easy-to-follow doc with lots of references and code examples.</p>
          </div>
        </div>
      </div>
    </section>
    <!-- Useful features: End -->

    <!-- Real customers reviews: Start -->
    <section id="landingReviews" class="section-py bg-body landing-reviews">
      <div class="container">
        <h6 class="text-center d-flex justify-content-center align-items-center mb-6">
          <img src="../../assets/img/front-pages/icons/section-title-icon.png" alt="section title icon" class="me-2" height="19" />
          <span class="text-uppercase">real customers reviews</span>
        </h6>
        <h5 class="text-center mb-2"><span class="h4 fw-bold">Success stories</span> from clients</h5>
        <p class="text-center fw-medium mb-4 mb-md-12">See what our customers have to say about their experience.</p>
      </div>
      <div class="swiper-reviews-carousel overflow-hidden mb-12 pt-4">
        <div class="swiper" id="swiper-reviews">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="card h-100">
                <div class="card-body text-body d-flex flex-column justify-content-between text-center p-lg-8">
                  <div class="mb-4">
                    <img src="../../assets/img/front-pages/branding/logo-4.png" alt="client logo" class="client-logo img-fluid" />
                  </div>
                  <p class="text-heading">“I've never used a theme as versatile and flexible as Vuexy. It's my go to for building dashboard sites on almost any project.”</p>
                  <div class="text-warning mb-4">
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Eugenia Moore</h6>
                    <p class="mb-0 small">Founder of Hubspot</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card h-100">
                <div class="card-body text-body d-flex flex-column justify-content-between text-center p-lg-8">
                  <div class="mb-4">
                    <img src="../../assets/img/front-pages/branding/logo-1.png" alt="client logo" class="client-logo img-fluid" />
                  </div>
                  <p class="text-heading">Materio is awesome, and I particularly enjoy knowing that if I get stuck on something.</p>
                  <div class="text-warning mb-4">
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Tommy haffman</h6>
                    <p class="mb-0 small">Founder of Levis</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card h-100">
                <div class="card-body text-body d-flex flex-column justify-content-between text-center p-lg-8">
                  <div class="mb-4">
                    <img src="../../assets/img/front-pages/branding/logo-3.png" alt="client logo" class="client-logo img-fluid" />
                  </div>
                  <p class="text-heading">This template is superior in so many ways. The code, the design, the regular updates, the support.. It’s the whole package. Excellent Work.</p>
                  <div class="text-warning mb-4">
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Eugenia Moore</h6>
                    <p class="mb-0 small">CTO of Airbnb</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card h-100">
                <div class="card-body text-body d-flex flex-column justify-content-between text-center p-lg-8">
                  <div class="mb-4">
                    <img src="../../assets/img/front-pages/branding/logo-2.png" alt="client logo" class="client-logo img-fluid" />
                  </div>
                  <p class="text-heading">All the requirements for developers have been taken into consideration, so I’m able to build any interface I want.</p>
                  <div class="text-warning mb-4">
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Sara Smith</h6>
                    <p class="mb-0 small">Founder of Continental</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card h-100">
                <div class="card-body text-body d-flex flex-column justify-content-between text-center p-lg-8">
                  <div class="mb-4">
                    <img src="../../assets/img/front-pages/branding/logo-5.png" alt="client logo" class="client-logo img-fluid" />
                  </div>
                  <p class="text-heading">“I've never used a theme as versatile and flexible as Vuexy. It's my go to for building dashboard sites on almost any project.”</p>
                  <div class="text-warning mb-4">
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Eugenia Moore</h6>
                    <p class="mb-0 small">Founder of Hubspot</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card h-100">
                <div class="card-body text-body d-flex flex-column justify-content-between text-center h-100">
                  <div class="mb-4">
                    <img src="../../assets/img/front-pages/branding/logo-4.png" alt="client logo" class="client-logo img-fluid" />
                  </div>
                  <p class="text-heading">“I've never used a theme as versatile and flexible as Vuexy. It's my go to for building dashboard sites on almost any project.”</p>
                  <div class="text-warning mb-4">
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-line icon-24px"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Eugenia Moore</h6>
                    <p class="mb-0 small">Founder of Hubspot</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card h-100">
                <div class="card-body text-body d-flex flex-column justify-content-between text-center h-100">
                  <div class="mb-4">
                    <img src="../../assets/img/front-pages/branding/logo-1.png" alt="client logo" class="client-logo img-fluid" />
                  </div>
                  <p class="text-heading">Materio is awesome, and I particularly enjoy knowing that if I get stuck on something.</p>
                  <div class="text-warning mb-4">
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Tommy haffman</h6>
                    <p class="mb-0 small">Founder of Levis</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card h-100">
                <div class="card-body text-body d-flex flex-column justify-content-between text-center h-100">
                  <div class="mb-4">
                    <img src="../../assets/img/front-pages/branding/logo-3.png" alt="client logo" class="client-logo img-fluid" />
                  </div>
                  <p class="text-heading">This template is superior in so many ways. The code, the design, the regular updates, the support.. It’s the whole package. Excellent Work.</p>
                  <div class="text-warning mb-4">
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Eugenia Moore</h6>
                    <p class="mb-0 small">CTO of Airbnb</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card h-100">
                <div class="card-body text-body d-flex flex-column justify-content-between text-center h-100">
                  <div class="mb-4">
                    <img src="../../assets/img/front-pages/branding/logo-2.png" alt="client logo" class="client-logo img-fluid" />
                  </div>
                  <p class="text-heading">All the requirements for developers have been taken into consideration, so I’m able to build any interface I want.</p>
                  <div class="text-warning mb-4">
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-line icon-24px"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Sara Smith</h6>
                    <p class="mb-0 small">Founder of Continental</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card h-100">
                <div class="card-body text-body d-flex flex-column justify-content-between text-center h-100">
                  <div class="mb-4">
                    <img src="../../assets/img/front-pages/branding/logo-5.png" alt="client logo" class="client-logo img-fluid" />
                  </div>
                  <p class="text-heading">“I've never used a theme as versatile and flexible as Vuexy. It's my go to for building dashboard sites on almost any project.”</p>
                  <div class="text-warning mb-4">
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Eugenia Moore</h6>
                    <p class="mb-0 small">Founder of Hubspot</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card h-100">
                <div class="card-body text-body d-flex flex-column justify-content-between text-center p-lg-8">
                  <div class="mb-4">
                    <img src="../../assets/img/front-pages/branding/logo-4.png" alt="client logo" class="client-logo img-fluid" />
                  </div>
                  <p class="text-heading">“I've never used a theme as versatile and flexible as Vuexy. It's my go to for building dashboard sites on almost any project.”</p>
                  <div class="text-warning mb-4">
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Eugenia Moore</h6>
                    <p class="mb-0 small">Founder of Hubspot</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card h-100">
                <div class="card-body text-body d-flex flex-column justify-content-between text-center p-lg-8">
                  <div class="mb-4">
                    <img src="../../assets/img/front-pages/branding/logo-1.png" alt="client logo" class="client-logo img-fluid" />
                  </div>
                  <p class="text-heading">Materio is awesome, and I particularly enjoy knowing that if I get stuck on something.</p>
                  <div class="text-warning mb-4">
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Tommy haffman</h6>
                    <p class="mb-0 small">Founder of Levis</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card h-100">
                <div class="card-body text-body d-flex flex-column justify-content-between text-center p-lg-8">
                  <div class="mb-4">
                    <img src="../../assets/img/front-pages/branding/logo-3.png" alt="client logo" class="client-logo img-fluid" />
                  </div>
                  <p class="text-heading">This template is superior in so many ways. The code, the design, the regular updates, the support.. It’s the whole package. Excellent Work.</p>
                  <div class="text-warning mb-4">
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Eugenia Moore</h6>
                    <p class="mb-0 small">CTO of Airbnb</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card h-100">
                <div class="card-body text-body d-flex flex-column justify-content-between text-center p-lg-8">
                  <div class="mb-4">
                    <img src="../../assets/img/front-pages/branding/logo-2.png" alt="client logo" class="client-logo img-fluid" />
                  </div>
                  <p class="text-heading">All the requirements for developers have been taken into consideration, so I’m able to build any interface I want.</p>
                  <div class="text-warning mb-4">
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Sara Smith</h6>
                    <p class="mb-0 small">Founder of Continental</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card h-100">
                <div class="card-body text-body d-flex flex-column justify-content-between text-center p-lg-8">
                  <div class="mb-4">
                    <img src="../../assets/img/front-pages/branding/logo-5.png" alt="client logo" class="client-logo img-fluid" />
                  </div>
                  <p class="text-heading">“I've never used a theme as versatile and flexible as Vuexy. It's my go to for building dashboard sites on almost any project.”</p>
                  <div class="text-warning mb-4">
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                    <i class="icon-base ri ri-star-fill icon-24px"></i>
                  </div>
                  <div>
                    <h6 class="mb-1">Eugenia Moore</h6>
                    <p class="mb-0 small">Founder of Hubspot</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
      <div class="container">
        <div class="swiper-logo-carousel pt-lg-4 mt-12">
          <div class="swiper" id="swiper-clients-logos">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <img src="../../assets/img/front-pages/branding/logo-1-light.png" alt="client logo" class="client-logo" data-app-light-img="front-pages/branding/logo-1-light.png" data-app-dark-img="front-pages/branding/logo-1-dark.png" />
              </div>
              <div class="swiper-slide">
                <img src="../../assets/img/front-pages/branding/logo-2-light.png" alt="client logo" class="client-logo" data-app-light-img="front-pages/branding/logo-2-light.png" data-app-dark-img="front-pages/branding/logo-2-dark.png" />
              </div>
              <div class="swiper-slide">
                <img src="../../assets/img/front-pages/branding/logo-3-light.png" alt="client logo" class="client-logo" data-app-light-img="front-pages/branding/logo-3-light.png" data-app-dark-img="front-pages/branding/logo-3-dark.png" />
              </div>
              <div class="swiper-slide">
                <img src="../../assets/img/front-pages/branding/logo-4-light.png" alt="client logo" class="client-logo" data-app-light-img="front-pages/branding/logo-4-light.png" data-app-dark-img="front-pages/branding/logo-4-dark.png" />
              </div>
              <div class="swiper-slide">
                <img src="../../assets/img/front-pages/branding/logo-5-light.png" alt="client logo" class="client-logo" data-app-light-img="front-pages/branding/logo-5-light.png" data-app-dark-img="front-pages/branding/logo-5-dark.png" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Real customers reviews: End -->

    <!-- Our great team: Start -->
    <section id="landingTeam" class="section-py landing-team">
      <div class="container bg-icon-right position-relative">
        <img src="../../assets/img/front-pages/icons/bg-right-icon-light.png" alt="section icon" class="position-absolute top-0 end-0" data-speed="1" data-app-light-img="front-pages/icons/bg-right-icon-light.png" data-app-dark-img="front-pages/icons/bg-right-icon-dark.png" />
        <h6 class="text-center d-flex justify-content-center align-items-center mb-6">
          <img src="../../assets/img/front-pages/icons/section-title-icon.png" alt="section title icon" class="me-2" height="19" />
          <span class="text-uppercase">our great team</span>
        </h6>
        <h5 class="text-center mb-2"><span class="h4 fw-bold">Supported</span> by Real People</h5>
        <p class="text-center fw-medium mb-4 mb-md-12 pb-7">Who is behind these great-looking interfaces?</p>
        <div class="row gy-lg-5 gy-12 mt-2">
          <div class="col-lg-3 col-sm-6">
            <div class="card card-hover-border-primary mt-4 mt-lg-0 shadow-none">
              <div class="bg-label-primary position-relative team-image-box">
                <img src="../../assets/img/front-pages/landing-page/team-member-1.png" class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl" alt="human image" />
              </div>
              <div class="card-body text-center">
                <h5 class="card-title mb-0">Sophie Gilbert</h5>
                <p class="card-text mb-3">Project Manager</p>
                <div class="text-center team-media-icons">
                  <a href="javascript:void(0);" class="text-heading" target="_blank">
                    <i class="icon-base ri ri-facebook-circle-line icon-22px me-2"></i>
                  </a>
                  <a href="javascript:void(0);" class="text-heading" target="_blank">
                    <i class="icon-base ri ri-twitter-line icon-22px me-2"></i>
                  </a>
                  <a href="javascript:void(0);" class="text-heading" target="_blank">
                    <i class="icon-base ri ri-linkedin-box-line icon-22px"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="card card-hover-border-danger mt-4 mt-lg-0 shadow-none">
              <div class="bg-label-danger position-relative team-image-box">
                <img src="../../assets/img/front-pages/landing-page/team-member-2.png" class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl" alt="human image" />
              </div>
              <div class="card-body text-center">
                <h5 class="card-title mb-0">Nannie Ford</h5>
                <p class="card-text mb-3">Development Lead</p>
                <div class="text-center team-media-icons">
                  <a href="javascript:void(0);" class="text-heading" target="_blank">
                    <i class="icon-base ri ri-facebook-circle-line icon-22px me-2"></i>
                  </a>
                  <a href="javascript:void(0);" class="text-heading" target="_blank">
                    <i class="icon-base ri ri-twitter-line icon-22px me-2"></i>
                  </a>
                  <a href="javascript:void(0);" class="text-heading" target="_blank">
                    <i class="icon-base ri ri-linkedin-box-line icon-22px"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="card card-hover-border-success mt-4 mt-lg-0 shadow-none">
              <div class="bg-label-success position-relative team-image-box">
                <img src="../../assets/img/front-pages/landing-page/team-member-3.png" class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl" alt="human image" />
              </div>
              <div class="card-body text-center">
                <h5 class="card-title mb-0">Chris Watkins</h5>
                <p class="card-text mb-3">Marketing Manager</p>
                <div class="text-center team-media-icons">
                  <a href="javascript:void(0);" class="text-heading" target="_blank">
                    <i class="icon-base ri ri-facebook-circle-line icon-22px me-2"></i>
                  </a>
                  <a href="javascript:void(0);" class="text-heading" target="_blank">
                    <i class="icon-base ri ri-twitter-line icon-22px me-2"></i>
                  </a>
                  <a href="javascript:void(0);" class="text-heading" target="_blank">
                    <i class="icon-base ri ri-linkedin-box-line icon-22px"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="card card-hover-border-info mt-4 mt-lg-0 shadow-none">
              <div class="bg-label-info position-relative team-image-box">
                <img src="../../assets/img/front-pages/landing-page/team-member-4.png" class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl" alt="human image" />
              </div>
              <div class="card-body text-center">
                <h5 class="card-title mb-0">Paul Miles</h5>
                <p class="card-text mb-3">UI Designer</p>
                <div class="text-center team-media-icons">
                  <a href="javascript:void(0);" class="text-heading" target="_blank">
                    <i class="icon-base ri ri-facebook-circle-line icon-22px me-2"></i>
                  </a>
                  <a href="javascript:void(0);" class="text-heading" target="_blank">
                    <i class="icon-base ri ri-twitter-line icon-22px me-2"></i>
                  </a>
                  <a href="javascript:void(0);" class="text-heading" target="_blank">
                    <i class="icon-base ri ri-linkedin-box-line icon-22px"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Our great team: End -->

    <!-- Pricing plans: Start -->
    <section id="landingPricing" class="section-py bg-body landing-pricing">
      <div class="container bg-icon-left position-relative">
        <img src="../../assets/img/front-pages/icons/bg-left-icon-light.png" alt="section icon" class="position-absolute top-0 start-0" data-speed="1" data-app-light-img="front-pages/icons/bg-left-icon-light.png" data-app-dark-img="front-pages/icons/bg-left-icon-dark.png" />
        <h6 class="text-center d-flex justify-content-center align-items-center mb-6">
          <img src="../../assets/img/front-pages/icons/section-title-icon.png" alt="section title icon" class="me-2" height="19" />
          <span class="text-uppercase">pricing plans</span>
        </h6>
        <h5 class="text-center mb-2"><span class="h4 fw-bold">Tailored pricing plans</span> designed for you</h5>
        <p class="text-center fw-medium mb-10 mb-md-12 pb-lg-4">
          All plans include 40+ advanced tools and features to boost your product.<br />
          the best plan to fit your needs.
        </p>
        <div id="slider-pricing" class="mb-10 mb-md-12"></div>
        <div class="row gy-4 pt-lg-4">
          <!-- Basic Plan: Start -->
          <div class="col-xl-4 col-lg-6">
            <div class="card shadow-none">
              <div class="card-header border-0">
                <h4 class="mb-3 text-center">Basic Plan</h4>
                <div class="d-flex align-items-center">
                  <h5 class="d-flex mb-0"><sup class="h5 mt-4">$</sup><span class="display-3 fw-bold">20</span></h5>
                  <div class="ms-2 ps-1">
                    <h6 class="mb-1">Per month</h6>
                    <p class="small mb-0 text-body">10% off for yearly subscription</p>
                  </div>
                </div>
                <img src="../../assets/img/front-pages/icons/smiling-icon.png" alt="smiling icon" />
              </div>
              <div class="card-body">
                <ul class="list-unstyled">
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      Timeline
                    </h5>
                  </li>
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      Basic search
                    </h5>
                  </li>
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      Live chat widget
                    </h5>
                  </li>
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      Email marketing
                    </h5>
                  </li>
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      Custom Forms
                    </h5>
                  </li>
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      Traffic analytics
                    </h5>
                  </li>
                </ul>
                <hr />
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                  <div class="me-1">
                    <h6 class="mb-1">Basic Support</h6>
                    <p class="small mb-0 text-body">Only Email</p>
                  </div>
                  <span class="badge bg-label-primary rounded-pill">AVG. Time: 24h</span>
                </div>
                <div class="text-center mt-6 pt-2">
                  <a href="payment-page.html" class="btn btn-outline-primary w-100">Get Started</a>
                </div>
              </div>
            </div>
          </div>
          <!-- Basic Plan: End -->

          <!-- Favourite Plan: Start -->
          <div class="col-xl-4 col-lg-6">
            <div class="card border-primary border-2 shadow-none">
              <div class="card-header border-0">
                <h4 class="mb-3 text-center">Favourite Plan</h4>
                <div class="d-flex align-items-center">
                  <h5 class="d-flex mb-0"><sup class="h5 mt-4">$</sup><span class="display-3 fw-bold">51</span></h5>
                  <div class="ms-2 ps-1">
                    <h6 class="mb-1">Per month</h6>
                    <p class="small mb-0 text-body">10% off for yearly subscription</p>
                  </div>
                </div>
                <img src="../../assets/img/front-pages/icons/smiling-icon.png" alt="smiling icon" />
              </div>
              <div class="card-body">
                <ul class="list-unstyled">
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      Everything in basic
                    </h5>
                  </li>
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      Timeline with database
                    </h5>
                  </li>
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      Advanced search
                    </h5>
                  </li>
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      Marketing automation
                    </h5>
                  </li>
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      Advanced chatbot
                    </h5>
                  </li>
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      Campaign management
                    </h5>
                  </li>
                </ul>
                <hr />
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                  <div class="me-1">
                    <h6 class="mb-1">Standard Support</h6>
                    <p class="small mb-0 text-body">Email & Chat</p>
                  </div>
                  <span class="badge bg-label-primary rounded-pill">AVG. Time: 6h</span>
                </div>
                <div class="text-center mt-6 pt-2">
                  <a href="payment-page.html" class="btn btn-primary w-100">Get Started</a>
                </div>
              </div>
            </div>
          </div>
          <!-- Favourite Plan: End -->

          <!-- Standard Plan: Start -->
          <div class="col-xl-4 col-lg-6">
            <div class="card shadow-none">
              <div class="card-header border-0">
                <h4 class="mb-3 text-center">Standard Plan</h4>
                <div class="d-flex align-items-center">
                  <h5 class="d-flex mb-0"><sup class="h5 mt-4">$</sup><span class="display-3 fw-bold">99</span></h5>
                  <div class="ms-2 ps-1">
                    <h6 class="mb-1">Per month</h6>
                    <p class="small mb-0 text-body">10% off for yearly subscription</p>
                  </div>
                </div>
                <img src="../../assets/img/front-pages/icons/smiling-icon.png" alt="smiling icon" />
              </div>
              <div class="card-body">
                <ul class="list-unstyled">
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      Everything in premium
                    </h5>
                  </li>
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      Timeline with database
                    </h5>
                  </li>
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      Fuzzy search
                    </h5>
                  </li>
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      A/B testing sanbox
                    </h5>
                  </li>
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      Custom permissions
                    </h5>
                  </li>
                  <li>
                    <h5 class="mb-3">
                      <img src="../../assets/img/front-pages/icons/list-arrow-icon.png" alt="list arrow icon" class="me-2 pe-1 scaleX-n1-rtl" />
                      Social media automation
                    </h5>
                  </li>
                </ul>
                <hr />
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                  <div class="me-1">
                    <h6 class="mb-1">Exclusive Support</h6>
                    <p class="small mb-0 text-body">Email, Chat & Google Meet</p>
                  </div>
                  <span class="badge bg-label-primary rounded-pill">Live Support</span>
                </div>
                <div class="text-center mt-6 pt-2">
                  <a href="payment-page.html" class="btn btn-outline-primary w-100">Get Started</a>
                </div>
              </div>
            </div>
          </div>
          <!-- Standard Plan: End -->
        </div>
      </div>
    </section>
    <!-- Pricing plans: End -->

    <!-- Fun facts: Start -->
    <section id="landingFunFacts" class="section-py landing-fun-facts py-12 my-4">
      <div class="container">
        <div class="row gx-0 gy-5 gx-sm-6">
          <div class="col-md-3 col-sm-6 text-center">
            <span class="badge rounded-pill bg-label-primary bg-label-hover fun-facts-icon mb-6 p-5"><i class="icon-base ri ri-layout-line icon-42px"></i></span>
            <h2 class="fw-bold mb-0 fun-facts-text">137+</h2>
            <h6 class="mb-0 text-body">Completed Sites</h6>
          </div>
          <div class="col-md-3 col-sm-6 text-center">
            <span class="badge rounded-pill bg-label-success bg-label-hover fun-facts-icon mb-6 p-5"><i class="icon-base ri ri-time-line icon-42px"></i></span>
            <h2 class="fw-bold mb-0 fun-facts-text">1,100+</h2>
            <h6 class="mb-0 text-body">Working Hours</h6>
          </div>
          <div class="col-md-3 col-sm-6 text-center">
            <span class="badge rounded-pill bg-label-warning bg-label-hover fun-facts-icon mb-6 p-5"><i class="icon-base ri ri-user-smile-line icon-42px"></i></span>
            <h2 class="fw-bold mb-0 fun-facts-text">137+</h2>
            <h6 class="mb-0 text-body">Happy Customers</h6>
          </div>
          <div class="col-md-3 col-sm-6 text-center">
            <span class="badge rounded-pill bg-label-info bg-label-hover fun-facts-icon mb-6 p-5"><i class="icon-base ri ri-award-line icon-42px"></i></span>
            <h2 class="fw-bold mb-0 fun-facts-text">23+</h2>
            <h6 class="mb-0 text-body">Awards Winning</h6>
          </div>
        </div>
      </div>
    </section>
    <!-- Fun facts: End -->

    <!-- FAQ: Start -->
    <section id="landingFAQ" class="section-py bg-body landing-faq">
      <div class="container bg-icon-right">
        <img src="../../assets/img/front-pages/icons/bg-right-icon-light.png" alt="section icon" class="position-absolute top-0 end-0" data-speed="1" data-app-light-img="front-pages/icons/bg-right-icon-light.png" data-app-dark-img="front-pages/icons/bg-right-icon-dark.png" />
        <h6 class="text-center d-flex justify-content-center align-items-center mb-6">
          <img src="../../assets/img/front-pages/icons/section-title-icon.png" alt="section title icon" class="me-2" height="19" />
          <span class="text-uppercase">faq</span>
        </h6>
        <h5 class="text-center mb-2">Frequently asked<span class="h4 fw-bold"> questions</span></h5>
        <p class="text-center fw-medium mb-4 mb-md-12 pb-4">Browse through these FAQs to find answers to commonly asked questions.</p>
        <div class="row gy-5">
          <div class="col-lg-5">
            <div class="text-center">
              <img
                src="../../assets/img/front-pages/landing-page/sitting-girl-with-laptop.png
          "
                alt="sitting girl with laptop"
                class="faq-image scaleX-n1-rtl" />
            </div>
          </div>
          <div class="col-lg-7">
            <div class="accordion" id="accordionFront">
              <div class="accordion-item">
                <h2 class="accordion-header" id="head-One">
                  <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">Do you charge for each upgrade?</button>
                </h2>

                <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionFront" aria-labelledby="accordionOne">
                  <div class="accordion-body">Lemon drops chocolate cake gummies carrot cake chupa chups muffin topping. Sesame snaps icing marzipan gummi bears macaroon dragée danish caramels powder. Bear claw dragée pastry topping soufflé. Wafer gummi bears marshmallow pastry pie.</div>
                </div>
              </div>
              <div class="accordion-item previous-active">
                <h2 class="accordion-header" id="head-Two">
                  <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">Do I need to purchase a license for each website?</button>
                </h2>
                <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="accordionTwo" data-bs-parent="#accordionFront">
                  <div class="accordion-body">Dessert ice cream donut oat cake jelly-o pie sugar plum cheesecake. Bear claw dragée oat cake dragée ice cream halvah tootsie roll. Danish cake oat cake pie macaroon tart donut gummies. Jelly beans candy canes carrot cake. Fruitcake chocolate chupa chups.</div>
                </div>
              </div>
              <div class="accordion-item active">
                <h2 class="accordion-header" id="head-Three">
                  <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionThree" aria-expanded="true" aria-controls="accordionThree">What is regular license?</button>
                </h2>
                <div id="accordionThree" class="accordion-collapse collapse show" aria-labelledby="accordionThree" data-bs-parent="#accordionFront">
                  <div class="accordion-body">
                    Regular license can be used for end products that do not charge users for access or service(access is free and there will be no monthly subscription fee). Single regular license can be used for single end product and end product can be used by you or your client. If you want to sell end product to multiple clients then you will need to purchase separate license for each client. The same rule applies if you want to use the same end product on multiple domains(unique setup).
                    For more info on regular license you can check official description.
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="head-Four">
                  <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionFour" aria-expanded="false" aria-controls="accordionFour">What is extended license?</button>
                </h2>
                <div id="accordionFour" class="accordion-collapse collapse" aria-labelledby="accordionFour" data-bs-parent="#accordionFront">
                  <div class="accordion-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis et aliquid quaerat possimus maxime! Mollitia reprehenderit neque repellat deleniti delectus architecto dolorum maxime, blanditiis earum ea, incidunt quam possimus cumque.</div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="head-Five">
                  <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionFive" aria-expanded="false" aria-controls="accordionFive">Which license is applicable for SASS application?</button>
                </h2>
                <div id="accordionFive" class="accordion-collapse collapse" aria-labelledby="accordionFive" data-bs-parent="#accordionFront">
                  <div class="accordion-body">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi molestias exercitationem ab cum nemo facere voluptates veritatis quia, eveniet veniam at et repudiandae mollitia ipsam quasi labore enim architecto non!</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- FAQ: End -->

    <!-- CTA: Start -->
    <section id="landingCTA" class="section-py landing-cta p-lg-0 pb-0 position-relative">
      <img src="../../assets/img/front-pages/backgrounds/cta-bg.png" class="position-absolute bottom-0 end-0 scaleX-n1-rtl h-100 w-100 z-n1" alt="cta image" />
      <div class="container">
        <div class="row align-items-center gy-5 gy-lg-0">
          <div class="col-lg-6 text-center text-lg-start">
            <h2 class="display-5 text-primary fw-bold mb-0">Ready to Get Started?</h2>
            <p class="fw-medium mb-6 mb-md-8">Start your project with a 14-day free trial</p>
            <a href="payment-page.html" class="btn btn-primary">Get Started<i class="icon-base ri ri-arrow-right-line icon-16px ms-2 scaleX-n1-rtl"></i></a>
          </div>
          <div class="col-lg-6 pt-lg-12">
            <img src="../../assets/img/front-pages/landing-page/cta-dashboard.png" alt="cta dashboard" class="img-fluid" />
          </div>
        </div>
      </div>
    </section>
    <!-- CTA: End -->

    <!-- Contact Us: Start -->
    <section id="landingContact" class="section-py bg-body landing-contact">
      <div class="container bg-icon-left position-relative">
        <img src="../../assets/img/front-pages/icons/bg-left-icon-light.png" alt="section icon" class="position-absolute top-0 start-0" data-speed="1" data-app-light-img="front-pages/icons/bg-left-icon-light.png" data-app-dark-img="front-pages/icons/bg-left-icon-dark.png" />
        <h6 class="text-center d-flex justify-content-center align-items-center mb-6">
          <img src="../../assets/img/front-pages/icons/section-title-icon.png" alt="section title icon" class="me-2" height="19" />
          <span class="text-uppercase">contact us</span>
        </h6>
        <h5 class="text-center mb-2"><span class="h4 fw-bold">Lets work</span> together</h5>
        <p class="text-center fw-medium mb-4 mb-md-12 pb-3">Any question or remark? just write us a message</p>
        <div class="row gy-4">
          <div class="col-lg-5">
            <div class="card h-100">
              <div class="bg-primary rounded text-white card-body p-lg-8">
                <p class="fw-medium mb-2 tagline">Let’s contact with us</p>
                <p class="display-6 mb-5 title">Share your ideas or requirement with our experts.</p>
                <img src="../../assets/img/front-pages/landing-page/let’s-contact.png" alt="let’s contact" class="w-100 mb-4 pb-1" />
                <p class="mb-0 description">Looking for more customisation, more features, and more anything? Don’t worry, We’ve provide you with an entire team of experienced professionals.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="card">
              <div class="card-body">
                <h5 class="mb-6">Share your ideas</h5>
                <form>
                  <div class="row g-5">
                    <div class="col-md-6">
                      <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" />
                        <label for="basic-default-fullname">Full name</label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating form-floating-outline">
                        <input type="email" class="form-control" id="basic-default-email" placeholder="johndoe99@gmail.com" />
                        <label for="basic-default-email">Email address</label>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-floating form-floating-outline">
                        <textarea class="form-control h-px-200" placeholder="Message" aria-label="Message" id="basic-default-message"></textarea>
                        <label for="basic-default-message">Message</label>
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary mt-5">Send inquiry</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Contact Us: End -->
  </div>

<!-- / Sections:End -->



<!-- Footer: Start -->
<footer class="landing-footer">
  <div class="footer-top position-relative overflow-hidden">
    <img src="../../assets/img/front-pages/backgrounds/footer-bg.png" alt="footer bg" class="footer-bg banner-bg-img"/>
    <div class="container">
      <div class="row gx-0 gy-6 g-lg-10">
        <div class="col-lg-5">
          <a href="landing-page.html" class="app-brand-link mb-6">
            <span class="app-brand-logo demo">
  <span class="text-primary">
    <svg width="30" height="24" viewBox="0 0 250 196" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" clip-rule="evenodd" d="M12.3002 1.25469L56.655 28.6432C59.0349 30.1128 60.4839 32.711 60.4839 35.5089V160.63C60.4839 163.468 58.9941 166.097 56.5603 167.553L12.2055 194.107C8.3836 196.395 3.43136 195.15 1.14435 191.327C0.395485 190.075 0 188.643 0 187.184V8.12039C0 3.66447 3.61061 0.0522461 8.06452 0.0522461C9.56056 0.0522461 11.0271 0.468577 12.3002 1.25469Z" fill="currentColor" />
      <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd" d="M0 65.2656L60.4839 99.9629V133.979L0 65.2656Z" fill="black" />
      <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd" d="M0 65.2656L60.4839 99.0795V119.859L0 65.2656Z" fill="black" />
      <path fill-rule="evenodd" clip-rule="evenodd" d="M237.71 1.22393L193.355 28.5207C190.97 29.9889 189.516 32.5905 189.516 35.3927V160.631C189.516 163.469 191.006 166.098 193.44 167.555L237.794 194.108C241.616 196.396 246.569 195.151 248.856 191.328C249.605 190.076 250 188.644 250 187.185V8.09597C250 3.64006 246.389 0.027832 241.935 0.027832C240.444 0.027832 238.981 0.441882 237.71 1.22393Z" fill="currentColor" />
      <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd" d="M250 65.2656L189.516 99.8897V135.006L250 65.2656Z" fill="black" />
      <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd" d="M250 65.2656L189.516 99.0497V120.886L250 65.2656Z" fill="black" />
      <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2787 1.18923L125 70.3075V136.87L0 65.2465V8.06814C0 3.61223 3.61061 0 8.06452 0C9.552 0 11.0105 0.411583 12.2787 1.18923Z" fill="currentColor" />
      <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2787 1.18923L125 70.3075V136.87L0 65.2465V8.06814C0 3.61223 3.61061 0 8.06452 0C9.552 0 11.0105 0.411583 12.2787 1.18923Z" fill="white" fill-opacity="0.15" />
      <path fill-rule="evenodd" clip-rule="evenodd" d="M237.721 1.18923L125 70.3075V136.87L250 65.2465V8.06814C250 3.61223 246.389 0 241.935 0C240.448 0 238.99 0.411583 237.721 1.18923Z" fill="currentColor" />
      <path fill-rule="evenodd" clip-rule="evenodd" d="M237.721 1.18923L125 70.3075V136.87L250 65.2465V8.06814C250 3.61223 246.389 0 241.935 0C240.448 0 238.99 0.411583 237.721 1.18923Z" fill="white" fill-opacity="0.3" />
    </svg>
  </span>
</span>
            <span class="app-brand-text demo text-white fw-semibold ms-2 ps-1">Materio</span>
          </a>
          <p class="footer-text footer-logo-description mb-6">Most Powerful & Comprehensive 🤩 React NextJS Admin Template with Elegant Material Design & Unique Layouts.</p>
          <form class="footer-form">
            <div class="d-flex mt-2 gap-4">
              <div class="form-floating form-floating-outline w-px-250">
                <input type="text" class="form-control bg-transparent" id="newsletter-1" placeholder="Your email"/>
                <label for="newsletter-1">Subscribe to newsletter</label>
              </div>
              <button type="submit" class="btn btn-primary">Subscribe</button>
            </div>
          </form>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
          <h6 class="footer-title mb-4 mb-lg-6">Demos</h6>
          <ul class="list-unstyled mb-0">
            <li class="mb-4">
              <a href="../vertical-menu-template/" target="_blank" class="footer-link">Vertical Layout</a>
            </li>
            <li class="mb-4">
              <a href="../horizontal-menu-template/" target="_blank" class="footer-link">Horizontal Layout</a>
            </li>
            <li class="mb-4">
              <a href="../vertical-menu-template-bordered/" target="_blank" class="footer-link">Bordered Layout</a>
            </li>
            <li class="mb-4">
              <a href="../vertical-menu-template-semi-dark/" target="_blank" class="footer-link">Semi Dark Layout</a>
            </li>
            <li>
              <a href="../vertical-menu-template-dark/" target="_blank" class="footer-link">Dark Layout</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
          <h6 class="footer-title mb-4 mb-lg-6">Pages</h6>
          <ul class="list-unstyled mb-0">
            <li class="mb-4">
              <a href="pricing-page.html" class="footer-link">Pricing</a>
            </li>
            <li class="mb-4">
              <a href="payment-page.html" class="footer-link">Payment<span class="badge rounded-pill bg-primary ms-2">New</span></a>
            </li>
            <li class="mb-4">
              <a href="checkout-page.html" class="footer-link">Checkout</a>
            </li>
            <li class="mb-4">
              <a href="help-center-landing.html" class="footer-link">Help Center</a>
            </li>
            <li>
              <a href="../vertical-menu-template/auth-login-cover.html" target="_blank" class="footer-link">Login/Register</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-4">
          <h6 class="footer-title mb-4 mb-lg-6">Download our app</h6>
          <a href="javascript:void(0);" class="d-block footer-link mb-4"><img src="../../assets/img/front-pages/landing-page/apple-icon.png" alt="apple icon"/></a>
          <a href="javascript:void(0);" class="d-block footer-link"><img src="../../assets/img/front-pages/landing-page/google-play-icon.png" alt="google play icon"/></a>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom py-5">
    <div class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
      <div class="mb-2 mb-md-0">
        <span class="footer-bottom-text">©
          <script>
            document.write(new Date().getFullYear());
          </script>
          , Made with
          <i class="icon-base ri ri-heart-fill text-danger"></i>
          by
        </span>
        <a href="https://themeselection.com" target="_blank" class="footer-link fw-medium footer-theme-link">ThemeSelection</a>
      </div>
      <div>
        <a href="https://github.com/themeselection" class="footer-link me-4" target="_blank">
          <i class="icon-base ri ri-github-fill icon-18px"></i>
        </a>
        <a href="https://www.facebook.com/ThemeSelections/" class="footer-link me-4" target="_blank">
          <i class="icon-base ri ri-facebook-circle-fill icon-18px"></i>
        </a>
        <a href="https://x.com/Theme_Selection" class="footer-link me-4" target="_blank">
          <i class="icon-base ri ri-twitter-x-fill icon-18px"></i>
        </a>
        <a href="https://www.instagram.com/themeselection/" class="footer-link" target="_blank">
          <i class="icon-base ri ri-instagram-line icon-18px"></i>
        </a>
      </div>
    </div>
  </div>
</footer>
<!-- Footer: End -->

    

  

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/theme.js -->
    
    
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>

    
      
      <script src="../../assets/vendor/libs/@algolia/autocomplete-js.js"></script>
      
      <script src="../../assets/vendor/libs/pickr/pickr.js"></script>
    

    
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/nouislider/nouislider.js"></script>
  <script src="../../assets/vendor/libs/swiper/swiper.js"></script>

    <!-- Main JS -->
    
      <script src="../../assets/js/front-main.js"></script>
    

    <!-- Page JS -->
    <script src="../../assets/js/front-page-landing.js"></script>
    
  </body>
</html>

  <!-- beautify ignore:end -->

