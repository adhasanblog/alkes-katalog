import {animate} from "motion";

function formatIDR(n) {
    if (!n || Number.isNaN(n)) return "";
    return new Intl.NumberFormat("id-ID").format(Math.round(n));
}

function buildPriceText(price) {
    if (!price) return "Hubungi untuk harga";

    const mode = (price.display || "").toString().toLowerCase();

    if (mode === "exact" && Number(price.exact) > 0) return `Rp ${formatIDR(Number(price.exact))}`;
    if (mode === "from" && Number(price.from) > 0) return `Mulai Rp ${formatIDR(Number(price.from))}`;
    if (mode === "quote") return "Quotation (B2B)";

    return "Hubungi untuk harga";
}

function buildIzinText(izin) {
    if (!izin) return "";
    const no = (izin.no || "").toString().trim();
    const status = (izin.status || "").toString().trim();

    if (no) return `Izin edar: ${no}`;
    if (status && status.toLowerCase() !== "n/a") return `Izin edar: ${status}`;
    return "";
}

export function initHeroProductRotator() {
    const dataEl = document.getElementById("hero-products-data");
    if (!dataEl) return;

    let items = [];
    try {
        items = JSON.parse(dataEl.textContent || "[]");
    } catch (e) {
        console.warn("Invalid hero products JSON", e);
        return;
    }
    if (!Array.isArray(items) || items.length === 0) return;

    const linkEl = document.querySelector("[data-hero-link]");
    const imgEl = document.querySelector("[data-hero-image]");
    const badgeEl = document.querySelector("[data-hero-badge]");
    const titleEl = document.querySelector("[data-hero-title]");
    const priceEl = document.querySelector("[data-hero-price]");
    const izinEl = document.querySelector("[data-hero-izin]");
    const waEl = document.querySelector("[data-hero-wa]");

    if (!linkEl || !imgEl || !badgeEl || !titleEl || !priceEl || !izinEl || !waEl) return;

    let index = 0;

    const render = (p) => {
        const title = p?.title || "";
        const url = p?.url || "#";
        const img = p?.img || "";
        const badge = p?.badge || "Produk Unggulan";

        linkEl.href = url;
        imgEl.src = img;

        badgeEl.textContent = badge;

        titleEl.textContent = title;
        titleEl.href = url;

        priceEl.textContent = buildPriceText(p?.price);
        izinEl.textContent = buildIzinText(p?.izin);

        // WA bridge needs these:
        waEl.setAttribute("data-wa-mode", "product");
        waEl.setAttribute("data-wa-product", title);
        waEl.setAttribute("data-wa-url", url);

        animate(imgEl, {opacity: [0, 1], scale: [0.985, 1], y: [6, 0]}, {duration: 0.55, easing: "ease-out"});
        animate([badgeEl, titleEl, priceEl, izinEl], {opacity: [0, 1], y: [4, 0]}, {
            duration: 0.35,
            easing: "ease-out"
        });
    };


    render(items[index]);

    setInterval(() => {
        index = (index + 1) % items.length;
        render(items[index]);
    }, 5000);
}
