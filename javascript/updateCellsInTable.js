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