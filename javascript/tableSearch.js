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