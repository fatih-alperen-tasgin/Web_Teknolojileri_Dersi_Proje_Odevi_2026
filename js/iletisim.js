/* FatEnTa | Iletisim Denetleme Sistemi
  Mühendislik Notu: Spesifik hata mesajlari ve gelismis dogrulama mantigi eklendi.
*/

const {createApp, ref} = Vue;

createApp({
    setup() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Form verilerini DOM üzerinden okuyan yardımcı fonksiyon (Native JS için)
        const readFormData = () => {
            const formEl = document.getElementById('iletisimFormu');
            if (!formEl) return null;

            const data = new FormData(formEl);
            return {
                ad: (data.get('ad') || '').toString().trim(),
                email: (data.get('email') || '').toString().trim(),
                konu: (data.get('konu') || '').toString().trim(),
                mesaj: (data.get('mesaj') || '').toString().trim(),
                cinsiyet: (data.get('cinsiyet') || '').toString().trim(),
                onay: data.get('onay') !== null
            };
        };

        // --- KRITIK GUNCELLEME: Spesifik Dogrulama ---
        const validateData = (data) => {
            if (!data) return {ok: false, message: 'Form bulunamadı.'};

            // Her alan için tek tek kontrol ve özel mesaj
            if (!data.ad) return {ok: false, message: 'Lütfen ad ve soyadınızı giriniz.'};
            if (!data.email) return {ok: false, message: 'E-posta adresi boş bırakılamaz.'};
            if (!emailRegex.test(data.email)) return {ok: false, message: 'Girdiğiniz e-posta formatı geçersiz.'};
            if (!data.konu) return {ok: false, message: 'Lütfen mesajınız için bir konu belirtin.'};
            if (!data.mesaj) return {ok: false, message: 'Mesaj metni alanı boş olamaz.'};
            if (!data.cinsiyet) return {ok: false, message: 'Lütfen cinsiyet seçimi yapınız.'};
            if (!data.onay) return {ok: false, message: 'Verilerinizin işlenmesi için onay vermelisiniz.'};

            return {ok: true, message: 'Kontrol başarılı.'};
        };

        const form = ref({
            ad: '', email: '', konu: '', mesaj: '', cinsiyet: '', onay: false
        });

        const temizle = () => {
            if (confirm("Formu temizlemek istediğinize emin misiniz?")) {
                form.value = {ad: '', email: '', konu: '', mesaj: '', cinsiyet: '', onay: false};
            }
        };

        // Vue.js Butonu için
        const vueDenetle = () => {
            const result = validateData(form.value);
            if (!result.ok) {
                alert(`${result.message} (Vue.js Denetimi)`);
                return false;
            }
            alert('Tebrikler! Vue.js denetimi başarılı.');
            return true;
        };

        // Native JS Butonu için
        const jsDenetle = () => {
            const result = validateData(readFormData());
            alert(result.ok ? 'Başarılı: Native JS denetimi geçti.' : `${result.message} (Native JS Denetimi)`);
            return result.ok;
        };

        const gonder = () => {
            // Önce Vue denetimini yap
            if (!vueDenetle()) return;

            // Session tabanlı CSRF: token zaten PHP'den form içine yerleştirilmiş
            // Başka bir işlem yapılmasına gerek yok, form doğal olarak gönderiliyor

            // Formu PHP'ye fırlat
            document.getElementById('iletisimFormu')?.submit();
        };

        // JS Butonuna event listener ekle
        // DOM yüklendikten sonra çalışması için küçük bir bekleme
        setTimeout(() => {
            const jsBtn = document.getElementById('js-denetle-btn');
            if (jsBtn) {
                jsBtn.onclick = jsDenetle;
            }
        }, 100);

        // iletisim.js: Session tabanlı CSRF Token
        // Token zaten PHP'nin iletisim.php sayfasından form içine yerleştirilmiş
        // Client-side token üretimi artık gerekli değil

        return {form, gonder, temizle, vueDenetle};
    }
}).mount('#app');