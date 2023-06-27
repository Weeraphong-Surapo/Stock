const log = require('fancy-log')
const colors = require('colors')
const helpers = require('../helpers')
const sourcemaps = require('gulp-sourcemaps')
const uglify = require('gulp-uglify')
const concat = require('gulp-concat')
const gulpif = require('gulp-if')
const babel = require('gulp-babel')
const { src, dest } = require('gulp')
const { uglifyConfig } = require('../configs/uglify.config')
const { sourcemapsConfig } = require('../configs/sourcemaps.config')

const config = helpers.getConfig()

// Function to build scripts
function buildScript(input, output, browserSync) {
  return src(input, { base: config.path.src })
    .pipe(gulpif(config.sourcemaps, sourcemaps.init()))
    .pipe(concat(output))
    .pipe(uglify(uglifyConfig).on('error', function(err) {
      // Send notification to Browser Sync
      if (browserSync) {
        browserSync.notify('Error while running build scripts, check the terminal')
      }

      // Logging error messages
      log(`Error: ${colors.red(err.cause.message)}`)

      // End the task
      this.emit('end')
    }))
    .pipe(gulpif(config.sourcemaps, sourcemaps.write('./', sourcemapsConfig)))
    .pipe(dest(config.path.dist_build_scripts))
    .on('end', () => {
      // Reload Browser Sync
      if (browserSync) {
        browserSync.reload()
      }
    })
}

// Function to transpile scripts
function buildTranspileScript(basePath, input, output, browserSync) {
  return src(input, { base: basePath })
    .pipe(babel({ presets: ['@babel/env'] }).on('error', function(err) {
      // Send notification to Browser Sync
      if (browserSync) {
        browserSync.notify('Error while running build scripts, check the terminal')
      }
      
      // Logging error messages
      log(err.message)

      // End the task
      this.emit('end')
    }))
    .pipe(uglify(uglifyConfig).on('error', function(err) {
      // Send notification to Browser Sync
      if (browserSync) {
        browserSync.notify('Error while running build scripts, check the terminal')
      }

      // Logging error messages
      log(`Error: ${colors.red(err.cause.message)}`)

      // End the task
      this.emit('end')
    }))
    .pipe(dest(output))
    .on('end', () => {
      // Reload Browser Sync
      if (browserSync) {
        browserSync.reload()
      }
    })
}

exports.buildScript = buildScript
exports.buildTranspileScript = buildTranspileScript