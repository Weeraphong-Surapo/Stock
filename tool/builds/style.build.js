const log = require('fancy-log')
const sass = require('gulp-sass')(require('sass'))
const helpers = require('../helpers')
const rtlcss = require('gulp-rtlcss')
const sourcemaps = require('gulp-sourcemaps')
const merge = require('merge-stream')
const gulpif = require('gulp-if')
const rename = require("gulp-rename")
const concat = require('gulp-concat')
const cleanCSS = require('gulp-clean-css')
const { src, dest } = require('gulp')
const { sassConfig } = require('../configs/sass.config')
const { cleanCSSConfig } = require('../configs/clean-css.config')
const { sourcemapsConfig } = require('../configs/sourcemaps.config')

const config = helpers.getConfig()

// Pre proceess for style build task
function preProcess(input, output, browserSync) {
  let process = src(input, { base: config.path.src })
    .pipe(gulpif(config.sourcemaps, sourcemaps.init()))
    .pipe(sass(sassConfig).on('error', function(err) {
      // Send notification to Browser Sync
      if (browserSync) {
        browserSync.notify('Error while running build styles, check the terminal')
      }

      // Logging error messages
      log(err.messageFormatted);

      // End the task
      this.emit('end')
    }))
    .pipe(concat(output))

  return process
}

// Post proceess for style build task
function postProcess(process, browserSync) {
  process
    .pipe(gulpif(config.sourcemaps, sourcemaps.write('./', sourcemapsConfig)))
    .pipe(dest(config.path.dist_build_styles))
  
  if (browserSync) {
    process.pipe(browserSync.stream())
  }

  return process
}

// Function to run build process
function buildStyle(input, output, browserSync) {
  const process = preProcess(input, output, browserSync)

  // Process for LTR CSS
  let processLTR = process
    .pipe(gulpif(config.production, cleanCSS(cleanCSSConfig)))
    .pipe(rename({ prefix: 'ltr-' }))

  processLTR = postProcess(processLTR, browserSync)

  // Process for RTL CSS
  let processRTL = process
    .pipe(rtlcss())
    .pipe(gulpif(config.production, cleanCSS(cleanCSSConfig)))
    .pipe(rename({ prefix: 'rtl-' }))

  processRTL = postProcess(processRTL, browserSync)
  
  return merge([processLTR, processRTL])
}

exports.buildStyle = buildStyle