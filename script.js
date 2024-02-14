// Function to display error messages
const showError = (field, errorText) => {
    field.classList.add("error");
    const errorElement = document.createElement("small");
    errorElement.classList.add("error-text");
    errorElement.innerText = errorText;
    field.closest(".form-group").appendChild(errorElement);
};

// Function to display success messages
const showSuccess = (field, successText) => {
    field.classList.add("success");
    const successElement = document.createElement("small");
    successElement.classList.add("success-text");
    successElement.innerText = successText;
    field.closest(".form-group").appendChild(successElement);
};

// Function to handle form submission
const handleFormData = (e) => {
    e.preventDefault();

    // Retrieving input elements
    const ipInput = document.getElementById("ip");

    // Getting trimmed values from input fields
    const ip = ipInput.value.trim();

    // Regular expression pattern for IP address validation
    const ipPattern = /^(\d{1,3}\.){3}\d{1,3}$/;

    // Clearing previous error and success messages
    document.querySelectorAll(".form-group .error, .form-group .success").forEach(field => field.classList.remove("error", "success"));
    document.querySelectorAll(".error-text, .success-text").forEach(message => message.remove());

    // Performing validation checks
    if (!ipPattern.test(ip)) {
        showError(ipInput, "Enter a valid IP address");
    }

    // Checking for any remaining errors before sending the request
    const errorInputs = document.querySelectorAll(".form-group .error");
    if (errorInputs.length > 0) return;

    // Create a FormData object to send the data
    const formData = new FormData();
    formData.append("ip", ip);

    // Send an AJAX request to the PHP script
    fetch("https://hayzeltech.com/ipchecker2/ipcheckerforgithub.php", {
        method: "POST",
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        data = data.trim();
        if (data === "Duplicate IP") {
            showError(ipInput, "Duplicate IP");
        } else if (data == "IP Address saved successfully!") {
            showSuccess(ipInput, "IP Address saved successfully!");
        } else {
            showError(ipInput, "Enter Valid IP Address");
        }
    })
    .catch(error => {
        console.error("An error occurred:", error);
    });
};

// Handling form submission event
const form = document.querySelector("form");
form.addEventListener("submit", handleFormData);

