const debounce = (fn, wait = 250) => {
    let t;
    return (...args) => {
        clearTimeout(t);
        t = setTimeout(() => fn(...args), wait);
    };
};

function esc(str) {
    return String(str ?? "").replace(/[&<>"']/g, (m) => ({
        "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#039;"
    }[m]));
}

export function initNavSearch() {
    const root = document.querySelector("[data-nav-search]");
    if (!root) return;

    const input = root.querySelector("[data-search-input]");
    const boxRes = root.querySelector("[data-search-results]");
    const boxEmpty = root.querySelector("[data-search-empty]");
    const itemsEl = root.querySelector("[data-search-items]");
    const spinner = root.querySelector("[data-search-spinner]");
    const clearBtn = root.querySelector("[data-search-clear]");
    const allLink = root.querySelector("[data-search-all]");

    if (!input || !boxRes || !boxEmpty || !itemsEl || !spinner || !clearBtn) return;

    const base = `${window.location.origin}/sejahtera-alkes/wp-json/alkes/v1/search`;
    // ^ kalau install kamu bukan /sejahtera-alkes, ganti ke:
    // const base = `${window.location.origin}/wp-json/alkes/v1/search`;

    const closeAll = () => {
        boxRes.classList.add("hidden");
        boxEmpty.classList.add("hidden");
    };

    const renderItems = (rows, q) => {
        itemsEl.innerHTML = rows.map((p) => {
            const title = esc(p.title);
            const url = esc(p.url);
            const img = esc(p.thumb || "");
            const cat = esc(p.category || "");
            const price = esc(p.price_text || "");

            return `
        <a href="${url}" class="flex items-center gap-4 px-4 py-3 hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0 group/item">
          <div class="w-12 h-12 rounded-sm bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-200">
            ${img ? `<img src="${img}" alt="${title}" class="w-full h-full object-cover">` : ``}
          </div>
          <div class="flex-1 min-w-0">
            <h4 class="text-sm font-semibold text-slate-800 group-hover/item:text-slate-600 truncate">${title}</h4>
            <div class="flex items-center gap-2 mt-0.5">
              ${cat ? `<span class="text-xs text-slate-500">${cat}</span>` : ``}
              ${price ? `<span class="text-xs font-bold text-slate-800 bg-slate-100 px-1.5 py-0.5 rounded">${price}</span>` : ``}
            </div>
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-300 group-hover/item:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </a>
      `;
        }).join("");

        if (allLink) {
            allLink.classList.remove("hidden");
            allLink.href = `${window.location.origin}/sejahtera-alkes/produk/?s=${encodeURIComponent(q)}`;
            allLink.target = "_blank";
            allLink.rel = "noopener";
            allLink.textContent = `Lihat semua hasil “${q}”`;
        }
    };

    const doSearch = async (q) => {
        q = q.trim();
        if (!q) {
            spinner.classList.add("hidden");
            clearBtn.classList.add("hidden");
            closeAll();
            return;
        }

        clearBtn.classList.remove("hidden");
        spinner.classList.remove("hidden");
        closeAll();

        try {
            const url = `${base}?q=${encodeURIComponent(q)}&limit=6`;
            const res = await fetch(url, {headers: {"Accept": "application/json"}});
            const json = await res.json();

            spinner.classList.add("hidden");

            const rows = Array.isArray(json?.items) ? json.items : [];
            if (!rows.length) {
                boxEmpty.classList.remove("hidden");
                return;
            }

            renderItems(rows, q);
            boxRes.classList.remove("hidden");
        } catch (e) {
            spinner.classList.add("hidden");
            // silent fail: jangan ganggu UX
            closeAll();
        }
    };

    const debounced = debounce(doSearch, 300);

    input.addEventListener("input", () => debounced(input.value));
    input.addEventListener("focus", () => {
        if (input.value.trim()) debounced(input.value);
    });

    clearBtn.addEventListener("click", () => {
        input.value = "";
        clearBtn.classList.add("hidden");
        closeAll();
        input.focus();
    });

    document.addEventListener("click", (e) => {
        if (!root.contains(e.target)) closeAll();
    });

    // ENTER tetap submit normal (fallback)
    // (form action sudah ada)
}
