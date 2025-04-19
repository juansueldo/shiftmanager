<div class="container-xxl flex-grow-1 container-p-y">
    <h3>{{ __('dashboard.welcome') }} <span class="text-muted text-small">{{ $user->firstname }} {{ $user->lastname }}</span> 👋🏻</h3>
    <div class="d-flex justify-content-end mb-3">
        <!-- Aquí puedes agregar botones o acciones adicionales -->
    </div>
    <div id="grid-stack">
        @foreach($widgets as $widget)
            <div class="card grid-stack-item" 
                    gs-x="{{ $widget['x'] }}" 
                    gs-y="{{ $widget['y'] }}" 
                    gs-w="{{ $widget['width'] }}" 
                    gs-h="{{ $widget['height'] }}" 
                    data-id="{{ $widget['id'] }}">
                <div class="grid-stack-item-content  p-3">
                    {{ $widget['name'] }}
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Inicializar GridStack
        initGridStack("#grid-stack");
    });
</script>