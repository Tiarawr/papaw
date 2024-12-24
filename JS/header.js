// SHow Menu
const navMenu = document.getElementById('nav-menu'),
    navToggle = document.getElementById('nav-toggle'),
    navClose = document.getElementById('nav-close')

    // Menu Show
if (navToggle) {
    navToggle.addEventListener('click', ( ) =>
    {
        navMenu.classList.add('tampil')
    })
}

// Menu Hidden
if (navClose) {
    navClose.addEventListener('click', ( ) =>
    {
        navMenu.classList.remove('tampil')
    })
}

// Hapus menu di mobile
const navLink = document.querySelectorAll('.nav_link')

const linkAction = () => {
    const navMenu = document.getElementById('nav-menu')
    navMenu.classList.remove('tampil')
}

navLink.forEach(n => n.addEventListener('click', linkAction))

// Remove menu pada mobile
const shadowHeader = () => {
    const header = document.getElementById('header');
    // Pastikan header ditemukan
    if (header) {
        // Cek apakah scrollY lebih besar dari 50
        window.scrollY >= 50 ? header.classList.add('shadow-header')
                             : header.classList.remove('shadow-header')
    }
}

window.addEventListener('scroll', shadowHeader);