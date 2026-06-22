document.addEventListener("DOMContentLoaded", function () {
    // Handling the view route switch
    document.querySelectorAll(".viewBtn").forEach(btn => {
        btn.addEventListener("click", function () {
            let id = this.getAttribute("data-id");
            window.location.href = "viewProduct.php?id=" + id;
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Handling the database delete route switch
    document.querySelectorAll(".deleteBtn").forEach(btn => {
        btn.addEventListener("click", function () {
            let id = this.getAttribute("data-id");
            if (confirm("Are you sure you want to delete product ID " + id + "?")) {
                window.location.href = "deleteProduct.php?id=" + id;
            }
        });
    });
});
