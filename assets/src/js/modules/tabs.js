export function initTabs() {
    const buttons = document.querySelectorAll("[data-tab-btn]");
    const panels = document.querySelectorAll("[data-tab-panel]");

    if (!buttons.length || !panels.length) return;

    buttons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const targetId = btn.getAttribute("data-tab-target");

            // reset buttons
            buttons.forEach((b) => {
                b.classList.remove(
                    "border-slate-900",
                    "text-slate-900"
                );
                b.classList.add(
                    "border-transparent",
                    "text-slate-500"
                );
                b.setAttribute("aria-selected", "false");
            });

            // hide panels
            panels.forEach((p) => p.classList.add("hidden"));

            // activate current
            btn.classList.add(
                "border-slate-900",
                "text-slate-900"
            );
            btn.classList.remove(
                "border-transparent",
                "text-slate-500"
            );
            btn.setAttribute("aria-selected", "true");

            const panel = document.getElementById(targetId);
            if (panel) panel.classList.remove("hidden");
        });
    });
}
