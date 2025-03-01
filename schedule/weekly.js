document.addEventListener('DOMContentLoaded', function() {
    fetch('fetch_weekly.php')
        .then(response => response.json())
        .then(data => {
            const weeklyProgramTable = document.getElementById('weeklyProgramTable');
            const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

            // Create a mapping of days to workout data (array to hold multiple workouts per day)
            const workoutMap = {};

            // Populate workoutMap with data from the server, storing multiple workouts per day
            data.forEach(workout => {
                const workoutDate = new Date(workout.workout_date);
                const dayOfWeek = workoutDate.toLocaleString('en-US', { weekday: 'long' });

                // If the day doesn't exist in the map, initialize an array
                if (!workoutMap[dayOfWeek]) {
                    workoutMap[dayOfWeek] = [];
                }

                // Push the workout into the corresponding day array
                workoutMap[dayOfWeek].push(workout);
            });

            // Fill the table with each workout separately, showing rest days if no workout is scheduled
            daysOfWeek.forEach(day => {
                if (workoutMap[day] && workoutMap[day].length > 0) {
                    // Loop through all workouts for the current day
                    workoutMap[day].forEach((workout, index) => {
                        const row = document.createElement('tr');

                        // Only display the weekday once (for the first workout of the day)
                        if (index === 0) {
                            row.innerHTML = `
                                <td rowspan="${workoutMap[day].length}">${day}</td>
                                <td><span class="workout-type workout">${workout.workout_name}</span></td>
                                <td><span class="workout-category">${workout.workout_type}</span></td>
                                <td>${workout.workout_notes}</td>
                            `;
                        } else {
                            // For subsequent workouts on the same day, create new rows without the day column
                            row.innerHTML = `
                                <td><span class="workout-type workout">${workout.workout_name}</span></td>
                                <td><span class="workout-category">${workout.workout_type}</span></td>
                                <td>${workout.workout_notes}</td>
                            `;
                        }

                        weeklyProgramTable.appendChild(row);
                    });
                } else {
                    // If no workouts are planned for the day, show a rest day
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${day}</td>
                        <td><span class="workout-type rest">Rest</span></td>
                        <td><span class="workout-category">Relaxation</span></td>
                        <td>No workout planned.</td>
                    `;
                    weeklyProgramTable.appendChild(row);
                }
            });
        })
        .catch(error => {
            console.error('Error fetching workout data:', error);
        });
});



function goToAddWorkout() {
    window.location.href = 'submit_workout.php';
}
