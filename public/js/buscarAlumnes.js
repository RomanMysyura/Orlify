document.getElementById('searchInput').addEventListener('input', function() {
    var searchQuery = this.value.toLowerCase();
    var rows = document.querySelectorAll('.table tbody tr');

    rows.forEach(function(row) {
        var textContent = row.textContent.toLowerCase();
        if (textContent.includes(searchQuery)) {
            row.classList.remove('hidden');
        } else {
            row.classList.add('hidden');
        }
    });
});