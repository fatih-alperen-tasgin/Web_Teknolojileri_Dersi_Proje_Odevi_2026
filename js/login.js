document.getElementById('loginForm').addEventListener('submit', function(event) {
    const kullanici = document.getElementById('kullanici').value.trim();
    const sifre = document.getElementById('sifre').value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // 1. Boş alan kontrolü
    if (!kullanici || !sifre) {
        alert("Lütfen tüm alanları doldurunuz!");
        event.preventDefault(); // Formun PHP'ye gitmesini engelle
        return;
    }

    // 2. Mail formatı kontrolü
    if (!emailRegex.test(kullanici)) {
        alert("Lütfen geçerli bir e-posta formatı giriniz!");
        event.preventDefault();
    }

    // Her şey doğruysa form php/login.php'ye gidecek
});