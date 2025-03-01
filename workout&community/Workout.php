<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout</title>
    <link rel="stylesheet" href="../general/Navigation.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">

</head>


<script src='workout.js?v=<?php echo time(); ?>' >

</script>

<body>

<?php include "../general/Header.php";?>

    <!-- NAVIGATION BAR  -->
    <div class="div">
        <nav class="bar">
            <ul>
                <li><a href="../homepage/MainPage.php">Home</a></li>
                
                <li class="seperator">/</li>
                <li><a href="Workout.php" class="current">Workout</a></li>
            </ul>
        </nav>   
    </div>
    <div class='wrapperSpacing'>
    <div class="workout1stimage">
        <img src="../images/Home.png" alt="Guy Lifting Barbell">
        <div class="textOnWorkout">
            <h3>PUSH PAST YOUR</h3>
            <h3 class="colorText">LIMITS</h3>
            <p class="normText">Follow Along With Our Instructors</p>
        </div>
    </div>
    
    <!-- Overlay contents off "COLLECTIONS" -->
    <div id="overlay">
      <button class="xButton" onclick="off()">X</button>
      <div class="overlayContent">
        <div class="overlayHeader">
          <h2>Our Collection Of Trainers</h2>
        </div>
        <!-- Profiles displayed in row -->
        <div class="profile-container">
          <div class="profile">
            <button class="cHeria" onclick="showDropDown1()">
              <img src="../images/chrisHeria.jpg" alt="">
            </button>
            
            <div id="dropdownId1" class="overDrop-content">
              <a href="videoDB.php?id=5" id="5">Leg Workout</a>
              <a href="videoDB.php?id=6" id="6">Upper Body Stretch</a>
              <a href="videoDB.php?id=7" id="7">Ab Workout</a>
            </div>
            <span class="name">Chris Heria</span>
          </div>
          <div class="profile">
            <button class="jNippard" onclick="showDropDown2()">
              <img src="../images/jeffNippard.jpg" alt="">
            </button>
            
            <div id="dropdownId2" class="overDrop-content">
              <a href="videoDB.php?id=8" id="8">Minimalist Workout</a>
              <a href="videoDB.php?id=9" id="9">Push Pull Split</a>
              <a href="videoDB.php?id=15" id="15">Muscle Technique</a>
            </div>
            <span class="name">Jeff Nippard</span>
          </div>
          <div class="profile">
            <button class="aMishler" onclick="showDropDown3()">
              <img src="../images/Adriana.jpg" alt="">
            </button>
            
            <div id="dropdownId3" class="overDrop-content">
              <a href="videoDB.php?id=21" id="21">Moon Yoga</a>
              <a href="videoDB.php?id=22" id="22">Healing Yoga</a>
              <a href="videoDB.php?id=23" id="23">Wake Up Flow</a>
            </div>
            <span class="name">Adriene Mishler</span>
          </div>
        </div>
      </div>
    </div>
    

    <hr class="">
    
    <div class="centeredContainer">
        <div class="dropdown">
          <button onclick="dropDownList()" class="dropbtn">FILTER</button>
          <div id="filDropdown" class="filter-content">
            <input type="text" placeholder="Search..." id="filterInput" onkeyup="filterFunction()">
            <a href="videoDB.php?id=1" id="1">Full Body Workout</a>
            <a href="videoDB.php?id=2" id="2">Fat Burning Workout</a>
            <a href="videoDB.php?id=3" id="3">Complete Arm Workout</a>
            <a href="videoDB.php?id=4" id="4">CARDIO Workout</a>
            <a href="videoDB.php?id=5" id="5">Leg Workout</a>
            <a href="videoDB.php?id=6" id="6">Upper Body Stretch</a>
            <a href="videoDB.php?id=7" id="7">Ab Workout</a>
          </div>
        </div>
      
        <div class="dropdown" >
          <button onclick="on()" class="dropbtn">COLLECTIONS</button>
          <div id="myDropdown2" class="filter-content">
            
          </div>
        </div>
      </div>


      <figure class="figure21">
        <div class="column">
            <a href="videoDB.php?id=1" id="1"><img src="../images/5KXZ9I2z1m4-HD.jpg" alt="Snow" style="width:100%"></a>
            <figcaption>Full Body Workout w/ Chris Heria</figcaption>
        </div>
        <div class="column">
            <a href="videoDB.php?id=2" id="2"><img src="../images/Eq4qBpBa07I-HD.jpg" alt="Forest" style="width:100%"></a>
            <figcaption>20-minute Fat Burn w/ Chris Heria</figcaption>
        </div>
        <div class="column">
            <a href="videoDB.php?id=3" id="3"><img src="../images/M42-2wgRWkA-HD.jpg" alt="Mountains" style="width:100%"></a>
            <figcaption>Complete Arm Workout w/ Chris Heria</figcaption>
        </div>

        <div class="column">
            <a href="videoDB.php?id=8" id="8"><img src="../images/wd.jpg" alt="Snow" style="width:100%"></a>
            <figcaption>Minimalist Workout w/ Jeff Nippard</figcaption>
        </div>
        <div class="column">
            <a href="videoDB.php?id=9" id="9"><img src="../images/psuh.jpg" alt="Forest" style="width:100%"></a>
            <figcaption>Push Pull Split w/ Jeff Nippard</figcaption>
        </div>
        <div class="column">
            <a href="videoDB.php?id=6" id="6"><img src="../images/stretch.jpg" alt="Mountains" style="width:100%"></a>
            <figcaption>Upper Body Stretch w/ Chris Heria</figcaption>
        </div>
    </figure>
    
<hr class="">
<br>

    

    <div class="Workoutquote"> <!-- WORKOUT QUOTE -->
        <img src="../images/arnold.jpg" alt="WorkoutQuoteImage">
        <div class="textOnWorkoutQuote">
        <h2 class="quote1">“If you don’t find the time, If you don’t do the work, You don’t get the results.”</h2>
        <h2 class="quote2">-</h2>
        <h2 class="quote3"> Arnold Schwarzenegger</h2>
        </div>
    </div>

   
    <div class="workoutText">
    <h2>Workouts You may Like</h2> <!-- WORKOUT SUGGESTIONS -->
    </div>
    <figure class="figure2">
        <div class="column2">
            <a href="videoDB.php?id=21" id="21"><img src="../images/71PmTZOgmXA-HD.jpg" alt="Snow" style="width:100%"></a>
            <figcaption>Moon Yoga w/ Adriene Mishler</figcaption>
        </div>
        <div class="column2">
            <a href="videoDB.php?id=15" id="15"><img src="../images/jeffVid.jpg" alt="Forest" style="width:100%"></a>
            <figcaption>Muscle Technique w/ Jeff Nippard</figcaption>
        </div>
        <div class="column2">
            <a href="videoDB.php?id=22" id="22"><img src="../images/FvaE0KofQEA-HD.jpg" alt="Mountains" style="width:100%"></a>
            <figcaption>Morning FLow w/ Adriene Mishler</figcaption>
        </div>
    </figure>

<hr>
</div>

<?php include "../general/Footer.php";?>
</body>
</html>
