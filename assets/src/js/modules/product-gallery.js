export function initProductGallery() {
    const mainImg = document.querySelector("[data-gallery-main]");
    const mainLink = document.querySelector("[data-gallery-main-link]");
    const thumbsWrap = document.querySelector("[data-gallery-thumbs]");
    const thumbs = document.querySelectorAll("[data-gallery-thumb]");

    if (!mainImg || !mainLink || !thumbs.length) return;

    function setActive(btn) {
        thumbs.forEach((b) => {
            b.classList.remove("ring-2", "ring-slate-900");
            b.classList.add("ring-1", "ring-black/10");
            b.setAttribute("aria-current", "false");
        });

        btn.classList.remove("ring-1", "ring-black/10");
        btn.classList.add("ring-2", "ring-slate-900");
        btn.setAttribute("aria-current", "true");
    }

    thumbs.forEach((btn) => {
        btn.addEventListener("click", () => {
            const full = btn.getAttribute("data-full");
            const alt = btn.getAttribute("data-alt") || "";

            if (!full) return;

            // update main
            mainImg.src = full;
            mainImg.alt = alt;
            mainLink.href = full;

            setActive(btn);

            // optional: keep active visible
            if (thumbsWrap) {
                btn.scrollIntoView({behavior: "smooth", inline: "nearest", block: "nearest"});
            }
        });
    });
}
