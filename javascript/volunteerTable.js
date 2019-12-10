
// data table initialization and options
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

/**
 * Handler to save status of volunteer and update select element and table data
 */
$(document).on('change', '.status', function(){
    let status = $(this).val();
    let volId = $(this).data('vol-id');

    // Update status for volunteer in db
    $.post('updateVolunteerStatus.php', {volId:volId, status:status});

    // To reflect changes on table and modal
    updateStatusCell(this, volId);
});