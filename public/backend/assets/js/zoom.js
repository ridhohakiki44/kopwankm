document.addEventListener('DOMContentLoaded', function() {
    const modalImage = document.querySelectorAll('.zoomable');
    
    modalImage.forEach((img) => {
        img.addEventListener('click', function() {
            if (img.classList.contains('zoomed')) {
                img.classList.remove('zoomed');
            } else {
                img.classList.add('zoomed');
            }
        });
    });
});