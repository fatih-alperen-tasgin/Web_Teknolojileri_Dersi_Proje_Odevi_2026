# FatEnTa | Kişisel Portfolyo ve Şehir Rehberi

Bu proje, Sakarya Üniversitesi Bilgisayar Mühendisliği eğitimi kapsamında geliştirilen; temiz kod (clean code) prensiplerini, modüler mimariyi ve sistem güvenliğini odağına alan profesyonel bir web çalışmasıdır.

## 🚀 Proje Özeti

Proje, sürdürülebilir bir dosya yapısı üzerine inşa edilmiştir. Kişisel bir özgeçmiş sunumu ve Erzurum şehri için hazırlanan etkileşimli bir rehberden oluşmaktadır.

### Mimari Özellikler
- **Modüler Yapı:** Navbar ve Footer bölümleri JavaScript (`navbar-loader.js`) ile çalışma zamanında (runtime) yüklenerek kod tekrarı önlenmiştir.
- **Dinamik UX:** Şehir sayfasında ekran yüksekliğine duyarlı (85vh / 400px) slider ve merkezi bir Lightbox (modal) sistemi entegre edilmiştir.
- **Görsel Optimizasyon:** `object-fit: cover` ve `object-position` teknikleriyle farklı en-boy oranlarına sahip görsellerin bütünlüğü korunmuştur.
- **Güvenlik:** Dış bağlantılarda `rel="noopener noreferrer"` standartları uygulanmış ve ASCII kod dökümantasyonu benimsenmiştir.

## 🛠️ Kullanılan Teknolojiler

- **Frontend:** HTML5, CSS3, JavaScript (ES6+)
- **Framework:** Bootstrap 5.3
- **İkonografi:** FontAwesome 6.x & SVG Sprite System
- **Standartlar:** `.github/copilot-instructions.md` kurallarına göre normalize edilmiştir.

## ⚙️ Kurulum ve Yayına Alma

1. Projeyi klonlayın: `git clone https://github.com/fatih-alperen-tasgin/repository-adi.git`
2. WebStorm üzerinden `index.html` dosyasını bir yerel sunucu ile çalıştırın.
3. Canlı önizleme için GitHub Pages veya Vercel kullanılmıştır.

## 📝 Mühendislik Notları

Proje geliştirme sürecinde, kodun sadece çalışmasına değil, okunabilirliğine ve bakım maliyetinin düşük olmasına (maintainability) odaklanılmıştır. Gereksiz yorum satırlarından arındırılmış "Clean Code" versiyonu ana dizinde, detaylı eğitim notları ise `/notlar` klasöründe yer almaktadır.