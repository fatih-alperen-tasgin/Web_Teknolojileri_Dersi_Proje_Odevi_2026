const apiKey = "pub_db90c0b2fb864522b3f272cbff4ec12e";
const apiUrl = `https://newsdata.io/api/1/news?apikey=${apiKey}&language=tr&q=galatasaray`;

window.addEventListener("DOMContentLoaded", () => {
    const haberDiv = document.getElementById("haberler");
    const loadingDiv = document.getElementById("loading");

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            if (loadingDiv) loadingDiv.remove();

            // --- KAYNAK FİLTRELEME MEKANİZMASI ---
            // Güvenilir bulduğun kaynakları buraya ekleyebilirsin
            const guvenilirKaynaklar = ["fanatik", "ntvspor", "goal", "beinsports", "aspor", "trtspor"];

            // API sonuçlarını süzüyoruz
            const filtrelenmisHaberler = data.results ? data.results.filter(haber => {
                // Şart 1: Kaynak id'si bizim listemizde var mı? (Küçük harf kontrolü ile)
                const kaynakUygun = haber.source_id && guvenilirKaynaklar.includes(haber.source_id.toLowerCase());

                // Şart 2: Görsel linki var mı?
                const gorselVar = haber.image_url && haber.image_url.startsWith('http');

                return kaynakUygun && gorselVar;
            }) : [];

            // Eğer filtreleme sonrası haber kalmazsa, sadece görseli olanları getir (B Planı)
            const sonListe = filtrelenmisHaberler.length > 0
                ? filtrelenmisHaberler
                : (data.results ? data.results.filter(h => h.image_url) : []);

            if (sonListe.length > 0) {
                // İlk 6 haberi al ve döngüye sok
                sonListe.slice(0, 6).forEach(haber => {
                    const col = document.createElement("div");
                    col.className = "col-md-6 col-lg-4";

                    // Görsel hatası durumunda kullanılacak yedek resim
                    const placeholderImg = "img/gs-placeholder.jpg";
                    const displayImg = haber.image_url ? haber.image_url : placeholderImg;

                    const tarih = new Date(haber.pubDate).toLocaleDateString("tr-TR", {
                        year: "numeric", month: "long", day: "numeric"
                    });

                    const kaynakAdi = haber.source_id ? haber.source_id.toUpperCase() : "Bilinmeyen";

                    col.innerHTML = `
                        <div class="card h-100 shadow-sm border-0">
                            <img src="${displayImg}" 
                                 class="card-img-top" 
                                 alt="Haber" 
                                 style="height: 200px; object-fit: cover;"
                                 onerror="this.onerror=null; this.src='${placeholderImg}';"> 
                            <div class="card-body d-flex flex-column text-dark">
                                <h5 class="card-title fw-bold" style="font-size: 1.1rem;">${haber.title}</h5>
                                <p class="card-text text-muted small">
                                    ${haber.description ? haber.description.substring(0, 100) + "..." : "Açıklama mevcut değil."}
                                </p>
                                <div class="mt-auto pt-2 border-top">
                                    <p class="small mb-1 text-secondary"><strong>📅</strong> ${tarih}</p>
                                    <p class="small text-secondary"><strong>🌐 Kaynak:</strong> ${kaynakAdi}</p>
                                    <a href="${haber.link}" target="_blank" class="btn btn-sm btn-primary w-100 mt-2">Haberi Oku</a>
                                </div>
                            </div>
                        </div>
                    `;
                    haberDiv.appendChild(col);
                });
            } else {
                haberDiv.innerHTML = "<p class='text-danger text-center w-100'>Uygun haber kaynağı bulunamadı.</p>";
            }
        })
        .catch(error => {
            if (loadingDiv) loadingDiv.remove();
            document.getElementById("haberler").innerHTML = "<p class='text-danger text-center w-100'>Haberler yüklenirken bir ağ hatası oluştu.</p>";
            console.error("API hatası:", error);
        });
});