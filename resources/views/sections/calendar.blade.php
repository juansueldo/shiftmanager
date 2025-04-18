
<div class="container-xxl flex-grow-1 container-p-y">
    <h3>{{__('calendar.title')}} <span class="text-muted text-small">{{ __('calendar.span') }}</span></h3>
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary waves-effect waves-light"  
            data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasEnd"
            aria-controls="offcanvasEnd"
            data-ajax-source="/calendar/add"
            data-ajax-method="replaceHtml"
            data-ajax-container="#offcanvasEnd"
            ><i class="ri-add-line"></i> {{__('calendar.add_event')}}</button>
    </div>
    <div id="calendar" data-ajax-data="{{ $calendarevents}}"></div>
    <div id="language" data-ajax-data="{{ $user->language }}"></div>
</div>

@include('layouts.partials.alert', ['session'=> $session ?? ''])
<script>
    $(document).ready(function() {
        var $calendarElement = $('#calendar'); 
        let $languageElement = $('#language');
        let language = $languageElement.data('ajax-data');
        if ($calendarElement.length) {
            initializeCalendar($calendarElement[0], language); 
        }
    });
</script>