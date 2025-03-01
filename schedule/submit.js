// Function to validate the form fields
function validateForm(event) {
    const workoutName = document.getElementById('workout-name').value.trim();
    const workoutType = document.getElementById('workout-type').value.trim();
    const workoutDate = document.getElementById('workout-date').value.trim();
    const workoutLocation = document.getElementById('workout-location').value.trim();

    if (!workoutName || !workoutType || !workoutDate || !workoutLocation) {
        alert('Please fill in all required fields.');
        event.preventDefault(); // Prevent form submission
    } else {
        alert('Workout added successfully!');
    }
}

// Attach the validateForm function to the form's submit event
window.onload = function() {
    const form = document.getElementById('workoutForm');
    if (form) {
        form.onsubmit = validateForm;
    }
};