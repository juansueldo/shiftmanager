const base_url = 'http://127.0.0.1:8000';

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function updatePart(url, formData, container, method = 'POST', callback = null) {
    
    const theme = getCurrentTheme();
    $.ajax({
        url: url,
        _token: $('meta[name="csrf-token"]').attr('content'),
        type: method,
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            blockPage();
        }
    }).done(function(response) {
        if (container) {
            if (Array.isArray(container)) { // Verifica si container es un array
                container.forEach(selector => {
                    let field = selector.replace('#', '');
            
                    // Asigna el valor correspondiente del response al input
                    if (response[field] !== undefined) {
                        $(selector).val(response[field]);
                    }
                });
            }
             else{
                $(container).html(response);
            }
            
        } else {
           Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The form has been submitted successfully.',
                customClass: { confirmButton: "btn btn-primary" },
                buttonsStyling: false,
                theme: theme
            });
        }
        if (typeof callback === 'function') {
            callback(response);
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: errorThrown || 'An unknown error occurred.',
            customClass: { confirmButton: "btn btn-primary" },
            buttonsStyling: false,
            theme: theme
        });
    }).always(function() {
        $.unblockUI();
    });
}

$(document).ready(function() {
    $(document).on('click', 'a[data-ajax-source], button[data-ajax-source], li[data-ajax-source]', function(e) {
    e.preventDefault();
    var url = base_url + $(this).data('ajax-source');
    var container = $(this).data('ajax-container');
    var callbackName = $(this).data('ajax-then');
    var callback = window[callbackName];

    updatePart(url, null, container, 'GET', callback);
});
    $(document).on('submit', 'form[data-ajax-source]', function(e) {
        e.preventDefault();
        var form = $(this);
        if($(form).data('ajax-validated') === true){
            var url = base_url + $(this).data('ajax-source');
            var method = $(this).data('ajax-method');
            var container = $(this).data('ajax-container');
            var formData = new FormData(this);
            var callbackName = $(this).data('ajax-then');
            var callback = window[callbackName];
    
            updatePart(url, formData, container, 'POST', callback);
        }
    });
});

function blockPage() {
    $.blockUI({
        message: '<div class="spinner-border text-white" role="status"></div>',
        css: { backgroundColor: 'transparent', border: '0' },
        overlayCSS: { opacity: 0.5 }
    });
}

function replaceValue(element, response) {
    console.log(response)
    $(element).val(response);
}

$(document).on('click', function (event) {
    if (!$('#offcanvasEnd').is(event.target) && $('#offcanvasEnd').has(event.target).length === 0) {
        console.log('Clic fuera del canvas, pero no cerramos');
        // Aquí evitas que el canvas se cierre si tienes algún modal o menú
    }
});

$('#offcanvasEnd').on('click', function (event) {
    event.stopPropagation();
});


function afterSaveCallback(response) {
    var offcanvasElement = document.getElementById('offcanvasEnd');
    var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
    if (offcanvas) {
        offcanvas.hide();
    }
}

function getCurrentTheme() {
    return document.documentElement.getAttribute('data-bs-theme') || 'light';
}

function uploadFile($uploadInput, $uploadedFile, $fileBase64Input) {
    $uploadInput.on('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $uploadedFile.attr('src', e.target.result);
                $fileBase64Input.val(e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
}

function resetFile($resetButton,$uploadedFile, $fileBase64Input, $originalFile) {
    $resetButton.on('click', function () {
        $uploadedFile.attr('src', $originalFile);
        $fileBase64Input.val('');
    });
}

function updateNavbar(){
    $.ajax({
        url: base_url + '/navbar',
        type: 'GET',
        dataType: 'html',
        success: function(response) {
            $("#navbar-container").html(response);
        }
    });
}

window.updatePart = updatePart;
window.afterSaveCallback = afterSaveCallback;
window.getCurrentTheme = getCurrentTheme;
window.uploadFile = uploadFile;
window.resetFile = resetFile;
window.updateNavbar = updateNavbar;