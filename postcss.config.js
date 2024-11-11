let tailwindcss = require("tailwindcss")

module.exports = {
  plugins: [
    // tailwindcss: {},
    // autoprefixer: {},

    tailwindcss('./tailwind.config.js'),
    require('postcss-import'),
    require('autoprefixer')
  ]
}
