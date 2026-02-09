/** @type {import('tailwindcss').Config} */
import typography from '@tailwindcss/typography'

export default {
	content: [
		"./*.php",
		"./**/*.php",
		"./template-parts/**/*.php",
		"./inc/**/*.php",
		"./assets/src/js/**/*.js",
		],
		safelist: [
		/* =========================
		 * LAYOUT & SPACING
		 * ========================= */
		{
			pattern: /(container|not-prose|max-w-(sm|md|lg|xl|2xl|3xl|4xl)|mx-auto)/,
	},
		{
			pattern: /(p|px|py|pt|pb|pl|pr|m|mx|my|mt|mb|ml|mr)-[0-9]+/,
			variants: ["sm", "md", "lg"],
	},

		/* =========================
		 * FLEX & GRID
		 * ========================= */
		{
			pattern: /(flex|inline-flex|grid|items-(start|center|end)|justify-(start|center|between|end)|gap-[0-9]+)/,
			variants: ["sm", "md", "lg"],
	},
		{
			pattern: /grid-cols-[1-6]/,
			variants: ["sm", "md", "lg"],
	},

		/* =========================
		 * TYPOGRAPHY
		 * ========================= */
		{
			pattern: /(text|font)-(xs|sm|base|lg|xl|2xl|3xl|4xl|5xl|bold|semibold|medium)/,
	},
		{
			pattern: /text-(slate|gray|white|black)-(100|200|300|400|500|600|700|800|900)/,
	},
		{
			pattern: /(leading|tracking)-(tight|normal|wide|relaxed)/,
	},

		/* =========================
		 * BACKGROUND & BORDER
		 * ========================= */
		{
			pattern: /bg-(white|black|slate|gray)-(50|100|200|300|400|500|600|700|800|900)/,
	},
		{
			pattern: /(border|ring)-(slate|gray|black)(\/[0-9]+)?/,
	},
		{
			pattern: /(rounded)-(sm|md|lg|xl|2xl|3xl|full)/,
	},

		/* =========================
		 * EFFECTS
		 * ========================= */
		{
			pattern: /(shadow|ring)-(sm|md|lg|xl|2xl)?/,
	},
		{
			pattern: /(hover|group-hover):(bg|text|shadow|ring)-/,
	},
		{
			pattern: /(transition|duration|ease)-(all|colors|transform|[0-9]+)/,
	},

		/* =========================
		 * PROSE (TYPOGRAPHY PLUGIN)
		 * ========================= */
		{
			pattern: /prose(-slate)?/,
			variants: ["sm", "md", "lg"],
	},
	],
	theme: {
		extend: {},
	},
	plugins: [
		typography,
	],
	};
