const traverse = require('traverse')
const colors = require('colors')
const glob = require('glob')
const log = require('fancy-log')
const fs = require('fs')

// Function to parse config file
const parseConfig = path => {
  // Get config file by path parameter
  let file = fs.readFileSync(path)

  // Parse data from the file loaded
  return JSON.parse(file)
}

// Function to get buildable assets
const getBuild = (part, allow) => {

  // Parse configugarion
  const config = parseConfig('config.json')

  // Get configuration
  const libs = {
    core: config.build.core,
    mandatory: config.build.vendors.mandatory,
    optional: config.build.vendors.optional
  }
  const skip = config.config.skip
  const allowed = ['scripts', 'styles']

  // Parameter validation
  allow = allow.filter(type => {
    return allowed.includes(type)
  })

  return traverse(libs[part]).reduce(function(result, package) {
    if (allow.includes(this.key)) {

      let name = this.parent.key
      let path = this.path
      let type = this.key

      if (part === 'optional' && skip.includes(name)) {
        if (!result.skip.includes(name)) {
          result.skip.push(name)
        }
      } else {
        if (package.hasOwnProperty('watch') || package.hasOwnProperty('compile')) {

          Object.keys(package).forEach(category => {
            package[category].forEach(pattern => {
              let links = glob.sync(pattern)

              if (links.length > 0) {
                result[category][type].push(pattern)
              } else {
                log(`${colors.red(pattern)} not found`)
                result.notFound.push(pattern)
              }
            })
          })

        } else {

          package.forEach(pattern => {
            let links = glob.sync(pattern)

            if (links.length > 0) {
              result.watch[type].push(pattern)
              result.compile[type].push(pattern)
            } else {
              log(`${colors.red(pattern)} not found`)
              result.notFound.push(pattern)
            }
          })

        }
      }
    }
    return result
  }, {
    notFound: [],
    skip: [],
    compile: {
      scripts: [],
      styles: []
    },
    watch: {
      scripts: [],
      styles: []
    }
  })
}

// Function to get assets to copy
const getAssets = allow => {

  // Defines all variables needed
  const config = parseConfig('config.json')
  const libs = config.build
  const skip = config.config.skip
  const allowed = ['fonts']

  // Parameter validation
  allow = allow.filter(type => {
    return allowed.includes(type)
  })

  return traverse(libs).reduce(function(result, package) {
    if (allow.includes(this.key)) {

      let name = this.parent.key
      let path = this.path
      let type = this.key

      if (path.includes('optional') && skip.includes(name)) {

        if (!result.skip.includes(name)) {
          result.skip.push(name)
        }

      } else {

        result.packages[name] = {}
        result.packages[name][type] = []

        package.forEach(pattern => {
          let links = glob.sync(pattern)

          if (links.length > 0) {

            result.packages[name][type].push(pattern)
          } else {
            log(`${colors.red(pattern)} not found`)
            result.notFound.push(pattern)
          }
        })

      }
    }
    return result
  }, {
    notFound: [],
    skip: [],
    packages: {}
  })
}

// Function to get configuration data
const getConfig = () => {
  const config = parseConfig('config.json').config
  
  config.production = process.env.PRODUCTION == "true" ? true : config.production
  config.direction = process.env.DIRECTION ? process.env.DIRECTION : config.direction
  config.sourcemaps = config.production ? false : config.sourcemaps
  config.html_beautify = config.production ? false : config.html_beautify
  
  return config
}

exports.parseConfig = parseConfig
exports.getBuild = getBuild
exports.getAssets = getAssets
exports.getConfig = getConfig
