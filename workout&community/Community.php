
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community</title>
    <link rel="stylesheet" href="../general/Navigation.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
</head>


<style>

</style>

<script>





</script>                        
<body>

  <header><?php include "../general/Header.php";?> </header>

    <!-- NAVIGATION BAR  -->
<div class='navSpacing '> 
    <div>
        <nav class="bar">
            <ul>
                <li><a href="../homepage/MainPage.php">Home</a></li>
                
                <li class="seperator">/</li>
                <li><a href="Community.php" class="current">Community</a></li>
            </ul>
        </nav>
</div>   
</div>
    <div class='wrapperSpacing'>
    <div class="LiveWorkoutContainer1">
        <img src="../images/test.jpg" alt="Guy Lifting Barbell">
        <div class="textOnWorkout1">
            <h3>Join Others Like You</h3>
        </div>
        <div class="buttonInContainer1">
            <a href="videoDB(C).php?id=50" id="50">Get Started</a>
        </div>
    </div>

    <div class="LiveWorkoutContainer1">
        <img src="../images/1testcopy.jpg" alt="Guy Lifting Barbell">
        <div class="textOnWorkout1">
            <h3>Share Experiences</h3>
        </div>
        <div>
            <button onclick="on()" class="buttonInContainer2">Get Started</button>
        </div>
    </div>

    <div id="overlay1">
    <button class="xButton1" onclick="off()">X</button>
    <div class="overlayBox">  <!-- White background layer -->
        <div class="overlayContent1">
            <div class="inputContainer">
                <form action="Sharing.php" method="post" enctype="multipart/form-data" autocomplete="off">
                    <h2>Create A Post</h2>
                    <div class="input-box">
                        <img id="preview" class="previewImage">
                        <input type="file" id="fileInput" name="fileImage" accept="image/*"> 
                    </div>
                    <div class="input-box">
                        <input id="blogDate" name="date" readonly>
                        <label id="dateLabel">Date</label>
                    </div>
                    <div class="input-box">         
                        <input type="text" id="myText" name="name" required>
                        <label>Enter Name</label>
                    </div>
                    <div class="input-box">
                        <input type="text" id="myText" name="captionText" required>
                        <label>Enter Caption</label>
                    </div>
                    <input type="submit" class="submit" name="submit" value="Upload">       
                </form>
            </div>
        </div>
    </div>
</div>


    
    

    <script src="script.js?v=<?php echo time(); ?>">
      


    </script>


    <div class="TextOnLine">
    <h2>BLOG</h2>
    </div>

    <hr class="upperline">

    <div class="dropdown">
        <button onclick="dropDownList()" class="dropbtn1"><img src="../images/loupe.png" alt="Search"></button>
        <div id="filDropdown1" class="filter-content">
          <input type="text" placeholder="Search..." id="filterInput" onkeyup="filterFunction()">
          <a href="blog.php?id=1" id="1">25 Tips for Exercise Success</a>
          <a href="blog.php?id=2" id="2">Training Secrets of Olympians To Stay Fit</a>
          <a href="blog.php?id=3" id="3">The Truth About Protein</a>
          <a href="blog.php?id=4" id="4">Resistance Training Workouts for Beginners</a>
          <a href="blog.php?id=5" id="9">7 Benefits of Sleep</a>
          <a href="blog.php?id=6" id="6">Exercise for Weight Loss</a>
          <a href="blog.php?id=7" id="7">HIIT Workout Plan</a>
        </div>
    </div>

    <figure class="fig1" > 
      <div class="column1">
          <a href="blog.php?id=1" id="1"><img src="../images/id1q.jpg" alt="Snow" style="width:100%"></a>
          <figcaption>25 Tips for Exercise Success</figcaption>
      </div>
      <div class="column1">
          <a href="blog.php?id=2" id="2"><img src="../images/id2q.jpg" alt="Forest" style="width:100%"></a>
          <figcaption>Training Secrets of Olympians To Stay Fit</figcaption>
      </div>
      <div class="column1">
          <a href="blog.php?id=3" id="3"><img src="../images/id3.jpg" alt="Mountains" ></a>
          <figcaption>The Truth About Protein</figcaption>
      </div>

      <div class="column1">
          <a href="blog.php?id=4" id="4"><img src="../images/id4.jpg" alt="Snow" style="width:100%"></a>
          <figcaption>Resistance Training Workouts for Beginners</figcaption>
      </div>
      <div class="column1">
          <a href="blog.php?id=5" id="5"><img src="../images/id5.jpg" alt="Forest" style="width:100%"></a>
          <figcaption>7 Yoga Poses to Counteract the Effects of Prolonged Sitting</figcaption>
      </div>
      <div class="column1">
          <a href="blog.php?id=6" id="6"><img src="../images/id6.jpg" alt="Mountains" style="width:100%"></a>
          <figcaption>Leveraging Exercise for Weight Loss</figcaption>
      </div>
      
      <div class="column1">
          <a href="blog.php?id=7" id="7"><img src="../images/id7.jpg" alt="Snow" style="width:100%"></a>
          <figcaption>10-Day HIIT Workout Plan</figcaption>
      </div>
      <div class="column1">
          <a href="blog.php?id=8" id="8"><img src="../images/id8.jpg" alt="Forest" style="width:100%"></a>
          <figcaption>Five Practical Ways to Jumpstart Your Health</figcaption>
      </div>
      <div class="column1">
          <a href="blog.php?id=9" id="9"><img src="../images/id9.jpg" alt="Mountains" style="width:100%"></a>
          <figcaption>7 Benefits of Sleep for Exercise Recovery</figcaption>
      </div>
  </figure>

<hr>
</div>
  <?php include "../general/Footer.php";?>

</body>
</html>