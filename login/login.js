function validateEmpty() {
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    const emailValue = emailField.value.trim();
    const passwordValue = passwordField.value.trim();

    let isValid = true;

    // Check if email is empty
    if(emailValue === '') {
        document.getElementById('email-error').textContent = 'Email cannot be empty';
        isValid = false;
    } else {
        document.getElementById('email-error').textContent = '';
    }

    // Check if password is empty
    if(passwordValue === '') {
        document.getElementById('password-error').textContent = 'Password cannot be empty';
        isValid = false;
    } else {
        document.getElementById('password-error').textContent = '';
    }

    // Display wrong email or password message only when fields are valid
    if (isValid){
        document.getElementById('login-error').textContent = 'Wrong email or password';
    } else {
        document.getElementById('login-error').textContent = '';
    }

    return isValid;
}

// Toggle password visibility on clicking the eye icon
document.getElementById('toggle-password').addEventListener('click', function () {
    const passwordField = document.getElementById('password');
    const toggleIcon = document.getElementById('toggle-password');

    // Toggle password field type
    if (passwordField.type === 'password') {
        passwordField.type = 'text'; // Show password
        toggleIcon.textContent = '🙈'; // Change to "hide" icon
    } else {
        passwordField.type = 'password'; // Hide password
        toggleIcon.textContent = '👁️'; // Change to "show" icon
    }
});