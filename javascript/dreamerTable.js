$(document).on('change', '.activity', function(){
    let activity = $(this).val();
    let dreamerId = $(this).attr('data-id');

    $.post('activity.php', {id:dreamerId, activity:activity});
});

$('#dreamerTable').DataTable({
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
        { responsivePriority: 1, targets: 0 },
        { responsivePriority: 2, targets: 1 },
        { responsivePriority: 3, targets: 2 },
        { responsivePriority: 5, targets: 10 },
        { responsivePriority: 6, targets: 11 },
        { responsivePriority: 7, targets: 12 },
        { responsivePriority: 4, targets: 13 }
    ],
    // Order table by join date descending
    order: [[ 13, "desc" ]]
});

//reloads the page
function reload() {window.location.reload()}
document.getElementById('reload').onclick = reload;