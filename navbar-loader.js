document.addEventListener("DOMContentLoaded", function() {
    // 1. GİRİŞ EFEKTİ: Fade-in başlat
    setTimeout(() => {
        document.body.classList.add("loaded");
    }, 100);

    // 2. NAVBAR YÜKLEME VE DİNAMİK KONTROLLER
    fetch('navbar.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('navbar-placeholder').innerHTML = data;

            // --- Giriş Durumu Kontrolü (Tam Burada Olmalı) ---
            const girisButonu = document.querySelector(".ms-auto a[href='login.html']");
            const isLoggedIn = localStorage.getItem('isLoggedIn');
            const username = localStorage.getItem('username');

            if (isLoggedIn === 'true' && girisButonu) {
                // "Giriş Yap" butonunu senin isminle değiştiriyoruz
                girisButonu.parentElement.innerHTML = `
                    <div class="dropdown">
                        <button class="btn btn-outline-warning dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user me-1"></i> ${username}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="#" id="logoutLink">Çıkış Yap</a></li>
                        </ul>
                    </div>
                `;

                // Çıkış işlemini tetikle
                document.getElementById('logoutLink').addEventListener('click', (e) => {
                    e.preventDefault();
                    logout();
                });
            }
            // ----------------------------------------------

            // Aktif sayfa belirleme
            let page = window.location.pathname.split("/").pop() || "index.html";
            const navLinks = document.querySelectorAll(".nav-link");
            navLinks.forEach(link => {
                if (link.getAttribute("href") === page) {
                    setTimeout(() => { link.classList.add("active"); }, 100);
                }
            });

            // Yönlendirme Efekti
            document.getElementById('navbar-placeholder').addEventListener('click', function(e) {
                const link = e.target.closest('.nav-link');
                if (link && link.hostname === window.location.hostname) {
                    const target = link.href;
                    if (target === window.location.href) return;
                    e.preventDefault();
                    document.body.classList.remove("loaded");
                    setTimeout(() => { window.location.href = target; }, 400);
                }
            });
        });

    // 3. PRELOADER YÖNETİMİ
    window.addEventListener("load", function() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            setTimeout(() => { preloader.classList.add('loader-hidden'); }, 300);
        }
    });
});

// Çıkış Fonksiyonu (Global)
function logout() {
    localStorage.removeItem('isLoggedIn');
    localStorage.removeItem('username');
    window.location.href = 'index.html'; // Çıkış yapınca ana sayfaya dön
}