function on() {
    document.getElementById("overlay1").classList.add("active");
  
  }
  
  function off() {
    document.getElementById("overlay1").classList.remove("active");
  
  }
  
  
  
  const d = new Date();
  
  var DATE = String(d.getDate()) + '/' + String(d.getMonth()) + '/' + String(d.getFullYear());
  
  var TIME = d.toLocaleString("en-US",
  
    {
      hour: "numeric",
  
      minute: "numeric",
  
      hour12: true
    }
  
  );
  
  // console.log(DATE);
  
  // console.log(TIME);
  
  var dateTime = DATE + ', ' + TIME;
  
  document.getElementById("blogDate").value = dateTime;
  
  
  
  
 
  
  
  
  /* FILTER Dropdown */
  function dropDownList() {
    document.getElementById("filDropdown1").classList.toggle("show");
  }
  
  function filterFunction() {
    const input = document.getElementById("filterInput1");
    const filter = input.value.toUpperCase();
    const div = document.getElementById("filDropdown1");
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
          // allows users to preview img entered
      const input = document.getElementById('fileInput');
      const preview = document.getElementById('preview');
  
      input.addEventListener('change', () => {
        const reader = new FileReader();
  
        reader.onload = () => {
          preview.src = reader.result;
        };
  
        reader.readAsDataURL(input.files[0]);
      });


      
           