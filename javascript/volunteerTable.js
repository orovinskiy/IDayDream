
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
 * @param volId the id of the volunteer this cell belongs to
 */
function updateStatusCell(statusSelect, volId) {

    let thisRowNum = $(statusSelect).data("row-index");
    let selectedOption = $(statusSelect).children("option:selected").text();

    // Must update selected option by recreating select since datatable reads from html instead of DOM
    let newSelect = makeNewSelect(selectedOption, volId, thisRowNum);

    // Update <td> on table for filter and sort
    let tdCell = $("[data-dt-row='" + thisRowNum + "'][data-dt-column='1']");
    tdCell.attr("data-search", selectedOption);
    tdCell.attr("data-sort", selectedOption);

    // Update datatable through API
    let dataCell = table.cell({row: thisRowNum, column: 1});
    dataCell.invalidate();
    dataCell.data(newSelect);
}


/**
 * Creates a select element with options for a status. Parameter option will be selected
 * @param selectedOption option to select as default
 * @param volId id of the volunteer for the status
 * @param currRowNum Row this select is on datatable
 * @returns {string} select element with options for status
 */
function makeNewSelect(selectedOption, volId, currRowNum) {
    let newSelect = '';

    switch (selectedOption) {
        case 'Active':
            newSelect = "<select class='status' data-vol-id='" + volId + "' data-row-index='" + currRowNum + "'>"
                +  "<option value='1' selected=''>Active</option>"
                +  "<option value='0'>Pending</option>"
                +  "<option value='-1'>Inactive</option>"
                + "</select>";
            break;
        case 'Pending':
            newSelect = "<select class='status' data-vol-id='" + volId + "' data-row-index='" + currRowNum + "'>"
                +  "<option value='1'>Active</option>"
                +  "<option value='0' selected=''>Pending</option>"
                +  "<option value='-1'>Inactive</option>"
                + "</select>";
            break;
        case 'Inactive':
            newSelect = "<select class='status' data-vol-id='" + volId + "' data-row-index='" + currRowNum + "'>"
                +  "<option value='1'>Active</option>"
                +  "<option value='0'>Pending</option>"
                +  "<option value='-1' selected=''>Inactive</option>"
                + "</select>";
    }
    return newSelect;
}