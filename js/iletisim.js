const {createApp, ref} = Vue;

createApp({
    setup() {
        // Form verilerini reaktif bir nesne olarak tanımlıyoruz
        const form = ref({
            ad: '',
            email: '',
            konu: '',
            mesaj: ''
        });

        // Formun başarıyla gönderilip gönderilmediğini kontrol eden durum
        const gonderildi = ref(false);

        // Formu temizleme fonksiyonu
        const temizle = () => {
            form.value = {
                ad: '',
                email: '',
                konu: '',
                mesaj: ''
            };
            gonderildi.value = false;
        };

        const gonder = () => {
            fetch('php/iletisim.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(form.value)
            })
                .then(response => {
                    console.log('Response Status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response Data:', data);
                    if (data.status === "success") {
                        gonderildi.value = true; // HTML'deki yeşil uyarıyı tetikler
                        temizle(); // Formu sıfırlar
                        console.log('Form başarıyla gönderildi');
                    } else {
                        console.error('Server hatası:', data.message);
                    }
                })
                .catch((error) => {
                    console.error('Fetch Hatası:', error);
                    alert('Bir hata oluştu: ' + error.message);
                });
        };
        return {
            form,
            gonder,
            temizle,
            gonderildi
        };
    }
}).mount('#app');