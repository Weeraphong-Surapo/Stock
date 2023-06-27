const helpers = require('../helpers')

const config = helpers.getConfig()

// Browser Sync configuration
const browserSyncConfig = {
  server: {
    baseDir: config.path.dist,
    index: "index.html",
    routes: {
      '/src': config.path.src
    }
  },
  startPath: "/index.html",
  open: true,
  port: config.port,
  ui: {
    port: config.port + 1
  },
  watchOptions: {
    ignoreInitial: true
  },
  logPrefix: "BlueUpCode",
  ghostMode: false,
  timestamps: false
}

exports.browserSyncConfig = browserSyncConfig