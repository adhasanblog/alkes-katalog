export function initFaqAccordion() {
    const faqs = document.querySelectorAll("[data-faq]");
    if (!faqs.length) return;

    faqs.forEach((details) => {
        const panel = details.querySelector("[data-faq-panel]");
        const chevron = details.querySelector("[data-faq-chevron]");
        if (!panel) return;

        // Siapkan state awal
        panel.style.overflow = "hidden";

        if (!details.open) {
            panel.style.height = "0px";
            panel.style.opacity = "0";
        } else {
            panel.style.height = panel.scrollHeight + "px";
            panel.style.opacity = "1";
            chevron?.classList.add("rotate-180");
        }

        // Intercept toggle: kita animate sendiri
        details.addEventListener("toggle", () => {
            const isOpen = details.open;

            // Rotate chevron
            if (chevron) {
                chevron.classList.toggle("rotate-180", isOpen);
            }

            // Animate height
            if (isOpen) {
                // buka: dari 0 -> scrollHeight
                panel.style.transition = "height 220ms ease, opacity 220ms ease";
                requestAnimationFrame(() => {
                    panel.style.height = panel.scrollHeight + "px";
                    panel.style.opacity = "1";
                });

                // setelah selesai, set height auto supaya responsif (kalau teks wrap)
                const onEnd = (e) => {
                    if (e.propertyName !== "height") return;
                    panel.style.height = "auto";
                    panel.removeEventListener("transitionend", onEnd);
                };
                panel.addEventListener("transitionend", onEnd);
            } else {
                // tutup: dari auto/px -> 0
                panel.style.transition = "none";
                const currentHeight = panel.scrollHeight;
                panel.style.height = currentHeight + "px";
                panel.style.opacity = "1";

                requestAnimationFrame(() => {
                    panel.style.transition = "height 200ms ease, opacity 200ms ease";
                    panel.style.height = "0px";
                    panel.style.opacity = "0";
                });
            }
        });

        // UX: klik summary -> jangan scroll/jump
        const summary = details.querySelector("summary");
        summary?.addEventListener("click", (e) => {
            // biarkan default toggle berjalan, tapi cegah highlight aneh
            summary.blur?.();
        });
    });
}
