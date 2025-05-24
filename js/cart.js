$(document).ready(function () {
    $(".plus-btn, .minus-btn").on("click", function () {
        let button = $(this);
        let product_id = button.data("id");
        let action = button.hasClass("plus-btn") ? "increase" : "decrease";
        let quantityElement = button.siblings(".quantity");
        let totalPriceElement = button.closest("tr").find("td:nth-child(6) b");
        let cartTotalElement = $("td[colspan='5'] + td b");

        $.ajax({
            url: "update_cart.php",
            type: "POST",
            data: { product_id: product_id, action: action },
            dataType: "json",
            success: function (response) {
                quantityElement.text(response.quantity);
                totalPriceElement.text("₹ " + response.total_price);
                cartTotalElement.text("₹ " + response.cart_total);
            }
        });
    });
});
