const helpers = require('../helpers')
const pageBuilder = require('../builds/page.build')

const config = helpers.getConfig()

// Task to build pages
function buildPage(done, browserSync, direction = config.direction) {
  // Define all variables needed
  const pageBasePath = `${config.path.src_pages}/public/`
  const pageInput = `${pageBasePath}**/*.njk`
  const pageOutput = config.path.dist_pages
  
  return pageBuilder.buildPage(pageBasePath, pageInput, pageOutput, direction, browserSync)
}

// Task to build LTR pages
function buildPageLTR(done, browserSync) {
  return buildPage(done, browserSync, "ltr")
}

// Task to build RTL pages
function buildPageRTL(done, browserSync) {
  return buildPage(done, browserSync, "rtl")
}

exports.buildPage = buildPage
exports.buildPageLTR = buildPageLTR
exports.buildPageRTL = buildPageRTL