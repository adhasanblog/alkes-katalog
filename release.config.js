export default {
  branches: ["main"],
  tagFormat: "v${version}",
  plugins: [
    "@semantic-release/commit-analyzer",
    "@semantic-release/release-notes-generator",
    [
      "@semantic-release/changelog",
      { changelogFile: "CHANGELOG.md" }
    ],
    [
      "@semantic-release/github",
      {
        assets: [
          {
            path: "release/alkes-catalog.zip",
            name: "alkes-catalog-v${nextRelease.version}.zip",
            label: "WordPress Theme (ZIP)"
          }
        ]
      }
    ],
    [
      "@semantic-release/git",
      {
        assets: ["CHANGELOG.md"],
        message:
          "chore(release): v${nextRelease.version}\n\n${nextRelease.notes}"
      }
    ]
  ]
};
