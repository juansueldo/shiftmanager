import { GridStack } from "gridstack";
import 'gridstack/dist/gridstack.min.css';

function initGridStack($selector) {
    const grid = document.querySelector($selector);
    if (grid) {
        const gridInstance = GridStack.init({
            cellHeight: 100,
            verticalMargin: 10,
            resizable: { handles: 'e, se, s' },
            draggable: { handle: '.drag-handle' },
        }, grid);

        // Escuchar el evento `change` para detectar cambios en los widgets
        gridInstance.on('change', function (event, items) {
            // Enviar los cambios al servidor
            saveGridChanges(items);
        });
    }
}

// Función para enviar los cambios al servidor
function saveGridChanges(items) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Obtener el token CSRF

    // Preparar los datos para enviar
    const data = items.map(item => ({
        id: item.el.dataset.id, // ID del widget (debe estar en el atributo `data-id`)
        x: item.x,
        y: item.y,
        width: item.w,
        height: item.h
    }));

    // Enviar los datos al servidor usando fetch
    fetch('/widgets/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken // Incluir el token CSRF
        },
        body: JSON.stringify({ widgets: data })
    })
    .then(response => {
        if (response.ok) {
            console.log('Grid changes saved successfully!');
        } else {
            console.error('Failed to save grid changes.');
        }
    })
    .catch(error => {
        console.error('Error saving grid changes:', error);
    });
}

window.initGridStack = initGridStack;