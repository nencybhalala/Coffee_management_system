function validate_form() {
    let isValid = true;

    function showError(id, message) {
        console.log("Error in field:", id, "Message:", message); // Debugging
        document.getElementById(id).innerText = message;
        isValid = false;
    }

    function clearError(id) {
        document.getElementById(id).innerText = "";
    }

    let firstName = document.getElementById("customer_first_name").value.trim();
    let lastName = document.getElementById("customer_last_name").value.trim();
    let email = document.getElementById("email_address").value.trim();
    let mobile = document.getElementById("mobile_number").value.trim();
    let address = document.getElementById("customer_address").value.trim();
    let city = document.getElementById("customer_city").value.trim();
    let zip = document.getElementById("customer_zip").value.trim();
    let state = document.getElementById("customer_state").value.trim();
    let country = document.getElementById("customer_country").value.trim();
    let agreeCheckbox = document.getElementById("agree_checkbox").checked;

    let nameRegex = /^[A-Za-z]+$/;
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let zipRegex = /^\d{5,6}$/; // Allows 5-6 digit zip codes
    let mobileRegex = /^\d{10}$/; // Ensures exactly 10 digits

    clearError("error_customer_first_name");
    clearError("error_customer_last_name");
    clearError("error_email_address");
    clearError("error_mobile_number");
    clearError("error_customer_address");
    clearError("error_customer_city");
    clearError("error_customer_zip");
    clearError("error_customer_state");
    clearError("error_customer_country");
    clearError("error_agree_checkbox");

    if (!firstName.match(nameRegex)) showError("error_customer_first_name", "Invalid first name.");
    if (!lastName.match(nameRegex)) showError("error_customer_last_name", "Invalid last name.");
    if (!email.match(emailRegex)) showError("error_email_address", "Invalid email.");
    if (!mobile.match(mobileRegex)) showError("error_mobile_number", "Must be 10 digits.");
    if (address === "") showError("error_customer_address", "Address required.");
    if (city === "") showError("error_customer_city", "City required.");
    if (!zip.match(zipRegex)) showError("error_customer_zip", "Zip must be 5-6 digits.");
    if (state === "") showError("error_customer_state", "State required.");
    if (country === "") showError("error_customer_country", "Country required.");
    if (!agreeCheckbox) showError("error_agree_checkbox", "You must agree to the terms.");

    console.log("Validation completed. Result:", isValid);
    return isValid;
}
