// php/get_news.php adresindeki sunucu tarafı proxy'yi çağıran istemci tarafı haber yükleyici
const apiUrl = 'php/get_news.php';

const PLACEHOLDER_IMAGE =
    "data:image/svg+xml;utf8," +
    encodeURIComponent(
        '<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="675" viewBox="0 0 1200 675">' +
        '<rect width="1200" height="675" fill="#1c2533"/>' +
        '<text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#f8f9fa" font-size="44" font-family="Arial, sans-serif">Gorsel bulunamadi</text>' +
        "</svg>"
    );

function truncate(text, maxLength) {
    if (!text) return "Aciklama mevcut degil.";
    return text.length > maxLength ? `${text.slice(0, maxLength)}...` : text;
}

function formatDate(rawDate) {
    const date = rawDate ? new Date(rawDate) : null;
    if (!date || Number.isNaN(date.getTime())) return "Tarih bilgisi yok";
    return date.toLocaleDateString("tr-TR", { year: "numeric", month: "long", day: "numeric" });
}

function createCard(article) {
    const col = document.createElement("div");
    col.className = "col-md-6 col-lg-4";

    const card = document.createElement("div");
    card.className = "card h-100 shadow-sm border-0";

    const img = document.createElement("img");
    img.className = "card-img-top";
    img.alt = "Haber";
    img.style.height = "200px";
    img.style.objectFit = "cover";
    img.src = article.image_url && article.image_url.startsWith("http") ? article.image_url : PLACEHOLDER_IMAGE;
    img.addEventListener("error", () => {
        img.src = PLACEHOLDER_IMAGE;
    });

    const body = document.createElement("div");
    body.className = "card-body d-flex flex-column";

    const title = document.createElement("h5");
    title.className = "card-title fw-bold";
    title.style.fontSize = "1.1rem";
    title.textContent = article.title || "Baslik yok";

    const desc = document.createElement("p");
    desc.className = "card-text text-muted small";
    desc.textContent = truncate(article.description || "", 100);

    const footer = document.createElement("div");
    footer.className = "mt-auto pt-2 border-top";

    const dateP = document.createElement("p");
    dateP.className = "small mb-1 text-secondary";
    dateP.textContent = `Tarih: ${formatDate(article.pubDate)}`;

    const sourceP = document.createElement("p");
    sourceP.className = "small text-secondary";
    sourceP.textContent = `Kaynak: ${(article.source_id || "Bilinmeyen").toUpperCase()}`;

    const link = document.createElement("a");
    link.className = "btn btn-sm btn-primary w-100 mt-2";
    link.target = "_blank";
    link.rel = "noopener noreferrer";
    link.href = article.link || "#";
    link.textContent = "Haberi Oku";
    if (!article.link) {
        link.classList.add("disabled");
        link.setAttribute("aria-disabled", "true");
    }

    footer.appendChild(dateP);
    footer.appendChild(sourceP);
    footer.appendChild(link);

    body.appendChild(title);
    body.appendChild(desc);
    body.appendChild(footer);

    card.appendChild(img);
    card.appendChild(body);
    col.appendChild(card);
    return col;
}

window.addEventListener("DOMContentLoaded", async () => {
    const haberDiv = document.getElementById("haberler");
    const loadingDiv = document.getElementById("loading");
    if (!haberDiv) return;

    try {
        const response = await fetch(apiUrl);
        const raw = await response.text();

        if (!response.ok) {
            if (loadingDiv) loadingDiv.remove();
            haberDiv.innerHTML = `<p class='text-danger text-center w-100'>Sunucu yanit kodu: ${response.status}</p>`;
            return;
        }

        let data;
        try {
            const clean = raw.replace(/^(\uFEFF|\xEF\xBB\xBF)/, "").trim();
            data = JSON.parse(clean);
        } catch {
            console.error("get_news: JSON parse error, raw response:", raw);
            if (loadingDiv) loadingDiv.remove();
            haberDiv.innerHTML = "<p class='text-danger text-center w-100'>Sunucudan gelen veri JSON olarak parse edilemedi. Konsolu kontrol et.</p>";
            return;
        }

        if (loadingDiv) loadingDiv.remove();

        const results = Array.isArray(data.results) ? data.results : [];
        if (results.length === 0) {
            haberDiv.innerHTML = "<p class='text-danger text-center w-100'>Uygun haber kaynagi bulunamadi.</p>";
            return;
        }

        haberDiv.innerHTML = "";
        results.slice(0, 9).forEach((haber) => {
            haberDiv.appendChild(createCard(haber));
        });
    } catch (error) {
        if (loadingDiv) loadingDiv.remove();
        const msg = error && error.message ? error.message : "Haberler yuklenirken bir hata olustu.";
        haberDiv.innerHTML = `<p class='text-danger text-center w-100'>${msg}</p>`;
        console.error("Hata:", error);
    }
});