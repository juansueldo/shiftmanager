
<div id="table-default" class="table-responsive mt-5 px-3" >
    <table class="table my-3" id="{{ $data['id'] }}" data-lang="{{ $user->language }}" data-path="{{ $data['path'] }}" data-columns="{{ json_encode($data['headers']) }}">
        <thead>
            <tr>
                @foreach($data['headers'] as $header)
                    <th data-columnname="{{ $header['key'] }}" 
                        data-searchable="{{ $header['searchable'] }}"
                        data-orderable="{{ $header['orderable'] }}"
                        data-visible="{{ $header['visible'] }}">
                        {{ __( "{$data['file']}.{$header['name']}") }}
                    </th>
                @endforeach
            </tr>
        </thead>
    </table>
</div>
<script>
    (function(initFn) {
        if (window.jQuery) {
            $(document).ready(initFn);
        } else {
            document.addEventListener("DOMContentLoaded", initFn);
        }
    })(function() {
        addDatatable("#{{ $data['id'] }}");
    });
</script>

