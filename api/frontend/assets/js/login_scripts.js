// Login Page

// Define a function to check for token in localStorage
function checkToken() {
    // Check if data with key name "token" exists in localStorage
    if (localStorage.getItem("token")) {
        // Data with key name "token" exists
        // Log the token to the console
        console.log("Token:", localStorage.getItem("token"));
        window.location.href = 'index.html';
    } else {
        // Data with key name "token" does not exist
        // Log "fail" to the console
        console.log("Fail");
    }
}

// Add an event listener for DOMContentLoaded event
document.addEventListener("DOMContentLoaded", function() {
    // Call the checkToken function before the page loads
    checkToken();
});


const loginForm = document.getElementById('loginForm');

loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(loginForm);
    const email = formData.get('email');
    const password = formData.get('password');

    try {
        const response = await fetch('http://localhost/php-api-practive/api/index.php/welcome/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });

        const data = await response.json();

        if (response.ok) {
            if(data.status == 'success'){
                localStorage.setItem('token', data.token);
                window.location.href = 'index.html';
            } else if (data.status == 'error'){
                displayErrorMessage(data.message)
                console.log(data.message);
            } else {
                console.log('Unknown error occur!');
            }
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
    }
});


function displayErrorMessage(message) {
    const errorMessageDiv = document.getElementById('errorMessage');
    const errorMessageText = document.getElementById('errorMessageText');
    
    // Set error message text
    errorMessageText.textContent = message;
    
    // Display error message div
    errorMessageDiv.style.display = 'block';
    
    // Hide error message after 10 seconds
    setTimeout(function() {
        errorMessageDiv.style.display = 'none';
    }, 10000); // 10 seconds
}

function closeErrorMessage() {
    const errorMessageDiv = document.getElementById('errorMessage');
    errorMessageDiv.style.display = 'none';
}