<?php require_once 'php/config.php'; ?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>FatEnTa | İletişim</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="lib/css/bootstrap.min.css">
    <link rel="stylesheet" href="lib/css/all.min.css">
</head>
<body class="text-white">

<div id="preloader">
    <div class="spinner-border text-warning" role="status"></div>
</div>

<!-- Navbar buraya yüklenecek -->
<div id="navbar-placeholder"></div>

<div id="app" class="container my-5">
    <section class="about text-center py-5 mb-5 rounded-5 shadow-lg overflow-hidden">
        <h1 class="display-4 fw-bold text-white">Bana Ulaşın</h1>
        <p class="lead text-white-50">Bir proje fikriniz mi var? Mesajınızı bekliyorum.</p>
    </section>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 p-4">
                <form id="iletisimFormu" action="php/iletisim_islem.php" method="POST" class="row g-4" @submit.prevent="gonder">

                    <!-- CSRF token (Session tabanlı) -->
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Ad Soyad</label>
                        <input type="text" name="ad" class="form-control form-control-lg" v-model="form.ad" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">E-posta</label>
                        <input type="email" name="email" class="form-control form-control-lg" v-model="form.email" required />
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Konu</label>
                        <input type="text" name="konu" class="form-control form-control-lg" v-model="form.konu" required />
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Mesaj</label>
                        <textarea name="mesaj" class="form-control form-control-lg" v-model="form.mesaj" rows="5" required></textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Cinsiyet</label><br>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="cinsiyet" v-model="form.cinsiyet" value="Erkek" class="form-check-input">
                            <label class="form-check-label">Erkek</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="cinsiyet" v-model="form.cinsiyet" value="Kadın" class="form-check-input">
                            <label class="form-check-label">Kadın</label>
                        </div>
                    </div>



                    <div class="col-12">
                        <input type="checkbox" name="onay" v-model="form.onay"> Verilerimin işlenmesini onaylıyorum.
                    </div>

                    <div class="col-12 text-center mt-5">
                        <!-- Denetleme Grubu: Ödevin "Ayrı Buton" Kuralını Şıklaştırır -->
                        <div class="btn-group shadow-sm me-3" role="group" aria-label="Denetleme Butonları">
                            <button type="button" id="js-denetle-btn" class="btn btn-outline-info px-4 fw-bold">
                                <i class="fa-brands fa-js me-2"></i>JS Kontrolü
                            </button>
                            <button type="button" @click="vueDenetle" class="btn btn-outline-warning px-4 fw-bold">
                                <i class="fa-brands fa-vuejs me-2"></i>Vue Kontrolü
                            </button>
                        </div>

                        <!-- Ana Aksiyon: PHP Gönderimi -->
                        <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold rounded-pill shadow">
                            <i class="fa-solid fa-paper-plane me-2"></i>Mesajı Gönder (PHP)
                        </button>

                        <!-- Temizleme -->
                        <div class="mt-3">
                            <button type="button" class="btn btn-link text-secondary text-decoration-none" @click="temizle">
                                <i class="fa-solid fa-eraser me-1"></i>Formu Temizle
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="footer-placeholder"></div>

<!-- Kütüphaneler -->
<script src="lib/js/vue.global.js"></script>
<script src="lib/js/bootstrap.bundle.min.js"></script>
<script src="navbar-loader.js"></script>
<script src="js/iletisim.js"></script>

<script>
    window.addEventListener('load', function() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.style.display = 'none';
        }
    });
</script>
</body>
</html>

