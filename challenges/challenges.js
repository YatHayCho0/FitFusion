// Get the sidebar element and buttons
const sidebar = document.getElementById("completedChallengesSidebar");
const openButton = document.getElementById("trophy-icon");
const closeButton = document.getElementById("closeSidebar");

// Open sidebar when the trophy icon is clicked
openButton.addEventListener("click", function() {
    console.log("Trophy icon clicked!"); // Log click event to console
    sidebar.style.width = "350px";  // Adjust width as needed
    sidebar.style.display = "block";  // Ensure sidebar is displayed
});

// Close sidebar when the close button is clicked
closeButton.addEventListener("click", function() {
    sidebar.style.width = "0";  // Collapse the sidebar
    setTimeout(() => {
        sidebar.style.display = "none";  // Hide after transition is complete
    }, 500); // 500ms matches the CSS transition duration
});

// Get modal elements
const modal = document.getElementById('leaveModal'); // Modal window for leaving challenge
const closeModal = document.getElementById('closeModal'); // Close button in modal
const progressCircle = document.getElementById('progressCircle'); // Progress bar inside modal
const challengeName = document.getElementById('challengeName'); // Name of the challenge
const challengeDescription = document.getElementById('challengeDescription'); // Challenge description
const challengeDifficulty = document.getElementById('challengeDifficulty'); // Difficulty level of the challenge
const challengeStartDate = document.getElementById('challengeStartDate'); // Start date of the challenge
const challengeEndDate = document.getElementById('challengeEndDate'); // End date of the challenge
const modalChallengeId = document.getElementById('modalChallengeId'); // Hidden field to store challenge ID

// Handle the leave challenge button click event for all leave buttons
document.querySelectorAll('.leave').forEach(button => {
    button.addEventListener('click', (event) => {
        const challengeCard = event.target.closest('.challenge'); // Get the clicked challenge card
        
        // Get progress, name, description, start and end date from the clicked card
        const progress = challengeCard.querySelector('.progress-circle').style.width; // Get progress from style
        const name = challengeCard.querySelector('p').textContent; // Get challenge name
        const description = challengeCard.dataset.description; // Use data-attribute to get description
        const startDate = challengeCard.dataset.startDate; // Use data-attribute to get start date
        const endDate = challengeCard.dataset.endDate; // Use data-attribute to get end date
        const difficulty = challengeCard.classList[1].split('-')[1]; // Get difficulty from class name (class format: 'challenge-difficulty')
        const challengeId = challengeCard.dataset.challengeId; // Get challenge ID from data-attribute

        // Fill modal with challenge information
        progressCircle.style.width = progress; // Set the width of the progress bar in the modal
        challengeName.textContent = `Challenge Name: ${name}`; // Set challenge name in modal
        challengeDescription.textContent = `Description: ${description}`; // Set challenge description in modal
        challengeDifficulty.textContent = `Difficulty: ${difficulty.charAt(0).toUpperCase() + difficulty.slice(1)}`; // Capitalize first letter of difficulty
        challengeStartDate.textContent = `Start Date: ${startDate}`; // Set start date in modal
        challengeEndDate.textContent = `End Date: ${endDate}`; // Set end date in modal
        modalChallengeId.value = challengeId; // Set hidden challenge ID field in modal

        // Display the modal
        modal.style.display = 'block';
    });
});

// Get difficulty filter dropdown and available challenge cards
const difficultyFilter = document.getElementById('difficulty'); // Dropdown to filter challenges by difficulty
const challenges = document.querySelectorAll('.available-challenges .challenge'); // All available challenge cards

// Listen for changes to the difficulty dropdown filter
difficultyFilter.addEventListener('change', function() {
    const selectedDifficulty = difficultyFilter.value; // Get the selected difficulty

    // Loop through all challenges and display or hide them based on selected difficulty
    challenges.forEach(challenge => {
        if (selectedDifficulty === 'all') {
            challenge.style.display = 'block';  // Show all challenges if 'all' is selected
        } else if (challenge.classList.contains(`challenge-${selectedDifficulty}`)) {
            challenge.style.display = 'block';  // Show only challenges that match the selected difficulty
        } else {
            challenge.style.display = 'none';   // Hide challenges that do not match the selected difficulty
        }
    });
});

// Close modal when the close button is clicked
closeModal.addEventListener('click', () => {
    modal.style.display = 'none'; // Hide the modal
});

// Close modal if clicking outside of the modal content
window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = 'none'; // Hide the modal if the click is outside the modal
    }
}