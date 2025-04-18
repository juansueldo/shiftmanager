<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.png') }}" />
    @vite([
        'resources/css/app.css', 
        'resources/assets/css/theme-default.css', 
        'resources/assets/css/core.css', 
        'resources/assets/css/demo.css',
        'resources/assets/fonts/remixicon/remixicon.css',
        'resources/js/app.js',
        'resources/assets/js/request.js',
        'resources/assets/js/theme.js',
        'resources/assets/js/calendar.js',
        'resources/assets/js/datatable.js',
        'resources/assets/js/validation.js',
        'resources/js/helpers.js',
        'resources/js/menu.js',
        'resources/js/config.js',
        'resources/js/dashboards-analytics.js',
        'resources/js/main.js',
        'resources/js/select2.full.min.js',
        'resources/css/select2.css',])
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />

    <title>Shiftmanager | Dashboard</title>
</head>

<body>

    <!-- Contenedor principal -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        @include('layouts.partials.sidebar',['options' => $sidebar])
        <!-- / Menu -->
        @include('layouts.partials.canvas')
        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
         <span id="navbar-container">
           @include('layouts.partials.navbar', [ 'navbar' => $navbar, 'user' => $user])
         </span>

          <!-- / Navbar -->
          
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <span id="content-wrapper">
              @include('sections.dashboard', ['user' => $user])
            </span>
           
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div
                  class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                  <div class="text-body mb-2 mb-md-0">
                    ©
                    <script>
                      document.write(new Date().getFullYear());
                    </script>
                    , made with <span class="text-danger"><i class="tf-icons ri-heart-fill"></i></span> by
                    <a href="https://themeselection.com" target="_blank" class="footer-link">Juan Sueldo</a>
                  </div>
                  
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <script>
            
            document.addEventListener("DOMContentLoaded", function () {
    // Inicializa el evento al cargar la página
    initializeThemeToggle();

    // Escucha cambios en el DOM para recargar el evento si el navbar cambia
    const navbarContainer = document.getElementById("layout-navbar");
    if (navbarContainer) {
        const observer = new MutationObserver(() => {
            initializeThemeToggle();
        });

        observer.observe(navbarContainer, { childList: true, subtree: true });
    }
});

function initializeThemeToggle() {
    const themeToggle = document.getElementById("theme-toggle");
    const themeIcon = document.getElementById("theme-icon");
    if (themeToggle && themeIcon) {
        setupThemeToggle(themeToggle, themeIcon, document.documentElement);
    }
}
          </script>

</body>
</html>