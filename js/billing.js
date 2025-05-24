$(document).ready(function () {
    // Fetch billing details when the page loads
    $.ajax({
        url: "./includes/fetch_billing_details.php",
        method: "GET",
        dataType: "json",
        success: function (data) {
            if (data.error) {
                console.error("Error:", data.error);
                Swal.fire("Error", data.error, "error");
            } else {
                console.log("Fetched Data:", data); // Debugging: Check received data

                // Bind data to fields
                $("#customer_first_name").val(data.first_name || "");
                $("#customer_last_name").val(data.last_name || "");
                $("#email_address").val(data.email || "");
                $("#mobile_number").val(data.mobile || "");
                $("#customer_address").val(data.address || "");
                // $("#customer_city").val(data.city || "");
                $("#customer_zip").val(data.zipcode || "");
                $("#customer_state").val(data.state || "");
                $("#customer_country").val(data.country || "");
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            Swal.fire("Error", "Could not fetch billing details", "error");
        },
    });
});
