function on() {
    document.getElementById("overlay").classList.add("active");
  
    setTimeout(() => {
        const delayedElement = document.querySelector('.delayed-element');
        delayedElement.style.opacity = '1'; // Make the button visible after the delay
      }, 500);
  }
  
  function off() {
    document.getElementById("overlay").classList.remove("active");
  
    
        const delayedElement = document.querySelector('.delayed-element');
        delayedElement.style.opacity = '0'; // Make the button visible after the delay
      
  
  }
  
  // DISPLAYS OVERLAY LINKS WHEN BUTTON CLICKED
  
  function showDropDown1() {
    var dropdown = document.getElementById("dropdownId1");
    if (dropdown.classList.contains("overDrop-open")) {
      dropdown.classList.remove("overDrop-open");
    } else {
      closeAllDropdowns();  // Close other dropdowns when this one is opened
      dropdown.classList.add("overDrop-open");
    }
  }
  
  function showDropDown2() {
    var dropdown = document.getElementById("dropdownId2");
    if (dropdown.classList.contains("overDrop-open")) {
      dropdown.classList.remove("overDrop-open");
    } else {
      closeAllDropdowns();
      dropdown.classList.add("overDrop-open");
    }
  }
  
  function showDropDown3() {
    var dropdown = document.getElementById("dropdownId3");
    if (dropdown.classList.contains("overDrop-open")) {
      dropdown.classList.remove("overDrop-open");
    } else {
      closeAllDropdowns();
      dropdown.classList.add("overDrop-open");
    }
  }
  
  // Function to close all dropdowns
  function closeAllDropdowns() {
    var dropdowns = document.querySelectorAll(".overDrop-content");
    dropdowns.forEach(function(dropdown) {
      dropdown.classList.remove("overDrop-open");
    });
  }
  
  // Close dropdowns when clicking outside of the profiles or dropdowns
  window.onclick = function(event) {
    if (!event.target.closest('.profile') && !event.target.closest('.overDrop-content')) {
      closeAllDropdowns();
    }
  }
  
  
  
  
  
  
  
  
  
  
  
  /* FILTER Dropdown */
  function dropDownList() {
    document.getElementById("filDropdown").classList.toggle("show");
  }
  
  function filterFunction() {
    const input = document.getElementById("filterInput");
    const filter = input.value.toUpperCase();
    const div = document.getElementById("filDropdown");
    const a = div.getElementsByTagName("a");
    for (let i = 0; i < a.length; i++) {
      txtValue = a[i].textContent || a[i].innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        a[i].style.display = "";
      } else {
        a[i].style.display = "none";
      }
    }
  }