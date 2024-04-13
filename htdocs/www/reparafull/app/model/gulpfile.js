const { src, dest, watch, series, parallel } = require('gulp')
const autoprefixer = require('gulp-autoprefixer')
const sourcemaps = require('gulp-sourcemaps')
const liveServer = require('live-server')
const cleanCSS = require('gulp-clean-css')
const concat = require('gulp-concat')
const rename = require('gulp-rename')
const uglify = require('gulp-uglify')
const filter = require('gulp-filter')
const clean = require('gulp-clean')
const data = require('gulp-data')
const sass = require('gulp-sass')
const twig = require('gulp-twig')
const all = require('gulp-all')
const fs = require('fs')

// Copy required modules from 'node_modules' to 'plugins'
function pluginsTask() {
  return all(
    // Bootstrap
    src('node_modules/bootstrap/dist/css/**/*').pipe(dest('plugins/bootstrap/css')),
    src('node_modules/bootstrap/dist/js/**/*').pipe(dest('plugins/bootstrap/js')),

    // jQuery
    src([
      'node_modules/jquery/dist/jquery.js',
      'node_modules/jquery/dist/jquery.min.js'
    ]).pipe(dest('plugins/jquery')),

    // Perfect Scrollbar
    src('node_modules/perfect-scrollbar/css/perfect-scrollbar.css').pipe(dest('plugins/perfect-scrollbar'))
      .pipe(cleanCSS()).pipe(rename({ suffix: '.min' })).pipe(dest('plugins/perfect-scrollbar')),
    src(['node_modules/perfect-scrollbar/dist/perfect-scrollbar.js', 'node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js'])
      .pipe(dest('plugins/perfect-scrollbar')),

    // Swiper
    src(['node_modules/swiper/dist/css/swiper.css', 'node_modules/swiper/dist/css/swiper.min.css']).pipe(dest('plugins/swiper')),
    src(['node_modules/swiper/dist/js/swiper.js', 'node_modules/swiper/dist/js/swiper.min.js']).pipe(dest('plugins/swiper')),

    // Font Awesome
    src('node_modules/font-awesome/css/**/*').pipe(dest('plugins/font-awesome/css')),
    src('node_modules/font-awesome/fonts/**/*').pipe(dest('plugins/font-awesome/fonts')),

    // noUiSlider
    src('node_modules/nouislider/distribute/**/*').pipe(dest('plugins/nouislider')),

    // Raty Fa
    src('node_modules/raty-fa/lib/jquery.raty-fa.js').pipe(dest('plugins/raty-fa'))
      .pipe(uglify()).pipe(rename({ suffix: '.min' })).pipe(dest('plugins/raty-fa')),

    // Photoswipe
    src('node_modules/photoswipe/dist/photoswipe.css').pipe(dest('plugins/photoswipe')).pipe(cleanCSS()).pipe(rename({ suffix: '.min' })).pipe(dest('plugins/photoswipe')),
    src('node_modules/photoswipe/dist/default-skin/*.*').pipe(dest('plugins/photoswipe/photoswipe-default-skin')),
    src('node_modules/photoswipe/dist/default-skin/default-skin.css').pipe(cleanCSS()).pipe(rename({ suffix: '.min' })).pipe(dest('plugins/photoswipe/photoswipe-default-skin')),
    src(['node_modules/photoswipe/dist/photoswipe.js', 'node_modules/photoswipe/dist/photoswipe.min.js']).pipe(dest('plugins/photoswipe')),
    src(['node_modules/photoswipe/dist/photoswipe-ui-default.js', 'node_modules/photoswipe/dist/photoswipe-ui-default.min.js']).pipe(dest('plugins/photoswipe')),

    // Card (credit card for checkout)
    src('node_modules/card/dist/card.css').pipe(dest('plugins/card'))
      .pipe(cleanCSS()).pipe(rename({ suffix: '.min' })).pipe(dest('plugins/card')),
    src(['node_modules/card/dist/card.js', 'node_modules/card/dist/jquery.card.js']).pipe(dest('plugins/card'))
      .pipe(uglify()).pipe(rename({ suffix: '.min' })).pipe(dest('plugins/card'))
  )
}

// REQUIRED VENDOR CSS: FONT, BOOTSTRAP, FONTAWESOME, PERFECT-SCROLLBAR  -->
function vendorTask() {
  return src('src/scss/vendor.scss')
    .pipe(sourcemaps.init())
    .pipe(sass({ outputStyle: 'expanded' }).on('error', sass.logError)) // compile scss
    .pipe(autoprefixer({ cascade: false })) // autoprefix using 'browserslist' from package.json file
    .pipe(sourcemaps.write('.')) // write sourcemap
    .pipe(dest('dist/css')) // move to dist/css
    .pipe(cleanCSS({level: {1: {specialComments: 0}}})).pipe(rename({ suffix: '.min' })) // minify & rename
    .pipe(filter(['**', '!dist/css/vendor.css.min.map'])) // ignore minified sourcemap
    .pipe(dest('dist/css')) // move minified result
}

// Compile 'twig' to 'html'
function htmlTask() {
  return src('src/twig/[^_]*.twig')
    .pipe(data(function () {
      return JSON.parse(fs.readFileSync('src/twig/data.json'))
    }))
    .pipe(twig())
    .pipe(dest('html'))
}

// Compile 'scss' to 'css'
function cssTask() {
  return src('src/scss/style.scss')
    .pipe(sourcemaps.init())
    .pipe(sass({ outputStyle: 'expanded' }).on('error', sass.logError)) // compile scss
    .pipe(autoprefixer({ cascade: false })) // autoprefix using 'browserslist' from package.json file
    .pipe(sourcemaps.write('.')) // write sourcemap
    .pipe(dest('dist/css')) // move to dist/css
    .pipe(cleanCSS({level: {1: {specialComments: 0}}})).pipe(rename({ suffix: '.min' })) // minify & rename
    .pipe(filter(['**', '!dist/css/style.css.min.map'])) // ignore minified sourcemap
    .pipe(dest('dist/css')) // move minified result
}

// Concat js
function jsTask() {
  return src('src/js/*.js')
    .pipe(concat('script.js')) // concat
    .pipe(dest('dist/js/'))
    .pipe(uglify()).pipe(rename({ suffix: '.min' })).pipe(dest('dist/js')) // minify & rename
}

// Clean
function cleanTask() {
  return src(['plugins', 'dist', 'html'], { read: false, allowEmpty: true })
    .pipe(clean())
}

// Watch changes
function watchTask() {
  watch(['src/scss/vendor.scss', 'src/scss/_variables-vendor.scss'], vendorTask)
  watch('src/twig/data.json', htmlTask)
  watch('src/twig/*.twig', htmlTask)
  watch(['src/scss/*.scss', '!src/scss/vendor.scss'], cssTask)
  watch('src/js/*.js', jsTask)
}

function serveTask() {
  liveServer.start({
    watch: [
      'dist/css/vendor.min.css',
      'dist/css/style.min.css',
      'dist/js/script.min.js',
      'html/*.html',
      'docs/*.html'
    ]
  })
  // if you use Windows, and experience random reload issue while using live-server,
  // please open cmd as Administrator, and run the following command
  // "fsutil behavior set disablelastaccess 1" without quotes
  // then restart your computer
  // Ref: https://github.com/nodejs/node/issues/21643
}

exports.plugins = pluginsTask
exports.watch = parallel(serveTask, watchTask)
exports.default = series(cleanTask, pluginsTask, vendorTask, htmlTask, cssTask, jsTask)
