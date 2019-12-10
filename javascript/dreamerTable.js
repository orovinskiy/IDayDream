//uses jquery tables
let table = $('#dreamerTable').DataTable({
    responsive: {
        details: {
            display: $.fn.dataTable.Responsive.display.modal( {
                header: function ( row ) {
                    var data = row.data();
                    return 'Details for ' + data[0];
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
        { responsivePriority: 2, targets: 1 },
        // Email
        { responsivePriority: 3, targets: 2 },
        // Guardian Name
        { responsivePriority: 5, targets: 11 },
        // Guardian Email
        { responsivePriority: 6, targets: 12 },
        // Guardian Phone
        { responsivePriority: 7, targets: 13 },
        // Join Date
        { responsivePriority: 4, targets: 14 }
    ],
    // Order table by join date descending
    order: [[ 14, "desc" ]]
});

//captures the changed data and updates the database
$(document).on('change', '.activity', function(){
    let activity = $(this).val();
    let dreamerId = $(this).attr('data-id');

    $.post('activity.php', {id:dreamerId, activity:activity});

    updateStatusCell(this,dreamerId);
});


