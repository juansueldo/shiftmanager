<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo me-1"></span>
            <!--<span class="app-brand-text demo menu-text fw-semibold ms-2">Clinic App</span>-->
            <img src="{{ asset('img/logo.png') }}" alt="Shiftmanager" class="w-100 h-auto" style="max-width: 150px;">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="menu-toggle-icon d-xl-block align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @foreach($options as $index => $value)
        <li class="menu-item {{ isset($value['class']) ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link" 
                data-ajax-source="{{ $value['data-ajax-source'] }}" 
                data-ajax-method="{{ $value['data-ajax-method'] }}" 
                data-ajax-container="{{ $value['data-ajax-container'] }}">
                <i class="menu-icon tf-icons {{ $value['icon'] }}"></i>
                <div data-i18n="Dashboards">{{ $value['name'] }}</div>
            </a>
        </li>
        @endforeach   
    </ul>
</aside>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('layout-menu');
    const toggleButton = document.querySelector('.layout-menu-toggle');

    toggleButton.addEventListener('click', function () {
      sidebar.classList.toggle('collapsed');
    });

    // Activar menú
    const menuLinks = document.querySelectorAll('.menu-link');
    menuLinks.forEach(function (link) {
      link.addEventListener('click', function () {
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(function (item) {
          item.classList.remove('active');
        });
        const closestItem = this.closest('.menu-item');
        if (closestItem) {
          closestItem.classList.add('active');
        }
      });
    });
  });
</script>
