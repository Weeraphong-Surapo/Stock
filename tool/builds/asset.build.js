const merge = require('merge-stream')
const { src, dest } = require('gulp')

// Function to build assets
function buildAssets(assets, browserSync) {
  // Process input assets to Gulp procesees
  const processes = assets.reduce((lastProcesses, currentAsset) => {
    // Build a Gulp process for each asset
    const currentProcess = src(currentAsset.input).pipe(dest(currentAsset.output))

    return [...lastProcesses, currentProcess]
  }, [])

  // Merge all Gulp processes
  return merge(...processes).on('end', () => {
    // Refresh Browser Sync
    if (browserSync) {
      browserSync.reload()
    }
  })
}

exports.buildAssets = buildAssets
