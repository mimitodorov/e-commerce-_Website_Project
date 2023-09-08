let navbar = document.querySelector('.header .flex .navbar');
let userBox = document.querySelector('.header .flex .account-box');

// This on click event is triggered when the menubar button is clicked on mobile view
document.querySelector('#menu-btn').onclick = () =>{
    // Toggles the class "active" on the navbar element
   navbar.classList.toggle('active');
   // Removes the class "active" from the userBox element
   userBox.classList.remove('active');
}

document.querySelector('#user-btn').onclick = () =>{
    // Toggles the class "active" on the userBox element
   userBox.classList.toggle('active'); 
   // Removes the class "active" from the navbar element
   navbar.classList.remove('active');
}

window.onscroll = () =>{
    // Removes the class "active" from the navbar element
   navbar.classList.remove('active');
   // Removes the class "active" from the userBox element
   userBox.classList.remove('active');
}