
<div id="table-default" class="table-responsive">
    <table class="table my-3" id="{{ $table['id'] }}" data-path="{{ $table['path'] }}" data-columns="{{ json_encode($table['headers']) }}">
        <thead>
            <tr>
                @foreach($table['headers'] as $header)
                    <th data-columnname="{{ $header['key'] }}" 
                        data-searchable="{{ $header['searchable'] }}"
                        data-orderable="{{ $header['orderable'] }}"
                        data-visible="{{ $header['visible'] }}">
                        {{ $header['name'] }}
                    </th>
                @endforeach
            </tr>
        </thead>
    </table>
</div>
<script>
    $(document).ready(function() {
        addDatatable("#{{ $table['id'] }}");
    });
</script>