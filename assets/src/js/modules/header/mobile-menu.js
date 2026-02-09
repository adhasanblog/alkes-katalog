import {$, $$} from "../utils/dom";

export function initMobileMenu() {
    const btn = $("[data-mobile-menu-btn]");
    const menu = $("[data-mobile-menu]");
    if (!btn || !menu) return;

    const close = () => {
        menu.classList.add("hidden");
        btn.setAttribute("aria-expanded", "false");
    };

    const toggle = () => {
        const isOpen = !menu.classList.contains("hidden");
        if (isOpen) close();
        else {
            menu.classList.remove("hidden");
            btn.setAttribute("aria-expanded", "true");
        }
    };

    btn.addEventListener("click", toggle);

    // Close on anchor click
    $$('a[href^="#"]', menu).forEach((a) => a.addEventListener("click", close));
}
