import fs from "fs";
import path from "path";

const ROOT = process.cwd();

// scan targets
const targets = [
    { dir: "inc", exts: [".php"], patterns: [/var_dump\s*\(/, /print_r\s*\(/, /error_log\s*\(/] },
    { dir: "template-parts", exts: [".php"], patterns: [/var_dump\s*\(/, /print_r\s*\(/, /error_log\s*\(/] },
    { dir: "assets/src", exts: [".js"], patterns: [/console\.log\s*\(/, /console\.debug\s*\(/, /\bdebugger\b/] },
];

const skipDirs = new Set(["node_modules", "vendor", "assets/dist"]);

function walk(dir) {
    const out = [];
    if (!fs.existsSync(dir)) return out;
    for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
        const p = path.join(dir, entry.name);
        if (entry.isDirectory()) {
            if (skipDirs.has(entry.name)) continue;
            out.push(...walk(p));
        } else {
            out.push(p);
        }
    }
    return out;
}

let failed = false;

for (const t of targets) {
    const base = path.join(ROOT, t.dir);
    const files = walk(base).filter((f) => t.exts.includes(path.extname(f)));
    for (const f of files) {
        const content = fs.readFileSync(f, "utf8");
        for (const re of t.patterns) {
            if (re.test(content)) {
                console.error(`❌ Debug pattern ${re} found in: ${path.relative(ROOT, f)}`);
                failed = true;
            }
        }
    }
}

if (failed) process.exit(1);
console.log("✅ No debug statements found.");
