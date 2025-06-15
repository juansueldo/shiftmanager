<div class="container-xxl flex-grow-1 container-p-y">
    <h3>{{__('user.account')}} <span class="text-muted text-small"> {{ __('user.span_account') }}</span></h3>
<div class="card mb-4">
    <!-- Billing Address -->
    <h5 class="card-header">Billing Address</h5>
    <div class="card-body">
        <form  class="form-floating" 
    id="{{ $formdata['id'] }}"
    data-ajax-validated="true"
     data-ajax-form="true"
    data-ajax-source="{{ $formdata['source'] }}" 
    data-ajax-method="{{ $formdata['method'] }}"
    data-ajax-container="{{ $formdata['container'] }}"
    data-ajax-then="{{ $formdata['then'] }}">
    @csrf
    <div class="row">
        @foreach ($inputs as $input)
            <div class="mb-3 col-{{ $input['col'] }}">
                <div class="form-floating form-floating-outline">
                
                @if ($input['type'] == 'select')
                <select                  
                    {{ !empty($input['multiple']) ? 'multiple' : '' }}
                    name="{{ $input['name'] }}{{ !empty($input['multiple']) ? '[]' : '' }}"
                    id="{{ $input['name'] }}"
                    class="form-select"
                    data-ajax-checker="{{ $input['checker'] ?? '' }}"
                    data-ajax-url="{{ $input['url'] ?? '' }}"
                    data-ajax-method="{{ $input['method'] ?? '' }}"
                    data-ajax-container="{{ $input['container'] ?? '' }}"
                    data-selected='@json($input['selected_data'] ?? [])'

                    >
                        @if(isset($input['options']))
                        @foreach ($input['options'] as $option)
                            <option value="{{ $option['value'] }}" {{ isset($event) && $event->{$input['name']} == $option['value'] ? 'selected' : '' }}>
                                {{ $option['text'] }}
                            </option>
                        @endforeach
                        @endif
                    </select>
                @else
                    <input 
                    @if (isset($input['data']) && is_array($input['data']))
                        @foreach ($input['data'] as $dataKey => $dataValue)
                            data-{{ $dataKey }}="{{ __($dataValue) }}"
                        @endforeach
                    @endif
                    type="{{ $input['type'] }}" id="{{ $input['name'] }}" name="{{ $input['name'] }}" class="form-control mb-2" placeholder="{{ $input['placeholder'] ?? '' }}" value="{{ $input['value'] }}" data-ajax-checker="{{ $input['checker'] ?? '' }}" data-ajax-minlength="{{ $input['minlength'] ?? ''}}" data-ajax-container="{{ $input['container'] ?? ''}}" data-ajax-method="{{ $input['method'] ?? ''}}"/>
                @endif
                @if (isset($input['label']))
                    <label for="{{ $input['name'] }}">{{ __("{$formdata['file']}.{$input['label']}") }}</label>
                @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="offcanvas-body my-auto mx-0 flex-grow-0">
        <button type="submit" class="btn btn-primary mb-2 d-grid w-100">{{__('messages.save')}}</button>
    </div>
</form>




                    </div>
                    <!-- /Billing Address -->
                  </div>
                  </div>
                  @include('layouts.partials.alert', ['session'=> $session ?? ''])
                  <script>
$(document).ready(function () {
    const formValidator = new Formshield("#{{ $formdata['id'] }}");

    $('.form-floating [data-ajax-checker]').each(function () {
        let element = $(this);
        let checkerPath = element.data('ajax-checker');
        let container = element.data('ajax-container');
        let method = element.data('ajax-method');
        let minLength = parseInt(element.data('ajax-minlength')) || 0;

        if (typeof container === 'string') {
            try {
                container = JSON.parse(container); // Intentar convertir JSON string a array
            } catch (e) {
                container = []; // En caso de error, asignar un array vacío
            }
        }

        if (checkerPath) {
            var validateValue = function () {
                var value = element.val().trim(); // Eliminar espacios en blanco
                if (!value || value.length < minLength) return; // Evita enviar peticiones vacías o menores al mínimo

                var formData = new FormData();
                //formData.append('identifier', value);
                formData.append(element.attr('id'), value);
                formData.append('_token', '{{ csrf_token() }}');

                updatePart(checkerPath, formData, container, 'POST', method);
            };

            if (element.is('input')) {
                element.on('input', validateValue);
            }
            element.on('change', validateValue);
        }
    });

    // Manejar selects con data-ajax-url
    $(document).ready(function () {
    $('.form-floating select').each(function () {
        let $select = $(this);
        let ajaxUrl = $select.data('ajax-url');
        let method = $select.data('ajax-method') || 'GET';
        const theme = $select.data('theme') || 'default';
        let selectedValues = $select.data('selected') || [];

        // Si tiene el atributo `multi`, se convierte en multiple
        if ($select.attr('multi') !== undefined) {
            $select.attr('multiple', 'multiple');
        }

        // Convertir en array si es string tipo JSON
        if (typeof selectedValues === 'string') {
            try {
                selectedValues = JSON.parse(selectedValues.replace(/'/g, '"'));
            } catch (e) {
                console.warn('Error al parsear data-selected', e);
                selectedValues = [];
            }
        }

        // Función para inicializar Select2
        const initializeSelect2 = (options = {}) => {
            $select.select2({
                theme: theme,
                width: '100%',
                placeholder: "{{ __('messages.select_placeholder') }}",
                allowClear: true,
                dropdownParent: $(document.body),
                ...options // Permite sobreescribir opciones base
            });

            // Cargar valores seleccionados manualmente si existen
            if (Array.isArray(selectedValues) && selectedValues.length > 0) {
                selectedValues.forEach(option => {
                    const newOption = new Option(option.text, option.id, true, true);
                    $select.append(newOption);
                });
                $select.trigger('change');
            }
        };

        // Caso 1: Carga remota (tiene data-ajax-url)
        if (ajaxUrl) {
            initializeSelect2({
                ajax: {
                    url: ajaxUrl,
                    type: method,
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.map(option => ({
                                id: option.value,
                                text: option.text
                            })),
                            pagination: {
                                more: data.length >= 10
                            }
                        };
                    },
                    cache: true
                },
                minimumResultsForSearch: 1
            });
        }
        // Caso 2: Opciones ya en el HTML
        else {
            initializeSelect2({
                minimumResultsForSearch: $select.find('option').length > 5 ? 1 : -1 // Mostrar buscador si hay más de 5 opciones
            });
        }
    });
});

});


</script>