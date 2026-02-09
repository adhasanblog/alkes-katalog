// eslint.config.js
export default [
  {
    ignores: [
      "vendor/**",
      "node_modules/**",
      "assets/dist/**",
      "assets/dist/.vite/**",
      "assets/src/.vite/**",
    ],
  },
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
