<div class="offcanvas-header" >
    <h5 id="offcanvasEndLabel" class="offcanvas-title">{{ $formdata['title'] }}</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<form  class="form-floating offcanvas-body" 
    id="{{ $formdata['id'] }}"
    data-ajax-validated="true"
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
                            data-{{ $dataKey }}="{{ $dataValue }}"
                        @endforeach
                    @endif
                    type="{{ $input['type'] }}" id="{{ $input['name'] }}" name="{{ $input['name'] }}" class="form-control mb-2" placeholder="{{ $input['placeholder'] ?? '' }}" value="{{ $input['value'] }}" data-ajax-checker="{{ $input['checker'] ?? '' }}" data-ajax-minlength="{{ $input['minlength'] ?? ''}}" data-ajax-container="{{ $input['container'] ?? ''}}" data-ajax-method="{{ $input['method'] ?? ''}}"/>
                @endif
                @if (isset($input['label']))
                    <label for="{{ $input['name'] }}">{{ $input['label'] }}</label>
                @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="offcanvas-body my-auto mx-0 flex-grow-0">
        <button type="submit" class="btn btn-primary mb-2 d-grid w-100">Continue</button>
        <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">Cancel</button>
    </div>
</form>



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
                formData.append('identifier', value);
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
    $('.form-floating select[data-ajax-url]').each(function () {
    let $select = $(this);
    let ajaxUrl = $select.data('ajax-url');
    let method = $select.data('ajax-method') || 'GET';

    // Si tiene el atributo `multi`, se convierte en multiple
    if ($select.attr('multi') !== undefined) {
        $select.attr('multiple', 'multiple');
    }

    const theme = $select.data('theme') || 'default';

    const initSelect2 = function () {
        $select.select2({
            minimumResultsForSearch: Infinity,
            width: '100%',
            placeholder: "Seleccione una opción",
            allowClear: true,
            theme: theme,
            dropdownParent: $('.offcanvas-body')
        });
    };

    const loadOptions = function () {
        $.ajax({
            url: ajaxUrl,
            method: method,
            success: function (response) {
                // Destruir select2 si ya está inicializado
                if ($select.hasClass('select2-hidden-accessible')) {
                    $select.select2('destroy');
                }

                $select.empty();


                if (response && Array.isArray(response)) {
                    response.forEach(option => {
                        $select.append(
                            $('<option>', {
                                value: option.value,
                                text: option.text
                            })
                        );
                    });
                }

                // Iniciar select2 luego de cargar opciones
                initSelect2();
            },
            error: function (xhr, status, error) {
                console.error('Error al cargar las opciones:', error);
            }
        });
    };

    loadOptions();
});


});

</script>