$(document).on('change', '.status', function(){
    let status = $(this).val();
    let volId = $(this).attr('data-volId');
    $.post('', {volId:volId, status:status});

    let thisCell = $(this).parent();
    let thisRow = thisCell.parent();
    let selectedOptionText  = $(this).children("option:selected").text();

    thisCell.attr('data-search', selectedOptionText);

    table.row(thisRow).invalidate().draw();
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