$(document).on('change', '.status', function(){
    let status = $(this).val();
    let volId = $(this).attr('data-volId');
    $.post('', {volId:volId, status:status});

    $(this).parent().attr('data-search', $(this).children("option:selected").text());
});
/*
$('.status').on('change', function() {
    $(this).attr('data-search', $(this).text());
});
*/
$('#volunteerTable').DataTable( {
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
        { responsivePriority: 1, targets: 0 },
        { responsivePriority: 2, targets: 1 },
        { responsivePriority: 3, targets: 3 },
        { responsivePriority: 4, targets: 4 },
        { responsivePriority: 5, targets: 5 },
        { responsivePriority: 6, targets: 6 },
        { responsivePriority: 5, targets: 14 }
    ],

    // Order table by join date descending
    order: [[ 14, "desc" ]]
} );