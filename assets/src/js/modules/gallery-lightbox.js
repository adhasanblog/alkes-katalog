import {animate} from "motion";

function lockBody(lock) {
    if (lock) {
        document.documentElement.style.overflow = "hidden";
    } else {
        document.documentElement.style.overflow = "";
    }
}

export function initGalleryLightbox() {
    const gallery = document.querySelector("[data-gallery]");
    if (!gallery) return;

    const dataEl = gallery.querySelector("[data-gallery-data]");
    if (!dataEl) return;

    let images = [];
    let startIndex = 0;

    try {
        const json = JSON.parse(dataEl.textContent || "{}");
        images = Array.isArray(json.images) ? json.images : [];
        startIndex = Number.isFinite(json.start) ? json.start : 0;
    } catch {
        return;
    }
    if (!images.length) return;

    const mainImg = gallery.querySelector("[data-gallery-main]");
    const openBtn = gallery.querySelector("[data-gallery-open]");
    const thumbs = Array.from(gallery.querySelectorAll("[data-gallery-thumb]"));

    // Lightbox elements
    const lb = document.querySelector("[data-lightbox]");
    if (!lb) return;

    const overlay = lb.querySelector("[data-lightbox-overlay]");
    const panel = lb.querySelector("[data-lightbox-panel]");
    const imgEl = lb.querySelector("[data-lightbox-img]");
    const counterEl = lb.querySelector("[data-lightbox-counter]");
    const btnClose = lb.querySelector("[data-lightbox-close]");
    const btnPrev = lb.querySelector("[data-lightbox-prev]");
    const btnNext = lb.querySelector("[data-lightbox-next]");

    if (!overlay || !panel || !imgEl || !counterEl || !btnClose || !btnPrev || !btnNext) return;

    let index = Math.min(Math.max(0, startIndex), images.length - 1);
    let isOpen = false;

    function setMain(i) {
        index = i;
        if (mainImg) mainImg.src = images[index];
        thumbs.forEach((t) => {
            const ti = Number(t.getAttribute("data-index"));
            t.classList.toggle("ring-2", ti === index);
            t.classList.toggle("ring-slate-900", ti === index);
        });
    }

    function renderLightbox() {
        imgEl.src = images[index];
        counterEl.textContent = `${index + 1} / ${images.length}`;

        // hide prev/next if only 1
        const multi = images.length > 1;
        btnPrev.style.display = multi ? "" : "none";
        btnNext.style.display = multi ? "" : "none";
    }

    function open(i = index) {
        index = i;
        isOpen = true;

        lb.classList.remove("hidden");
        lb.setAttribute("aria-hidden", "false");
        lockBody(true);

        renderLightbox();

        // Animations
        animate(overlay, {opacity: [0, 1]}, {duration: 0.18, easing: "ease-out"});
        animate(panel, {opacity: [0, 1], scale: [0.98, 1], y: [10, 0]}, {duration: 0.22, easing: "ease-out"});

        // focus
        panel.focus({preventScroll: true});
    }

    function close() {
        if (!isOpen) return;
        isOpen = false;

        // Animate out then hide
        const a1 = animate(panel, {opacity: [1, 0], scale: [1, 0.98], y: [0, 10]}, {duration: 0.18, easing: "ease-in"});
        const a2 = animate(overlay, {opacity: [1, 0]}, {duration: 0.18, easing: "ease-in"});

        Promise.all([a1.finished, a2.finished]).finally(() => {
            lb.classList.add("hidden");
            lb.setAttribute("aria-hidden", "true");
            lockBody(false);
        });
    }

    function next() {
        index = (index + 1) % images.length;
        renderLightbox();
        animate(imgEl, {opacity: [0, 1], scale: [0.995, 1]}, {duration: 0.22, easing: "ease-out"});
    }

    function prev() {
        index = (index - 1 + images.length) % images.length;
        renderLightbox();
        animate(imgEl, {opacity: [0, 1], scale: [0.995, 1]}, {duration: 0.22, easing: "ease-out"});
    }

    // Bind: thumbs to switch main image (and keep index in sync)
    thumbs.forEach((t) => {
        t.addEventListener("click", () => {
            const i = Number(t.getAttribute("data-index"));
            if (!Number.isFinite(i)) return;
            setMain(i);
        });
    });

    // Click main image -> open modal
    if (openBtn) {
        openBtn.addEventListener("click", () => open(index));
    }

    // Also allow clicking main image itself if you want
    if (mainImg) {
        mainImg.style.cursor = "zoom-in";
    }

    // Lightbox controls
    overlay.addEventListener("click", close);
    btnClose.addEventListener("click", close);
    btnNext.addEventListener("click", next);
    btnPrev.addEventListener("click", prev);

    // Keyboard
    document.addEventListener("keydown", (e) => {
        if (!isOpen) return;
        if (e.key === "Escape") close();
        if (e.key === "ArrowRight") next();
        if (e.key === "ArrowLeft") prev();
    });

    // Init selection highlight
    setMain(index);
}
