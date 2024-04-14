
////////////////////////////////  check login  ////////////////////////////////////
let token = null
// Define a function to check for token in localStorage
function checkToken() {
    // Check if data with key name "token" exists in localStorage
    if (localStorage.getItem("token")) {
        // Data with key name "token" exists
        // Log the token to the console
        console.log("Token:", localStorage.getItem("token"));
        token = localStorage.getItem("token");
        
        loadTable();
        // window.location.href = 'index.html';
    } else {
        // Data with key name "token" does not exist
        window.location.href = 'login.html';
        // Log "fail" to the console
        console.log("Fail");
    }
}

// Add an event listener for DOMContentLoaded event
document.addEventListener("DOMContentLoaded", function() {
    // Call the checkToken function before the page loads
    checkToken();
});


////////////////////////////////  load data   /////////////////////////////////////

function loadTable() {
    const xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost/api/index.php/welcome/students");
    // Append authorization header
    xhttp.setRequestHeader("Authorization", `Bearer ${token}`);
    xhttp.send();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        // console.log(this.responseText);
        var trHTML = "";
        const objects = JSON.parse(this.responseText);
        // console.log(objects);
        // console.log(objects['data']);
        for (let object of objects['data']) {
          trHTML += "<tr>";
          trHTML += "<td>" + object["id"] + "</td>";
          trHTML += "<td>" + object["email"] + "</td>"
          trHTML += "<td>" + object["name"] + "</td>";
          trHTML += "<td>" + object["dob"] + "</td>";
          trHTML += "<td>" + object["contact"] + "</td>";
          trHTML +=
            '<td><button type="button" class="btn btn-outline-secondary" onclick="showUserEditBox(' +
            object["id"] +
            ')">Edit</button>';
          trHTML +=
            '<button type="button" class="btn btn-outline-danger" onclick="userDelete(' +
            object["id"] +
            ')">Del</button></td>';
          trHTML += "</tr>";
        }
        document.getElementById("mytable").innerHTML = trHTML;
      } else if(this.status == 401){
        console.log('Getting 401 error')
        logout();
      }
    };
  }


/////////////////////////   Create Student  ///////////////////////////////////////
  function showUserCreateBox() {
    Swal.fire({
      title: "Create user",
      html:
        '<input id="id" type="hidden">' +
        '<input id="name" class="swal2-input" placeholder="Name">' +
        '<input id="email" class="swal2-input" placeholder="Email">' +
        '<input id="dob" class="swal2-input" placeholder="Date of birth">' +
        '<input id="contact" class="swal2-input" placeholder="Mobile number">'+
        '<input id="password" class="swal2-input" placeholder="Password">',
      focusConfirm: false,
      preConfirm: () => {
        userCreate();
      },
    });
  }
  
  function userCreate() {
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const dob = document.getElementById("dob").value;
    const contact = document.getElementById("contact").value;
    const password = document.getElementById("password").value;
  
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "http://localhost/api/index.php/welcome/students");
    // Append authorization header
    xhttp.setRequestHeader("Authorization", `Bearer ${token}`);
    xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhttp.send(
      JSON.stringify({
        name: name,
        email: email,
        dob: dob,
        contact: contact,
        password: password
      })
    );
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 201) {
        const objects = JSON.parse(this.responseText);
        Swal.fire(objects["message"]);
        loadTable();
      } else if(this.status == 401){
        console.log('Getting 401 error')
        logout();
      }
    };
  }



//////////////////////////////////////    Update student   /////////////////////////////////
function showUserEditBox(id) {
    // console.log(id);
    const xhttp = new XMLHttpRequest();
    xhttp.open("GET", `http://localhost/api/index.php/welcome/students/${id}/`);
    // Append authorization header
    xhttp.setRequestHeader("Authorization", `Bearer ${token}`);
    xhttp.send();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const objects = JSON.parse(this.responseText);
        const user = objects["data"];
        // console.log(user);
        Swal.fire({
          title: "Edit User",
          html:
            '<input id="id" type="hidden" value=' +
            user["id"] +
            ">" +
            '<input id="name" class="swal2-input" placeholder="Name" value="' +
            user["name"] +
            '">' +
            '<input id="email" class="swal2-input" placeholder="Email" value="' +
            user["email"] +
            '">' +
            '<input id="dob" class="swal2-input" placeholder="Date of birth" value="' +
            user["dob"] +
            '">' +
            '<input id="contact" class="swal2-input" placeholder="Contact" value="' +
            user["contact"] +
            '">',
          focusConfirm: false,
          preConfirm: () => {
            userEdit();
          },
        });
      } else if(this.status == 401){
        console.log('Getting 401 error')
        logout();
      }
    };
  }
  
  function userEdit() {
    const id = document.getElementById("id").value;
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const dob = document.getElementById("dob").value;
    const contact = document.getElementById("contact").value;
  
    const xhttp = new XMLHttpRequest();
    xhttp.open("PUT", `http://localhost/api/index.php/welcome/students/${id}/`);
    // Append authorization header
    xhttp.setRequestHeader("Authorization", `Bearer ${token}`);
    xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhttp.send(
      JSON.stringify({
        id: id,
        name: name,
        dob: dob,
        contact: contact,
        email: email,
      })
    );
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const objects = JSON.parse(this.responseText);
        Swal.fire(objects["message"]);
        loadTable();
      } else if(this.status == 401){
        console.log('Getting 401 error')
        logout();
      }
    };
  }


///////////////////////  Delete Student   ///////////////////////////
function userDelete(id) {
    const xhttp = new XMLHttpRequest();
    xhttp.open("DELETE", `http://localhost/api/index.php/welcome/students/${id}/`);
    // Append authorization header
    xhttp.setRequestHeader("Authorization", `Bearer ${token}`);
    xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhttp.send();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4) {
        const objects = JSON.parse(this.responseText);
        Swal.fire(objects["message"]);
        loadTable();
      } else if(this.status == 401){
        console.log('Getting 401 error')
        logout();
      }
    };
  }


//////////////////  logout function ////////////////////
function logout(){
    localStorage.removeItem('token');
    window.location.href = 'login.html';
}