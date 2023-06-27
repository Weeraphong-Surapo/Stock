const helpers = require('../helpers')

const config = helpers.getConfig()

// Uglify configuration for production & development settings
const uglifyConfigs = {
  dev: {
    compress: false,
    mangle: false,
    toplevel: false,
    keep_fnames: true
  },
  prod: {
    compress: true,
    mangle: true,
    toplevel: true,
    keep_fnames: false
  }
}

// Function to get Uglify configuration
function getUglifyConfig() {
  return uglifyConfigs[config.production ? 'prod' : 'dev']
}

exports.uglifyConfigs = uglifyConfigs
exports.uglifyConfig = getUglifyConfig()