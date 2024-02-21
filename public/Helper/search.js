function setupSearchFunction(searchInputId, dataTableId) {
    var searchInput = document.getElementById(searchInputId);
    var dataTable = document.getElementById(dataTableId);

    searchInput.addEventListener("input", function() {
        var searchValue = searchInput.value.toLowerCase();

        var rows = dataTable.querySelectorAll("tbody tr");

        rows.forEach(function(row) {
            var rowData = row.textContent.toLowerCase();
            row.style.display = rowData.includes(searchValue) ? "" : "none";
        });
    });
}

document.addEventListener("DOMContentLoaded", function() {
    setupSearchFunction("search-bar", "dataTable");

    setupSearchFunction("search-bar-2", "dataTable-2");
});

function toggleModal(id) {
    $('#id').val(id);
}
