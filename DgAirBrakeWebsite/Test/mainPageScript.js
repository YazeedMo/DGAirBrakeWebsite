document.addEventListener('DOMContentLoaded', (event) => {
    const openPopupButton = document.getElementById('openPopupButton');
    const closePopupButton = document.getElementById('closePopupButton');
    const popupOverlay = document.getElementById('popupOverlay');
    const mainContent = document.getElementById('mainContent');

    openPopupButton.addEventListener('click', () => {
        popupOverlay.style.display = 'flex';
        mainContent.classList.add('blur');
    });

    closePopupButton.addEventListener('click', () => {
        popupOverlay.style.display = 'none';
        mainContent.classList.remove('blur');
    });

    popupOverlay.addEventListener('click', (e) => {
        if (e.target === popupOverlay) {
            popupOverlay.style.display = 'none';
            mainContent.classList.remove('blur');
        }
    });
});
