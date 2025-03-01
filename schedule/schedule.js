// Use current date for initialization
let today = new Date();
let currentMonth = today.getMonth(); // Get current month (0 = January)
let currentYear = today.getFullYear(); // Get current year

let categoriesData = []; // Store fetched categories for reuse

const monthNames = ["January", "February", "March", "April", "May", "June", 
                    "July", "August", "September", "October", "November", "December"];
const daysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

// Leap year check for February
function isLeapYear(year) {
    return (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);
}

function updateCalendar() {
    const month = currentMonth;
    const year = currentYear;
    const monthDays = (month === 1 && isLeapYear(year)) ? 29 : daysInMonth[month];
    const plannerBody = document.getElementById('planner-body');
    let rows = '<tr>';
    let dayOfWeek = new Date(year, month, 1).getDay(); // Get the first day of the month
    dayOfWeek = (dayOfWeek === 0) ? 6 : dayOfWeek - 1;

    // Add empty cells for days before the start of the month
    for (let i = 0; i < dayOfWeek; i++) {
        rows += `<td></td>`;
    }

    // Fill in days for the current month
    for (let day = 1; day <= monthDays; day++) {
        rows += 
            `<td>
                ${day}<br> <!-- Display the day of the month -->
                <div class="activity-box">
                    <!-- Placeholder for activities, fetched dynamically -->
                    <span>No Activities</span>
                </div>
            </td>`;

        // After each Sunday (7th day), close the row and start a new one
        if ((day + dayOfWeek) % 7 === 0) {
            rows += '</tr><tr>';
        }
    }

    // Close the last row
    rows += '</tr>';
    plannerBody.innerHTML = rows;

    // Update the calendar header with the correct month and year
    document.getElementById('month-year').textContent = `${monthNames[month]} ${year}`;
}

function nextMonth() {
    if (currentMonth === 11) {
        currentMonth = 0;
        currentYear++;
    } else {
        currentMonth++;
    }
    updateCalendar();
    fetchPlannerData();
}

function prevMonth() {
    if (currentMonth === 0) {
        currentMonth = 11;
        currentYear--;
    } else {
        currentMonth--;
    }
    updateCalendar();
    fetchPlannerData();
}

// Redirect to add workout page when button is clicked
function goToAddWorkout() {
    window.location.href = 'submit_workout.php';
}

// Function to fetch and render workout planner data
function fetchPlannerData() {
    fetch('fetch_planner_data.php')
        .then(response => response.json())
        .then(data => {
            const plannerBody = document.getElementById('planner-body');
            let rows = '<tr>';
            let dayOfWeek = new Date(currentYear, currentMonth, 1).getDay();
            let daysInCurrentMonth = (currentMonth === 1 && isLeapYear(currentYear)) ? 29 : daysInMonth[currentMonth];

            dayOfWeek = (dayOfWeek === 0) ? 6 : dayOfWeek - 1;

            // Add empty cells for days before the start of the month
            for (let i = 0; i < dayOfWeek; i++) {
                rows += `<td></td>`;
            }

            // Fill in days for the current month
            for (let day = 1; day <= daysInCurrentMonth; day++) {
                let dayWorkouts = data.filter(d => {
                    let workoutDate = new Date(d.date);
                    return workoutDate.getDate() === day && workoutDate.getMonth() === currentMonth && workoutDate.getFullYear() === currentYear;
                });

                rows += `<td>${day}<br><div class="activity-box">`;

                if (dayWorkouts.length > 0) {
                    dayWorkouts.forEach((foundDay, index) => {
                        rows += `
                            <div class="activity-item" style="margin-bottom: 20px;"> <!-- 添加间距 -->
                                <span class="activity ${foundDay.activity_class}">${foundDay.activity_name}</span><br>
                                <span class="category-tag">${foundDay.category}</span><br>
                                <span class="location-tag">${foundDay.location}</span>
                                <span class="notes-tag">${foundDay.notes}</span>
                            </div>
                        `;
                    });
                } else {
                    rows += `<span>No Activities</span>`;
                }

                rows += `</div></td>`;

                if ((day + dayOfWeek) % 7 === 0) {
                    rows += '</tr><tr>';
                }
            }

            rows += '</tr>';
            plannerBody.innerHTML = rows;
        });
}



// Fetch workout categories and display them
function fetchCategories() {
    fetch('fetch_categories.php')
        .then(response => response.json())
        .then(data => {
            categoriesData = data; // Store the fetched categories
            displayCategories('all');
            setActiveTab('all');
        });
}

// Function to display categories based on the tab
function displayCategories(filter) {
    const categoriesContainer = document.querySelector('.workout-categories');
    let categoriesHTML = '';

    categoriesData.forEach(category => {
        // If filter is 'registered', only show registered categories
        if (filter === 'registered' && !category.category_description.includes('✅')) {
            return; // Skip categories without registration
        }
        
        categoriesHTML += 
            `<div class="category-box">
                <img src="${category.category_image}" alt="${category.category_name}">
                <p>${category.category_name}</p>
                <span>${category.category_description}</span>
            </div>`;
    });

    categoriesContainer.innerHTML = categoriesHTML;
}

function setActiveTab(tab) {
    const allCategoriesTab = document.querySelector('.tab.all');
    const registeredTab = document.querySelector('.tab.registered');

    if (tab === 'all') {
        allCategoriesTab.classList.add('active');
        registeredTab.classList.remove('active');
    } else if (tab === 'registered') {
        registeredTab.classList.add('active');
        allCategoriesTab.classList.remove('active');
    }
}

// Function to handle tab click
function handleTabClick(tab) {
    displayCategories(tab);
    setActiveTab(tab);
}

// Fetch planner data and categories on page load
window.onload = function() {
    updateCalendar();
    fetchPlannerData();
    fetchCategories();
};
