document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const menuContent = document.querySelector('.menu-content');
    const menuButtons = document.querySelectorAll('.menu-btn');
    const menuButtonsMobile = document.querySelectorAll('.menu-button');

    // Menu responsivo
    menuToggle.addEventListener('click', function(e) {
        e.stopPropagation();
        menuContent.classList.toggle('active');
        menuToggle.classList.toggle('active');
    });

    // Fechar menu ao clicar fora
    document.addEventListener('click', function(event) {
        const isClickInsideMenu = menuContent.contains(event.target);
        const isClickOnToggle = menuToggle.contains(event.target);
        
        if (!isClickInsideMenu && !isClickOnToggle && menuContent.classList.contains('active')) {
            menuContent.classList.remove('active');
            menuToggle.classList.remove('active');
        }
    });

    // Prevenir fechamento ao clicar dentro do menu
    menuContent.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Ajustar tamanho dos botões do círculo
    function adjustCircleButtons() {
        const isMobile = window.innerWidth <= 768;
        menuButtonsMobile.forEach(button => {
            if (isMobile) {
                button.style.fontSize = '12px';
                button.style.padding = '6px 10px';
            } else {
                button.style.fontSize = '14px';
                button.style.padding = '8px 15px';
            }
        });
    }

    // Ajustar layout do dashboard
    function adjustDashboardLayout() {
        const dashboard = document.querySelector('.dashboard-content');
        if (dashboard) {
            const isMobile = window.innerWidth <= 768;
            if (isMobile) {
                dashboard.style.marginTop = '10px';
            } else {
                dashboard.style.marginTop = '20px';
            }
        }
    }

    // Event listener para redimensionamento
    window.addEventListener('resize', function() {
        adjustCircleButtons();
        adjustDashboardLayout();
    });

    // Inicializar ajustes
    adjustCircleButtons();
    adjustDashboardLayout();
});
