const helpers = require('../helpers')

const config = helpers.getConfig()

// Sourcemaps configuration
const sourcemapsConfig = {
  sourceRoot: `/${config.path.src}`,
  includeContent: false
}

exports.sourcemapsConfig = sourcemapsConfig
