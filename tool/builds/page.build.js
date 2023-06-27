const log = require('fancy-log')
const path = require('path')
const colors = require('colors')
const helpers = require('../helpers')
const nunjucks = require('gulp-nunjucks-render')
const gulpif = require('gulp-if')
const through = require('through2')
const htmlmin = require('gulp-htmlmin')
const beautify = require('gulp-beautify')
const { src, dest } = require('gulp')
const { HTMLMinConfig } = require('../configs/html-min.config')
const { HTMLBeautifyConfig } = require('../configs/html-beautify.config')

const config = helpers.getConfig()

// Function to build Nunjucks pages
function buildPage(basePath, input, output, direction, browserSync) {
  let prefixPath = ''

  return src(input, { base: basePath })
    .pipe(through.obj((chunk, enc, cb) => {
      // Get files prefix paths
      prefixPath = path.relative(path.dirname(chunk.relative), '')

      // Check whether prefix path is empty string, add backslash
      if (prefixPath !== '') {
        prefixPath += '/'
      }

      cb(null, chunk)
    }))
    .pipe(nunjucks({
      path: config.path.src_pages,
      manageEnv: (env) => {
        // Add custom nunjucks variables
        env.addGlobal('direction', direction)

        // Add custom nunjucks functions
        env.addGlobal('classnames', (classNames) => {
          return classNames.reduce((allowedClassNames, className) => {
            if (className.enabled) {
              return [...allowedClassNames, className.class_name]
            } else {
              return allowedClassNames
            }
          }, []).join(' ')
        })
    
        // Add custom nunjucks filters
        env.addFilter('url', actualPath => `${prefixPath}${actualPath}`)
        env.addFilter('array_push', (arr, val) => [...arr, val])
        env.addFilter('array_join', (arr, sep) => arr.join(sep))
        env.addFilter('array_concat', (arr1, arr2) => typeof arr1 === 'object' && typeof arr2 === 'object' ? [...arr1, ...arr2] : arr1)
      }
    }).on('error', function(err) {
      // Send notification to Browser Sync
      if (browserSync) {
        browserSync.notify('Error while running build pages, check the terminal')
      }

      // Logging error messages
      log(`Error at ${colors.cyan(err.fileName)}`)
      log(colors.red(err.message))

      // End the task
      this.emit('end')
    }))
    .pipe(gulpif(config.html_beautify, beautify.html(HTMLBeautifyConfig)))
    .pipe(gulpif(config.production, htmlmin(HTMLMinConfig)))
    .pipe(dest(output))
    .on('end', function() {
      // Reload Browser Sync
      if (browserSync) {
        browserSync.reload()
      }
    })
}

exports.buildPage = buildPage