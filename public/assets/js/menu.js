const navContainer = document.querySelector('.nav-container');
const navMenu = document.querySelector('.nav-menu');
const menuBurger = document.querySelector('#menu-burger');
const menuClose = document.querySelector('#menu-close');

function openNav() {
    if (window.matchMedia("(max-width: 979px)").matches) {
        navContainer.style.width = "100%";
        navMenu.style.display = "flex";
        menuBurger.style.display = "none";
        menuClose.style.display = "flex";
    }
}

function closeNav() {
    navContainer.style.width = "0";
    navMenu.style.display = "none";
    menuBurger.style.display = "flex";
    menuClose.style.display = "none";
}

menuBurger.addEventListener('click',openNav);
menuClose.addEventListener('click',closeNav);
