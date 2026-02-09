import { spawnSync } from "node:child_process";

const args = ["vendor/bin/phpcbf", "--standard=phpcs.xml.dist", ...process.argv.slice(2)];
const res = spawnSync("php", args, { stdio: "inherit" });

// PHPCBF exit codes:
// 0 = no fix needed
// 1 = fixes applied
// 2+ = error
if (res.status === 0 || res.status === 1) process.exit(0);
process.exit(res.status ?? 1);
