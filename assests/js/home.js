function SearchProducts() {
    let minprice = document.getElementsByName("min_price")[0].value;
    let maxprice = document.getElementsByName("max_price")[0].value;
    let text = document.getElementsByName("text")[0].value;
    let category = document.getElementsByName("category")[0].value;
    let sort = document.querySelector('input[name="sort"]:checked').value;

    var formData = new FormData();
    formData.append("min_price", minprice);
    formData.append("max_price", maxprice);
    formData.append("text", text);
    formData.append("category", category);
    formData.append("sort", sort);
    fetch("../controllers/search.php", {
        method: "POST",
        headers: {
        },
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            document.getElementById("product-container").innerHTML = data;
        });
}
