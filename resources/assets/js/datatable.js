import DataTable from 'datatables.net-bs5';
import 'datatables.net-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';

function addDatatable(tableSelector) {
    const dataTable = document.querySelector(tableSelector);
    const dataPath = dataTable.dataset.path;
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
        language: {
            sLengthMenu: '_MENU_',
            search: '',
            searchPlaceholder: 'Search..'
        },
        buttons: [],
    };

    $(dataTable).DataTable(dataTableConfig);
}

window.addDatatable = addDatatable;