function setDisabled(el, disabled) {
    if (!el) return;
    if (disabled) {
        el.dataset.disabled = "1";
        el.setAttribute("aria-disabled", "true");
        el.classList.add("pointer-events-none", "opacity-60");
    } else {
        delete el.dataset.disabled;
        el.removeAttribute("aria-disabled");
        el.classList.remove("pointer-events-none", "opacity-60");
    }
}

function normalizeWaText(text) {
    let t = String(text || "");
    t = t.replace(/\r\n/g, "\n").replace(/\r/g, "\n");
    t = t.replace(/[\u200B-\u200D\u2060\uFEFF]/g, ""); // zero-width
    t = t.replace(/[\u0000-\u0008\u000B\u000C\u000E-\u001F\u007F]/g, ""); // control chars
    t = t.replace(/\u00A0/g, " "); // nbsp
    t = t.replace(/\*/g, ""); // buang bintang nyasar
    t = t.replace(/[^\p{L}\p{N}\p{M}\n\t .,;:()\-_/+@#&%!?'"“”‘’\[\]]/gu, "");
    t = t.split("\n").map(l => l.replace(/[ \t]+$/g, "")).join("\n");
    return t.trim();
}

function buildMessageGeneral() {
    return [
        "Halo, saya ingin konsultasi produk alkes.",
        "",
        "Kebutuhan:",
        "- Jenis fasilitas:",
        "- Lokasi pengiriman:",
        "- Budget kisaran:",
        "- Produk yang diminati (jika ada):",
        "",
        "Terima kasih."
    ].join("\n");
}

function buildMessageProduct(product, url) {
    const lines = [
        "Halo, saya ingin tanya produk berikut:",
        "",
        `Produk: ${product || ""}`,
    ];
    if (url) lines.push(`Link: ${url}`);
    lines.push("");
    lines.push("Mohon info harga, stok, dan estimasi pengiriman. Terima kasih.");
    return lines.join("\n").trim();
}

function getBoxEls(box) {
    const textarea = box.querySelector("[data-wa-message]");
    const btn = box.querySelector("[data-wa-send]");
    const status = box.querySelector("[data-wa-status]");
    return {textarea, btn, status};
}

function initBoxState(box) {
    const {textarea, btn, status} = getBoxEls(box);
    if (!textarea || !btn) return;

    // simpan default per box
    box.dataset.waDefaultText = normalizeWaText(textarea.value);
    box.dataset.waTouched = "0";

    syncButton(box);
    if (status && box.getAttribute("data-wa-require-change") === "1") {
        status.textContent = "Tambahkan minimal 1 detail untuk mengirim pesan.";
    }
}

function syncButton(box) {
    const {textarea, btn, status} = getBoxEls(box);
    if (!textarea || !btn) return;

    const requireChange = box.getAttribute("data-wa-require-change") === "1";
    const current = normalizeWaText(textarea.value);
    const def = box.dataset.waDefaultText || "";

    if (!current) {
        setDisabled(btn, true);
        if (status) status.textContent = "Isi pesan dulu sebelum mengirim.";
        return;
    }

    if (requireChange && current === def) {
        setDisabled(btn, true);
        if (status) status.textContent = "Tambahkan minimal 1 detail untuk mengirim pesan.";
        return;
    }

    setDisabled(btn, false);
    if (status) status.textContent = "";
}

function pickTargetBox(trigger) {
    // Prioritas:
    // 1) data-wa-target selector (kalau kamu butuh spesifik)
    // 2) box terdekat di DOM
    // 3) box pertama di halaman
    const sel = trigger.getAttribute("data-wa-target");
    if (sel) {
        const target = document.querySelector(sel);
        if (target && target.matches("[data-wa-box]")) return target;
    }

    const nearest = trigger.closest("main, body")?.querySelector?.("[data-wa-box]");
    if (nearest) return nearest;

    return document.querySelector("[data-wa-box]");
}

function setBoxMessage(box, nextValue, opts = {}) {
    const {textarea} = getBoxEls(box);
    if (!textarea) return;

    const {
        setAsDefault = true, // default: jadi baseline
        resetTouched = true,
    } = opts;

    textarea.value = nextValue;

    if (setAsDefault) {
        box.dataset.waDefaultText = normalizeWaText(nextValue);
    }

    if (resetTouched) {
        box.dataset.waTouched = "0";
    }

    textarea.dispatchEvent(new Event("input", {bubbles: true}));
    textarea.focus({preventScroll: true});
}


function buildWaUrl(number, text) {
    const ua = navigator.userAgent || "";
    const isMobile = /Android|iPhone|iPad|iPod/i.test(ua);

    if (isMobile) {
        return `https://wa.me/${encodeURIComponent(number)}?text=${encodeURIComponent(text)}`;
    }
    return `https://web.whatsapp.com/send?phone=${encodeURIComponent(number)}&text=${encodeURIComponent(text)}`;
}

export function initCTAHandler() {
    // init semua box
    document.querySelectorAll("[data-wa-box]").forEach(initBoxState);

    // track touched + sync disable
    document.addEventListener("input", (e) => {
        const textarea = e.target.closest?.("[data-wa-message]");
        if (!textarea) return;
        const box = textarea.closest("[data-wa-box]");
        if (!box) return;

        // kalau user mengetik, tandai touched
        box.dataset.waTouched = "1";
        syncButton(box);
    });

    // handle trigger (product/general)
    document.addEventListener("click", (e) => {
        const trigger = e.target.closest?.("[data-wa-trigger]");
        if (!trigger) return;

        e.preventDefault();

        const box = pickTargetBox(trigger);
        if (!box) return;

        const mode = (trigger.getAttribute("data-wa-mode") || "general").trim().toLowerCase();
        const product = (trigger.getAttribute("data-wa-product") || "").trim();
        const url = (trigger.getAttribute("data-wa-url") || "").trim();

        // kalau user sudah edit manual, jangan ditimpa
        if (box.dataset.waTouched === "1") {
            const {textarea} = getBoxEls(box);
            textarea?.focus?.({preventScroll: true});
            return;
        }

        if (mode === "product") {
            setBoxMessage(box, buildMessageProduct(product, url), {setAsDefault: false});
        } else {
            setBoxMessage(box, buildMessageGeneral(), {setAsDefault: true});
        }

        // scroll ke box kalau perlu
        box.scrollIntoView?.({behavior: "smooth", block: "start"});
    });

    // handle send
    document.addEventListener("click", (e) => {
        const btn = e.target.closest?.("[data-wa-send]");
        if (!btn) return;

        const box = btn.closest("[data-wa-box]");
        if (!box) return;

        const {textarea, status} = getBoxEls(box);
        if (!textarea) return;

        if (btn.dataset.disabled === "1") {
            e.preventDefault();
            return;
        }

        const number = (box.getAttribute("data-wa-number") || "").trim();
        if (!number) return;

        const text = normalizeWaText(textarea.value);
        if (!text) {
            e.preventDefault();
            setDisabled(btn, true);
            if (status) status.textContent = "Isi pesan dulu sebelum mengirim.";
            return;
        }

        btn.setAttribute("href", buildWaUrl(number, text));

        // cooldown (opsional)
        const COOLDOWN_MS = 5000;
        setDisabled(btn, true);
        let remain = Math.ceil(COOLDOWN_MS / 1000);
        if (status) status.textContent = `Tunggu ${remain} detik...`;

        const timer = setInterval(() => {
            remain -= 1;
            if (remain <= 0) {
                clearInterval(timer);
                syncButton(box);
            } else if (status) {
                status.textContent = `Tunggu ${remain} detik...`;
            }
        }, 1000);
    });
}
