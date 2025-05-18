<div class="container-xxl flex-grow-1 container-p-y">
    <h3>{{ __('dashboard.welcome') }} <span class="text-muted text-small">{{ $user->firstname }} {{ $user->lastname }}</span> 👋🏻</h3>
    <div class="d-flex justify-content-end mb-3">
        <!-- Aquí puedes agregar botones o acciones adicionales -->
    </div>
    <div id="grid-stack" class="d-flex flex-wrap gap-1">
        @foreach($widgets as $widget)
            <div class="card grid-stack-item" 
                    gs-x="{{ $widget['x'] }}" 
                    gs-y="{{ $widget['y'] }}" 
                    gs-w="{{ $widget['width'] }}" 
                    gs-h="{{ $widget['height'] }}" 
                    data-id="{{ $widget['id'] }}">
                <div class="grid-stack-item-content  p-3">
                    <a href="javascript:;" class="position-absolute top-0 end-0 m-2 btn-delete-widget text-body btn-delete" data-ajax-source="/widgets/delete/{{ $widget['id'] }}" data-ajax-method="replaceHtml" data-ajax-container="span#content-wrapper">
                        <i class="ri-delete-bin-5-line ti-sm me-2"></i>
                    </a>
                    @include('layouts.partials.' . $widget['name'], ['data' => $widget['data']])            
                </div>
            </div>
        @endforeach
    </div>
</div>
@include('layouts.partials.alert', ['session'=> $session ?? ''])
<script>
    
    (function() {
        function excuteReadyDOM() {
            initGridStack("#grid-stack");
        }

        if (typeof $ !== 'undefined' && $.isReady) {
            excuteReadyDOM();
        } else if (typeof $ !== 'undefined') {
            $(document).ready(excuteReadyDOM);
        } else {
            document.addEventListener('DOMContentLoaded', excuteReadyDOM);
        }
    })();
</script>