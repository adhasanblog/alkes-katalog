export function initSidebarCategories() {
    const toggles = document.querySelectorAll("[data-cat-toggle]");
    if (!toggles.length) return;

    toggles.forEach((btn) => {
        const panelId = btn.getAttribute("aria-controls");
        const panel = panelId ? document.getElementById(panelId) : null;

        // kalau parent tidak punya panel (no children), jangan toggle
        if (!panel) return;

        btn.addEventListener("click", () => {
            const isOpen = btn.getAttribute("aria-expanded") === "true";

            btn.setAttribute("aria-expanded", String(!isOpen));
            panel.classList.toggle("hidden", isOpen);

            // rotate icon
            const icon = btn.querySelector("svg");
            if (icon) icon.classList.toggle("rotate-180", !isOpen);
        });
    });
}
