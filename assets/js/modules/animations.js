// ----------------------------
// Animation NAVBAR
// ----------------------------

let hamburger = document.getElementById('l-topbar-hamburger');
let menu = document.getElementById('l-topbar-navbar');

hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    menu.classList.toggle('active');
})
    