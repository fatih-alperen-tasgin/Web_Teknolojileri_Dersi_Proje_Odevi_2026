document.addEventListener("DOMContentLoaded", function() {
    // 1. GİRİŞ EFEKTİ: Sayfa yüklendiğinde body'e 'loaded' sınıfı ekle
    setTimeout(() => {
        document.body.classList.add("loaded");
    }, 100);

    fetch('navbar.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('navbar-placeholder').innerHTML = data;

            // Aktif sayfa belirleme mantığı (zaten yapmıştık)
            let page = window.location.pathname.split("/").pop() || "index.html";
            const navLinks = document.querySelectorAll(".nav-link");
            navLinks.forEach(link => {
                if (link.getAttribute("href") === page) {
                    // Çizginin aniden değil, yumuşakça belirmesi için gecikmeli ekleyelim
                    setTimeout(() => {
                        link.classList.add("active");
                    }, 100);
                }
            });

            // 2. ÇIKIŞ EFEKTİ: Navbar linklerine tıklanınca yumuşak geçiş yap
            document.getElementById('navbar-placeholder').addEventListener('click', function(e) {
                const link = e.target.closest('.nav-link');
                if (link && link.hostname === window.location.hostname) {
                    const target = link.href;

                    // Eğer zaten o sayfadaysak tekrar yükleme yapma
                    if (target === window.location.href) return;

                    e.preventDefault(); // Sayfanın hemen açılmasını engelle
                    document.body.classList.remove("loaded"); // Fade-out başlat

                    setTimeout(() => {
                        window.location.href = target;
                    }, 400); // CSS transition süresiyle (0.4s) uyumlu olmalı
                }
            });
        });
    window.addEventListener("load", function() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.classList.add('loader-hidden');
        }
    });
    window.addEventListener("load", function() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            // Çok kısa bir gecikme ekleyerek beyaz patlamayı tamamen eziyoruz
            setTimeout(() => {
                preloader.classList.add('loader-hidden');
            }, 300);
        }
    });
});