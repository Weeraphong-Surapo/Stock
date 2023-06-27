const helpers = require('../helpers')

const config = helpers.getConfig()

// SASS configuration
const sassConfig = {
  outputStyle: config.sass_output_style,
  includePaths: [
    'node_modules/',
    'src/build/'
  ]
}

exports.sassConfig = sassConfig
