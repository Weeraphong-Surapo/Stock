const helpers = require('../helpers')
const scriptBuilder = require('../builds/script.build')

const config = helpers.getConfig()

// Task to build core scripts
function buildScriptCore(done, browserSync) {
  return scriptBuilder.buildScript(
    helpers.getBuild('core', ['scripts']).compile.scripts,
    config.output.scripts.core,
    browserSync
  )
} 

// Task to build mandatory scripts
function buildScriptMandatory(done, browserSync) {
  return scriptBuilder.buildScript(
    helpers.getBuild('mandatory', ['scripts']).compile.scripts,
    config.output.scripts.mandatory,
    browserSync
  )
}

// Task to build 3rd-party scripts
function buildScriptVendor(done, browserSync) {
  return scriptBuilder.buildScript(
    helpers.getBuild('optional', ['scripts']).compile.scripts,
    config.output.scripts.vendor,
    browserSync
  )
}

// Task to build app scripts
function buildScriptApp(done, browserSync) {
  // Define all variables needed
  const scriptAppBasePath = config.path.src_app
  const scriptAppInput = `${scriptAppBasePath}/**/*`
  const scriptAppOutput = config.path.dist_app

  return scriptBuilder.buildTranspileScript(scriptAppBasePath, scriptAppInput, scriptAppOutput, browserSync)
}

exports.buildScriptCore = buildScriptCore
exports.buildScriptMandatory = buildScriptMandatory
exports.buildScriptVendor = buildScriptVendor
exports.buildScriptApp = buildScriptApp