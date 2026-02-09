// eslint.config.js
export default [
	{
		files: ["assets/src/**/*.js"],
			languageOptions: {
				ecmaVersion: "latest",
				sourceType: "module",
		},
		rules: {
			"no-console": ["error", { allow: ["warn", "error"] }],
			"no-debugger": "error",
		},
	},
	];
