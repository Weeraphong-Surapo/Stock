const pageTasks = require('./tool/tasks/page.task.js')
const assetTasks = require('./tool/tasks/asset.task.js')
const styleTasks = require('./tool/tasks/style.task.js')
const serverTask = require('./tool/tasks/server.task.js')
const scriptTasks = require('./tool/tasks/script.task.js')
const { parallel, series } = require('gulp')

exports.clean = assetTasks.clean
exports.assets = assetTasks.assets
exports.buildStyleCore = styleTasks.buildStyleCore
exports.buildStyleVendor = styleTasks.buildStyleVendor
exports.buildStyle = parallel(
  exports.buildStyleCore,
  exports.buildStyleVendor
)
exports.buildScriptCore = scriptTasks.buildScriptCore
exports.buildScriptMandatory = scriptTasks.buildScriptMandatory
exports.buildScriptVendor = scriptTasks.buildScriptVendor
exports.buildScriptApp = scriptTasks.buildScriptApp
exports.buildScript = parallel(
  exports.buildScriptCore,
  exports.buildScriptMandatory,
  exports.buildScriptVendor,
  exports.buildScriptApp
)
exports.buildPage = pageTasks.buildPage
exports.buildPageLTR = pageTasks.buildPageLTR
exports.buildPageRTL = pageTasks.buildPageRTL
exports.build = parallel(
  exports.buildStyle,
  exports.buildScript,
  exports.buildPage,
  exports.assets
)
exports.serve = serverTask.serve
exports.default = series(
  exports.clean,
  exports.build,
  exports.serve
)
