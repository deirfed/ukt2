
function toggleModal(id) {
    $('#id').val(id);
}
document.addEventListener("DOMContentLoaded", function() {
    var searchInput = document.getElementById("search-bar");
    var dataTable = document.getElementById("dataTable");

    searchInput.addEventListener("input", function() {
        var searchValue = searchInput.value.toLowerCase();

        var rows = dataTable.querySelectorAll("tbody tr");

        rows.forEach(function(row) {
            var rowData = row.textContent.toLowerCase();
            if (rowData.includes(searchValue)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
});
