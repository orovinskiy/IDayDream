$(document).on('change', '.status', function(){
    let status = $(this).val();
    let volId = $(this).data('vol-id');
    $.post('', {volId:volId, status:status});

    let selectedOption = $(this).children("option:selected").text();

    let rowIndex = $(this).data("row-index");

    // DataTable reads selected attribute from html instead of DOM so must re-create select
    // with the selected option
    let newSelect = '';
    switch (selectedOption) {
        case 'Active':
            newSelect = "<select class='status' data-vol-id='" + volId + "' data-row-index='" + rowIndex + "'>"
                        +  "<option value='1' selected=''>Active</option>"
                        +  "<option value='0'>Pending</option>"
                        +  "<option value='-1'>Inactive</option>"
                      + "</select>";
            break;
        case 'Pending':
            newSelect = "<select class='status' data-vol-id='" + volId + "' data-row-index='" + rowIndex + "'>"
                        +  "<option value='1'>Active</option>"
                        +  "<option value='0' selected=''>Pending</option>"
                        +  "<option value='-1'>Inactive</option>"
                      + "</select>";
            break;
        case 'Inactive':
            newSelect = "<select class='status' data-vol-id='" + volId + "' data-row-index='" + rowIndex + "'>"
                       +  "<option value='1'>Active</option>"
                       +  "<option value='0'>Pending</option>"
                       +  "<option value='-1' selected=''>Inactive</option>"
                      + "</select>";

    }

    let thisCell = table.cell({row: rowIndex, column: 1});

    $("[data-dt-row='" + rowIndex + "'][data-dt-column='1']").attr("data-search", selectedOption);

    thisCell.invalidate();

    thisCell.data(newSelect);
});

$(document).on('input', 'input[type="search"]', function() {
    let filterText = $(this).val().toLowerCase();

    switch (filterText) {
        case 'active':
        case 'pending':
        case 'inactive':
            table.column(1).search('^' + filterText + '$', true, false).draw();
            break;
        default:
            table.column(1).search('');
            table.search(filterText).draw();
    }
});



let table = $('#volunteerTable').DataTable( {
    responsive: {
        details: {
            display: $.fn.dataTable.Responsive.display.modal( {
                header: function ( row ) {
                    var data = row.data();
                    return 'Details for '+ data[0];
                }
            } ),
            renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                tableClass: 'table'
            } )
        }
    },

    // Priority of which columns are shown in the table
    columnDefs: [
        // Name
        { responsivePriority: 1, targets: 0 },
        // Status
        { responsivePriority: 4, targets: 1 },
        // Email
        { responsivePriority: 2, targets: 2 },
        // Phone
        { responsivePriority: 3, targets: 4 },
        // Address
        { responsivePriority: 7, targets: 5 },
        // Weekends
        { responsivePriority: 6, targets: 6 },
        // SummerCamp
        { responsivePriority: 8, targets: 7 },
        // Join Date
        { responsivePriority: 5, targets: 15 }
    ],

    // Order table by join date descending
    order: [[ 15, "desc" ]]
} );