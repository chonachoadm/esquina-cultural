const navOpen = document.getElementById('nav-open')
const navClose = document.getElementById('nav-close')
const mobileNavMenu = document.getElementById('mobile-nav-menu')

if (navOpen && navClose && mobileNavMenu) {
    navOpen.addEventListener('click', () => {
            mobileNavMenu.classList.remove('d-none')
            mobileNavMenu.classList.add('d-flex')
    }) 
    navClose.addEventListener('click', () => {
            mobileNavMenu.classList.add('d-none')
            mobileNavMenu.classList.remove('d-flex')
    }) 
}


const navAdminOpen = document.getElementById('nav-admin-open')
const navAdminClose = document.getElementById('nav-admin-close')
const mobileNavAdminMenu = document.getElementById('mobile-nav-admin-menu')

if (navAdminOpen && navAdminClose && mobileNavAdminMenu) {
    navAdminOpen.addEventListener('click', () => {
            mobileNavAdminMenu.classList.remove('d-none')
            mobileNavAdminMenu.classList.add('d-flex')
    }) 
    navAdminClose.addEventListener('click', () => {
            mobileNavAdminMenu.classList.add('d-none')
            mobileNavAdminMenu.classList.remove('d-flex')
    }) 
}

