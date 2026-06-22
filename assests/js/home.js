function SearchProducts() {
    const minprice = document.getElementById("min_price").value;
    const maxprice = document.getElementById("max_price").value;
    const text = document.getElementById("searchText").value;
    const category = document.getElementById("category").value;
    const sort = document.querySelector('input[name="sort"]:checked').value;

    const formData = new FormData();
    formData.append("min_price", minprice);
    formData.append("max_price", maxprice);
    formData.append("text", text);
    formData.append("category", category);
    formData.append("sort", sort);

    fetch("../controllers/search.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            const grid = document.getElementById("product-grid");
            if (grid) {
                grid.innerHTML = data;
            }
        })
        .catch(() => {
            const grid = document.getElementById("product-grid");
            if (grid) {
                grid.innerHTML = '<div class="no-results">Search failed. Please try again.</div>';
            }
        });
}

function clearFilters() {
    document.getElementById("searchText").value = "";
    document.getElementById("min_price").value = "";
    document.getElementById("max_price").value = "";
    document.getElementById("category").value = "";
    document.getElementById("lh").checked = true;
    SearchProducts();
}
