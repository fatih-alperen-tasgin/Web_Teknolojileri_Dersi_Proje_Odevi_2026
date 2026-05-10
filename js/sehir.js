/*
 * [FILE]: sehir.js
 * [ARCHITECTURE]: Merkezi etkilesim yonetimi (Scroll to Center & Lightbox)
 */

document.addEventListener('DOMContentLoaded', function() {

    // 1. Slider Resimlerine Tiklayinca Asagi Ortala (Scroll to Center)
    const scrollLinks = document.querySelectorAll('.carousel-item a');
    scrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
    });

    // 2. SADECE Aciklama Kismindaki Resimleri Tam Ekran Ac (Lightbox)
    const sectionImages = document.querySelectorAll('section .img-cover');
    const modalElement = document.getElementById('imageModal');

    if (modalElement) {
        const imageModal = new bootstrap.Modal(modalElement);
        const modalImage = document.getElementById('modalImage');

        sectionImages.forEach(img => {
            img.addEventListener('click', function() {
                const imgSrc = this.getAttribute('src');
                modalImage.setAttribute('src', imgSrc);
                imageModal.show();
            });
        });
    } else {
        console.warn("[ERROR]: Lightbox Modal elementi DOM uzerinde bulunamadi.");
    }
});