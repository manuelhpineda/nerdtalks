const hamburger = document.querySelector('.hamburger');
const navLinks = document.querySelector('.nav-links');
const links = document.querySelectorAll('.nav-links li');

//event triggered if user touches the hamburger

let burgerStatus = 'closed';

hamburger.addEventListener('click', () => {
    burger()
});

navLinks.addEventListener('click', () => {
    if (burgerStatus === 'open') {
        burger()
    }
});

function burger() {
    navLinks.classList.toggle('open');

    //burger animation
    hamburger.classList.toggle('toggle');

    //links animation
    links.forEach((link, index) => {
        if (link.style.animation) {
            link.style.animation = '';
        } else {
            link.style.animation = `navLinkFade 0.5s ease forwards ${index / 5}s`;
        }
    });

    burgerStatus = 'opened';
}

// Scroll Events

const navCont = document.querySelector('.nav');

window.onscroll = function () {
    detectScroll()
};

function detectScroll() {

    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        navCont.classList.add('nav-up');
    } else {
        navCont.classList.remove('nav-up');
    }
}
