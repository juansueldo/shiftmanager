import DataTable from 'datatables.net-bs5';
import 'datatables.net-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';

function addDatatable(tableSelector) {
    const dataTable = document.querySelector(tableSelector);
    const dataPath = dataTable.dataset.path;
    const lang = (dataTable.dataset.lang || 'en').toLowerCase();
    const dataWhere = dataTable.dataset.where || '';
    const ordercolumn = dataTable.dataset.ordercolumn || 1;
    const ordermethod = dataTable.dataset.ordermethod || 'desc';
    const thElements = dataTable.querySelectorAll('th');
    
    const columns = Array.from(thElements).map(th => ({
        data: th.outerText.trim()
    }));

    const columnDefs = Array.from(thElements).map((th, index) => {
        if (th.dataset.columnname == 'actions') index = -1;
        const columnDef = {
            targets: index,
            searchable: th.hasAttribute('data-searchable') ? th.dataset.searchable == '1' : true,
            orderable: th.hasAttribute('data-orderable') ? th.dataset.orderable == '1' : true,
            visible: th.hasAttribute('data-visible') ? th.dataset.visible == '1' : true,
            name: th.hasAttribute('data-columnname') ? th.dataset.columnname : '',
            render: function(data, type, full, meta) {
                return '<span class="text-body">' + full[th.dataset.columnname] + '</span>';
            }
        };

        return columnDef;
    });
    
    const order = [[ordercolumn, ordermethod]];
    const dataTableConfig = {
        ajax: {
            url: dataPath,
            type: 'POST',
            data: function (d) {
                d.start = d.start || 0;
                d.length = d.length || 10;
                d.search = d.search?.value || '';
                d.ordercolumn = d.columns[d.order[0].column].name || '';
                d.ordermethod = d.order[0].dir || ordermethod;
                d.where = dataWhere;
            },
            dataSrc: 'data',
            error: function(xhr, error, thrown) {
                console.log('AJAX Error:', error);
                console.log('Response:', xhr.responseText);
            }
        },
        serverSide: true,
        columns: columns,
        columnDefs: columnDefs,
        order: order,
        dom: '<"row me-2"' +
        '<"col-md-2"<"me-3"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
        language: getLanguage(lang),

        buttons: [],
    };

    $(dataTable).DataTable(dataTableConfig);
}

function getLanguage(langCode) {
    const languages = {
        es: {
            sLengthMenu: '_MENU_',
            search: '',
            searchPlaceholder: 'Buscar...',
            paginate: {
                first: 'Primero',
                last: 'Último',
                next: 'Siguiente',
                previous: 'Anterior'
            },
            info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
            infoEmpty: 'Mostrando 0 a 0 de 0 registros',
            infoFiltered: '(filtrado de _MAX_ registros totales)',
            zeroRecords: 'No se encontraron resultados',
            aria: {
                sortAscending: ': Activar para ordenar la columna ascendentemente',
                sortDescending: ': Activar para ordenar la columna descendentemente'
            }
        },
        en: {
            sLengthMenu: '_MENU_',
            search: '',
            searchPlaceholder: 'Search...',
            paginate: {
                first: 'First',
                last: 'Last',
                next: 'Next',
                previous: 'Previous'
            },
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: 'Showing 0 to 0 of 0 entries',
            infoFiltered: '(filtered from _MAX_ total entries)',
            zeroRecords: 'No matching records found',
            aria: {
                sortAscending: ': Activate to sort column ascending',
                sortDescending: ': Activate to sort column descending'
            }
        },
        pt: {
            sLengthMenu: '_MENU_',
            search: '',
            searchPlaceholder: 'Buscar...',
            paginate: {
                first: 'Primeiro',
                last: 'Último',
                next: 'Próximo',
                previous: 'Anterior'
            },
            info: 'Mostrando de _START_ até _END_ de _TOTAL_ registros',
            infoEmpty: 'Mostrando 0 até 0 de 0 registros',
            infoFiltered: '(filtrado de _MAX_ registros no total)',
            zeroRecords: 'Nenhum registro encontrado',
            aria: {
                sortAscending: ': ativar para ordenar a coluna em ordem crescente',
                sortDescending: ': ativar para ordenar a coluna em ordem decrescente'
            }
        },
        fr: {
            sLengthMenu: '_MENU_',
            search: '',
            searchPlaceholder: 'Rechercher...',
            paginate: {
                first: 'Premier',
                last: 'Dernier',
                next: 'Suivant',
                previous: 'Précédent'
            },
            info: 'Affichage de _START_ à _END_ sur _TOTAL_ entrées',
            infoEmpty: 'Affichage de 0 à 0 sur 0 entrées',
            infoFiltered: '(filtré à partir de _MAX_ entrées au total)',
            zeroRecords: 'Aucun enregistrement correspondant trouvé',
            aria: {
                sortAscending: ': activer pour trier la colonne par ordre croissant',
                sortDescending: ': activer pour trier la colonne par ordre décroissant'
            }
        },
        de: {
            sLengthMenu: '_MENU_',
            search: '',
            searchPlaceholder: 'Suchen...',
            paginate: {
                first: 'Erste',
                last: 'Letzte',
                next: 'Nächste',
                previous: 'Vorherige'
            },
            info: 'Zeige _START_ bis _END_ von _TOTAL_ Einträgen',
            infoEmpty: 'Zeige 0 bis 0 von 0 Einträgen',
            infoFiltered: '(gefiltert von _MAX_ gesamten Einträgen)',
            zeroRecords: 'Keine passenden Einträge gefunden',
            aria: {
                sortAscending: ': aktivieren, um Spalte aufsteigend zu sortieren',
                sortDescending: ': aktivieren, um Spalte absteigend zu sortieren'
            }
        }
    };

    return languages[langCode] || languages['en'];
}



window.addDatatable = addDatatable;