document.getElementById('loginForm').addEventListener('submit', function(event) {
    const btn = event.target.querySelector('button[type="submit"]');
    const kullanici = document.getElementById('kullanici').value.trim();
    const sifre = document.getElementById('sifre').value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // 1. Boş alan kontrolü
    if (!kullanici || !sifre) {
        alert("Lütfen tüm alanları doldurunuz!");
        event.preventDefault();
        return;
    }

    // 2. Mail formatı kontrolü
    if (!emailRegex.test(kullanici)) {
        alert("Lütfen geçerli bir e-posta formatı giriniz!");
        event.preventDefault();
        return; // Hata durumunda fonksiyonu burada kesmeliyiz
    }

    // --- MÜHENDİSLİK DOKUNUŞU ---
    // Kontrollerden geçtiysek görsel geri bildirimi başlatıyoruz
    // Kullanıcıya bir işlem yapıldığını hissettiriyoruz.
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Kontrol Ediliyor...';

    // Dikkat: btn.disabled = true; satırı bazen formun POST verilerini
    // göndermesini engelleyebilir (bazı tarayıcılar disabled butonun verisini göndermez).
    // Bunun yerine butonu tıklanamaz yapmak için CSS kullanmak daha güvenlidir:
    btn.style.pointerEvents = 'none';
    btn.style.opacity = '0.7';
});