import {defineConfig} from "vite";
import path from "path";

export default defineConfig(
	{
		build: {
			outDir: path.resolve( __dirname, "assets/dist" ),
			emptyOutDir: true,
			manifest: true,
			rollupOptions: {
				input: {
					// CSS entry (Tailwind)
					app: path.resolve( __dirname, "assets/src/css/app.css" ),

					// JS entries (sesuaikan kebutuhan)
					global: path.resolve( __dirname, "assets/src/js/global.js" ),
					// singleProduk: path.resolve(__dirname, "assets/src/js/single-produk.js"),
					// archiveProduk: path.resolve(__dirname, "assets/src/js/archive-produk.js"),
				},
				output: {
					// Rapikan struktur dist
					entryFileNames: "js/[name].js",
					chunkFileNames: "js/chunks/[name]-[hash].js",
					assetFileNames: (assetInfo) => {
						const ext = assetInfo.name ? assetInfo.name.split( "." ).pop() : "";
						if (ext === "css") {
							return "css/[name][extname]";
						}
						return "assets/[name]-[hash][extname]";
					},
				},
			},
		},
	}
);
