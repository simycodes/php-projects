
// LAST UPDATE CODE
document.querySelector("#lastUpdate").textContent = document.lastModified;
//console.log("Hello!");

// CODE FOR SHOW PASSWORD FUNCTIONALITY
function showAndHidePassword(){
    let showHidePwd = document.getElementById('showHidePwdArea');
    if(showHidePwd.type == "password"){
        showHidePwd.type = "text";
        showPasswordButton.value = "Hide Password";

        setTimeout(hidePassword,3000);
        function hidePassword(){
            showHidePwd.type = "password";
            showPasswordButton.value = "Show Password";
        }
    }
    else {
        showHidePwd.type = "password";
        showPasswordButton.value = "Show Password";
    }
}

let showPasswordButton = document.getElementById('showPwd');
showPasswordButton.addEventListener('click',showAndHidePassword);

// CODE FOR ACTIVE NAV BAR
const activePage = window.location.pathname;
console.log(activePage);

const navLinks = document.querySelectorAll("nav a").forEach(link =>{
    console.log(link.href);
    if(link.href.includes(`${activePage}`)){
        console.log(`$activePage`);
        link.classList.add("active");
    }
})
