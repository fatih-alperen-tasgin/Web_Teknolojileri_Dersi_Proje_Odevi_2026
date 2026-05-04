document.addEventListener("DOMContentLoaded", function() {
    // 1. GİRİŞ EFEKTİ
    setTimeout(() => { document.body.classList.add("loaded"); }, 100);

    // 2. NAVBAR YÜKLEME
    fetch('navbar.html')
        .then(response => {
            if (!response.ok) throw new Error(`Navbar yuklenemedi: ${response.status}`);
            return response.text();
        })
        .then(data => {
            const navbarPlaceholder = document.getElementById('navbar-placeholder');
            if (!navbarPlaceholder) return;
            navbarPlaceholder.innerHTML = data;

            // Giriş Durumu Kontrolü
            const girisButonu = document.querySelector(".ms-auto a[href='login.html']");
            const isLoggedIn = localStorage.getItem('isLoggedIn');
            const username = localStorage.getItem('username');

            if (isLoggedIn === 'true' && girisButonu) {
                girisButonu.parentElement.innerHTML = `
                    <div class="dropdown">
                        <button class="btn btn-outline-warning dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fa fa-user me-1"></i> ${username}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="#" id="logoutLink">Çıkış Yap</a></li>
                        </ul>
                    </div>`;
                document.getElementById('logoutLink').addEventListener('click', (e) => {
                    e.preventDefault();
                    logout();
                });
            }

            // Aktif Sayfa Belirleme
            let page = window.location.pathname.split("/").pop() || "index.html";
            const navLinks = document.querySelectorAll(".nav-link");
            navLinks.forEach(link => {
                if (link.getAttribute("href") === page) {
                    setTimeout(() => { link.classList.add("active"); }, 100);
                }
            });
        })
        .catch(error => {
            console.error(error);
        });

    // 3. FOOTER YÜKLEME (YENİ KISIM)
    fetch('footer.html')
        .then(response => {
            if (!response.ok) throw new Error(`Footer yuklenemedi: ${response.status}`);
            return response.text();
        })
        .then(data => {
            const footerPlace = document.getElementById('footer-placeholder');
            if (footerPlace) {
                footerPlace.innerHTML = data;
            }
        })
        .catch(error => {
            console.error(error);
        });

    // 4. PRELOADER YÖNETİMİ
    window.addEventListener("load", function() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            setTimeout(() => { preloader.classList.add('loader-hidden'); }, 300);
        }
    });
});

function logout() {
    localStorage.removeItem('isLoggedIn');
    localStorage.removeItem('username');
    window.location.href = 'index.html';
}