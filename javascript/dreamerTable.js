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

/**
 * Filters only status column if word matches active, pending, or inactive. These words must
 * match exactly for appropriate filter
 */
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

/**
 * Updates the state of the cell for status in through the API and html table
 * @param statusSelect select element to update
 * @param dreamId the id of the dreamer this cell belongs to
 */
function updateStatusCell(statusSelect, dreamId) {

    let thisRowNum = $(statusSelect).data("row-index");
    let selectedOption = $(statusSelect).children("option:selected").text();

    // Must update selected option by recreating select since datatable reads from html instead of DOM
    let newSelect = makeNewSelect(selectedOption, dreamId, thisRowNum);

    // Update <td> on table for filter and sort
    let tdCell = $("[data-dt-row='" + thisRowNum + "'][data-dt-column='1']");
    tdCell.attr("data-search", selectedOption);
    tdCell.attr("data-sort", selectedOption);

    // Update datatable through API
    let dataCell = table.cell({row: thisRowNum, column: 1});
    dataCell.invalidate();
    dataCell.data(newSelect);
}

function makeNewSelect(selectedOption, dreamId, currRowNum) {
    let newSelect = '';

    switch (selectedOption) {
        case 'Active':
            newSelect = "<select class='activity' data-id='" + dreamId + "' data-row-index='" + currRowNum + "'>"
                +  "<option value='1' selected=''>Active</option>"
                +  "<option value='0'>Pending</option>"
                +  "<option value='-1'>Inactive</option>"
                + "</select>";
            break;
        case 'Pending':
            newSelect = "<select class='activity' data-id='" + dreamId + "' data-row-index='" + currRowNum + "'>"
                +  "<option value='1'>Active</option>"
                +  "<option value='0' selected=''>Pending</option>"
                +  "<option value='-1'>Inactive</option>"
                + "</select>";
            break;
        case 'Inactive':
            newSelect = "<select class='activity' data-id='" + dreamId + "' data-row-index='" + currRowNum + "'>"
                +  "<option value='1'>Active</option>"
                +  "<option value='0'>Pending</option>"
                +  "<option value='-1' selected=''>Inactive</option>"
                + "</select>";
    }
    return newSelect;
}
