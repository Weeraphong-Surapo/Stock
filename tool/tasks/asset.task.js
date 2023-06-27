
const del = require('del')
const helpers = require('../helpers')
const assetBuilder = require('../builds/asset.build')

const config = helpers.getConfig()

// Task to delete all assets
function clean() {
  // Delete all assets on distribution directory
  return del(config.path.dist)
}

// Task to build assets
function assets(done, browserSync) {
  let assets = []

  // Asset types what will be builded
  const assetTypes = ['fonts']

  // Get all 3rd-party assets
  const assetPackageData = helpers.getAssets(assetTypes)

  // Add asset from template source assets
  assets.push({
    input: `${config.path.src_assets}/**/*`,
    output: config.path.dist_assets
  })

  // Loop all 3rd-party assets
  for (let [packageName, paths] of Object.entries(assetPackageData.packages)) {
    assetTypes.forEach(assetType => {
      // Add each 3rd-party assets
      assets.push({
        input: paths[assetType],
        output: `${config.path.dist_assets}/${assetType}/${packageName}`
      })
    })
  }

  return assetBuilder.buildAssets(assets, browserSync)
}

exports.clean = clean
exports.assets = assets
