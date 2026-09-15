function showSection(sectionId, event) {
    const pages = document.querySelectorAll('.page');
    pages.forEach(p => p.classList.remove('show'));

    const activePage = document.getElementById(sectionId);
    if (activePage) activePage.classList.add('show');

    const items = document.querySelectorAll('.sidebar ul li');
    items.forEach(i => i.classList.remove('active'));

    if (event) event.currentTarget.classList.add('active');
}

window.onload = function() {
    showSection('dashboard', null);
};