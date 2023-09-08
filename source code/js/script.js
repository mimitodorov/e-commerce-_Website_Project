// toggle menu option
let userBox = document.querySelector('.header .flex .account-box');

// Onclick event "user-btn" button is clicked
document.querySelector('#user-btn').onclick = () => {
    userBox.classList.toggle('active'); // Toggle the class "active" on the userBox element
    navbar.classList.remove('active'); // Remove the class "active" from the navbar element
}

let navbar = document.querySelector('.header .flex .navbar');

// Onclick event handler to the element with the id "menu-btn"
document.querySelector('#menu-btn').onclick = () => {
    navbar.classList.toggle('active'); // Toggle the class "active" on the navbar element
    userBox.classList.remove('active'); // Remove the class "active" from the userBox element
}

// Scroll event handler to the window object
window.onscroll = () => {
    userBox.classList.remove('active'); // Remove the class "active" from the userBox element
    navbar.classList.remove('active'); // Remove the class "active" from the navbar element
}