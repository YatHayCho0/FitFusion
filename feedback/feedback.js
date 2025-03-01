// Function to select emoji
function selectEmoji(emojiElement) {
    document.querySelectorAll('.emojis img').forEach(img => {
        img.classList.remove('selected');
    });
    emojiElement.classList.add('selected');
    document.getElementById('emojiInput').value = emojiElement.getAttribute('data-emoji'); // Set selected emoji value
}

// Function to toggle category selection
function toggleCategory(buttonElement) {
    buttonElement.classList.toggle('selected');
    updateCategoryInput();
}

// Function to update the category input based on selected categories
function updateCategoryInput() {
    const selectedCategories = Array.from(document.querySelectorAll('.category-buttons button.selected'))
        .map(button => button.getAttribute('data-category'));
    document.getElementById('categoryInput').value = selectedCategories.join(', ');
}

// Attach event listener to form submission
document.getElementById('feedbackForm').onsubmit = function(event) {
    const selectedEmoji = document.getElementById('emojiInput').value;
    const selectedCategories = document.getElementById('categoryInput').value;

    if (!selectedEmoji && !selectedCategories) {
        event.preventDefault(); // Block form submissions
        alert('Please select at least one emoji or category.');
    }
};

// Function to handle star rating selection
const stars = document.querySelectorAll('.star');

stars.forEach(star => {
    star.addEventListener('click', function() {
        const ratingValue = this.getAttribute('data-value'); // Save in data-value if click

        // Set selected stars
        stars.forEach(s => {
            s.classList.remove('selected');
        });
        for (let i = 0; i < ratingValue; i++) {
            stars[i].classList.add('selected');
        }

        // Set the hidden rating input value
        document.getElementById('ratingInput').value = ratingValue;
    });
});
