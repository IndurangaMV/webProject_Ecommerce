function addProduct() {
    var productName = document.getElementById("p_name").value;
    var category = document.getElementById("category").value;
    var qty = document.getElementById("qty").value;
    var price = document.getElementById("price").value;

    var formData = new FormData();
    formData.append("p_name", productName);
    formData.append("category", category);
    formData.append("qty", qty);
    formData.append("price", price);
    fetch("../controllers/addProduct.php", { method: "POST", body: formData }).then(response => response.text()).then(data => {
        alert(data);
        location.reload();
    }).catch(error => {
        alert("Error: " + error);
    });
}