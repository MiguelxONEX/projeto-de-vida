document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const menuContent = document.querySelector('.menu-content');

    menuToggle.addEventListener('click', function(e) {
        e.stopPropagation();
        menuContent.classList.toggle('active');
        menuToggle.classList.toggle('active');
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInsideMenu = menuContent.contains(event.target);
        const isClickOnToggle = menuToggle.contains(event.target);
        
        if (!isClickInsideMenu && !isClickOnToggle && menuContent.classList.contains('active')) {
            menuContent.classList.remove('active');
            menuToggle.classList.remove('active');
        }
    });

    // Prevent clicks inside menu from closing it
    menuContent.addEventListener('click', function(e) {
        e.stopPropagation();
    });
});
