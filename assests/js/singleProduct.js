function cart(){
    alert("Add to Cart does not available for this moment.");
}


let productId = 0;
let maxQty = 0;

function openBuyModal(pid, qty)
{
    productId = pid;
    maxQty = qty;

    document.getElementById("availableQty").innerHTML = qty;
    document.getElementById("buyQty").value = "";

    document.getElementById("buyModal").style.display = "block";
}

function closeBuyModal()
{
    document.getElementById("buyModal").style.display = "none";
}

function proceedCheckout()
{
    let qty = parseInt(document.getElementById("buyQty").value);

    if(isNaN(qty) || qty <= 0)
    {
        alert("Enter a valid quantity.");
        return;
    }

    if(qty > maxQty)
    {
        alert("Only " + maxQty + " items are available.");
        return;
    }

     // Create form
    let form = document.createElement("form");
    form.method = "POST";
    form.action = "checkout.php";

    // Product ID field
    let pidInput = document.createElement("input");
    pidInput.type = "hidden";
    pidInput.name = "pid";
    pidInput.value = productId;
    form.appendChild(pidInput);

    // Quantity field
    let qtyInput = document.createElement("input");
    qtyInput.type = "hidden";
    qtyInput.name = "qty";
    qtyInput.value = qty;
    form.appendChild(qtyInput);

    // Add form to page and submit
    document.body.appendChild(form);
    form.submit();
}

