const {createApp, ref} = Vue;

createApp({
    setup() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

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
                sehir: (data.get('sehir') || '').toString().trim(),
                onay: data.get('onay') !== null
            };
        };

        const validateData = (data) => {
            if (!data) {
                return { ok: false, message: 'Form bulunamadı.' };
            }

            if (!data.ad || !data.email || !data.konu || !data.mesaj || !data.cinsiyet || !data.sehir) {
                return { ok: false, message: 'Lütfen tüm alanları doldurun!' };
            }

            if (!emailRegex.test(data.email)) {
                return { ok: false, message: 'Geçersiz e-posta formatı!' };
            }

            if (!data.onay) {
                return { ok: false, message: 'Lütfen verilerinizin işlenmesini onaylayın!' };
            }

            return { ok: true, message: 'Kontrol başarılı.' };
        };

        // 1. Tüm form elemanlarını içeren reaktif nesne
        const form = ref({
            ad: '',
            email: '',
            konu: '',
            mesaj: '',
            cinsiyet: '', // Radio için
            sehir: '',    // Select için
            onay: false   // Checkbox için
        });

        // 2. Formu temizleme fonksiyonu (yeni alanlar eklendi)
        const temizle = () => {
            form.value = {
                ad: '',
                email: '',
                konu: '',
                mesaj: '',
                cinsiyet: '',
                sehir: '',
                onay: false
            };
        };

        // 3. Vue.js ile Denetleme Fonksiyonu
        const vueDenetle = () => {
            const result = validateData(form.value);
            if (!result.ok) {
                alert(`${result.message} (Vue.js Denetimi)`);
                return false;
            }

            alert('Form Vue.js tarafından başarıyla denetlendi. PHP ile gönderim hazırlanıyor...');
            return true;
        };

        // 4. Native JavaScript ile Denetleme Fonksiyonu
        const jsDenetle = () => {
            const result = validateData(readFormData());
            alert(result.ok ? 'Form Native JS tarafından başarıyla denetlendi.' : `${result.message} (Native JS Denetimi)`);
            return result.ok;
        };

        const gonder = () => {
            if (!vueDenetle()) return;

            document.getElementById('iletisimFormu')?.submit();
        };

        const jsBtn = document.getElementById('js-denetle-btn');
        if (jsBtn) {
            jsBtn.addEventListener('click', jsDenetle);
        }

        // CSRF token (double-submit) oluştur ve form gizli alanına yaz
        const ensureCsrf = () => {
            try {
                const existing = document.cookie.split('; ').find(row => row.startsWith('csrf_token='));
                let token = existing ? existing.split('=')[1] : null;
                if (!token) {
                    // basit rastgele token
                    token = crypto && crypto.getRandomValues ? Array.from(crypto.getRandomValues(new Uint8Array(16))).map(b=>b.toString(16).padStart(2,'0')).join('') : (Date.now().toString(16) + Math.random().toString(16).slice(2));
                    document.cookie = `csrf_token=${token}; path=/`;
                }
                const tokenInput = document.getElementById('csrf_token');
                if (tokenInput) tokenInput.value = token;
            } catch (e) {
                // tarayıcı desteklemiyorsa sessizce geç
                console.warn('CSRF token yaratilirken hata:', e);
            }
        };

        ensureCsrf();

        return {
            form,
            gonder,
            temizle,
            vueDenetle // Butondan tetiklemek için geri döndürüyoruz
        };
    }

}).mount('#app');
