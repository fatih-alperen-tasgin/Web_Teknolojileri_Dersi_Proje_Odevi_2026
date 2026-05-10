function hidePreloader() {
    const preloader = document.getElementById('preloader');
    if (preloader) {
        preloader.classList.add('loader-hidden');
    }
}

document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        document.body.classList.add("loaded");
    }, 100);

    const navbarPromise = fetch('navbar.html')
        .then(response => {
            if (!response.ok) throw new Error(`Navbar yuklenemedi: ${response.status}`);
            return response.text();
        })
        .then(data => {
            const navbarPlaceholder = document.getElementById('navbar-placeholder');
            if (navbarPlaceholder) {
                navbarPlaceholder.innerHTML = data;

                const girisButonu = document.querySelector(".ms-auto a[href='login.php']");
                const isLoggedIn = localStorage.getItem('isLoggedIn');
                const username = localStorage.getItem('userDisplay');

                if (isLoggedIn === 'true' && girisButonu) {
                    girisButonu.parentElement.innerHTML = `
                        <div class="dropdown">
                            <button class="btn btn-outline-warning dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fa fa-user me-1"></i> ${username || 'Kullanıcı'}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="#" id="logoutLink">Çıkış Yap</a></li>
                            </ul>
                        </div>`;

                    const logoutEl = document.getElementById('logoutLink');
                    if (logoutEl) {
                        logoutEl.addEventListener('click', (e) => {
                            e.preventDefault();
                            logout();
                        });
                    }
                }

                let page = window.location.pathname.split("/").pop() || "index.html";
                const navLinks = document.querySelectorAll(".nav-link");
                navLinks.forEach(link => {
                    if (link.getAttribute("href") === page) {
                        setTimeout(() => { link.classList.add("active"); }, 100);
                    }
                });
            }
        })
        .catch(error => {
            console.error(error);
        });

    const footerPromise = fetch('footer.html')
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

    Promise.allSettled([navbarPromise, footerPromise]).finally(() => {
        setTimeout(hidePreloader, 300);
    });

    window.addEventListener("load", hidePreloader);

    setTimeout(hidePreloader, 5000);
});

function logout() {
    localStorage.removeItem('isLoggedIn');
    localStorage.removeItem('userDisplay');
    window.location.href = 'index.html';
}