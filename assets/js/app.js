const body = document.querySelector('body');
const header = document.querySelector('header');
const header_logo = document.querySelector('header .header__logo');
const hamburger = document.querySelector('.menu__icon');
const line1 = document.querySelector('.menu__icon--one');
const line2 = document.querySelector('.menu__icon--two')
const line3 = document.querySelector('.menu__icon--three')
const menu = document.querySelector('.menu');
const links = document.querySelectorAll('.menu li');
const title_parts = document.querySelectorAll('.title__part');

window.addEventListener('scroll', function () {
    var links = document.querySelectorAll('.nav-link')
    
    menu.classList.toggle('sticky', window.scrollY > 0);
    header.classList.toggle('sticky', window.scrollY > 0);
    header_logo.classList.toggle('sticky', window.scrollY > 0)
    line1.classList.toggle('sticky', window.scrollY > 0);
    line2.classList.toggle('sticky', window.scrollY > 0);
    line3.classList.toggle('sticky', window.scrollY > 0);
    links.forEach(link => {
        link.classList.toggle('sticky',window.scrollY > 0);
    });
})

hamburger.addEventListener('click', () => {
    body.classList.toggle('active');
    title_parts.forEach(title => {
        title.classList.toggle('none')
    });
    header_logo.classList.toggle('active');
    menu.classList.toggle('open');
    links.forEach(link => {
        link.classList.toggle('fade');
    });
    line1.classList.toggle('active');
    line2.classList.toggle('active');
    line3.classList.toggle('active');
    
})


// work

const service_name = document.querySelector('.work__left-part');

if (window.width > 768) {
    window.addEventListener('scroll', () => {
    if (window.scrollY >= 1550) {
        service_name.classList.add('fixed')
    } else {
        service_name.classList.remove('fixed')
    }
})
}