# FatEnTa | Kişisel Portfolyo ve Şehir Rehberi

> **Canlı Demo Bağlantısı:** [fatihtasgin.free.nf](https://fatihtasgin.free.nf)

Bu proje, Sakarya Üniversitesi Bilgisayar Mühendisliği eğitimi kapsamında geliştirilen; temiz kod (clean code) prensiplerini, modüler mimariyi ve sistem güvenliğini odağına alan profesyonel bir web çalışmasıdır.

---

## 🚀 Proje Özeti

Proje, sürdürülebilir bir dosya yapısı üzerine inşa edilmiştir. Kişisel bir özgeçmiş sunumu ve Erzurum şehri için hazırlanan etkileşimli bir rehberden oluşmaktadır.

### Mimari Özellikler

- **Modüler Yapı:** Navbar ve Footer bölümleri JavaScript (`navbar-loader.js`) ile çalışma zamanında (runtime) yüklenerek kod tekrarı önlenmiştir.
- **Dinamik UX:** Şehir sayfasında ekran yüksekliğine duyarlı (`85vh` / `400px`) slider ve merkezi bir Lightbox (modal) sistemi entegre edilmiştir.
- **Görsel Optimizasyon:** `object-fit: cover` ve `object-position` teknikleriyle farklı en-boy oranlarına sahip görsellerin bütünlüğü korunmuştur.
- **Güvenlik:** Dış bağlantılarda `rel="noopener noreferrer"` standartları uygulanmış ve ASCII kod dökümantasyonu benimsenmiştir.

---

## 🛠️️ Kullanılan Teknolojiler

- **Frontend:** HTML5, CSS3, JavaScript (ES6+)
- **Backend / Sunucu:** PHP
- **Framework:** Bootstrap 5.3
- **İkonografi:** FontAwesome 6.x & SVG Sprite System
- **Standartlar:** `.github/copilot-instructions.md` kurallarına göre normalize edilmiştir.

---

## ⚙️ Kurulum ve Yerel Çalıştırma

1. Projeyi klonlayın:
   ```bash
   git clone https://github.com/fatih-alperen-tasgin/Web_Teknolojileri_Dersi_Proje_Odevi_2026.git
   
2. PHP ve Apache desteği için dosyaları yerel sunucu kök dizinine (örneğin Wampserver için `c:/wamp64/www/`) taşıyın.

3. Tarayıcınızdan `http://localhost/Web_Teknolojileri_Dersi_Proje_Odevi_2026/` veya yapılandırılan sanal konak (`http://fatenta.local`) üzerinden çalıştırın.
