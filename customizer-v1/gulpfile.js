// general processors
var gulp = require('gulp');
var sourcemaps = require('gulp-sourcemaps');
var browsersync = require('browser-sync').create();

// image processors
var imagemin = require('gulp-imagemin');

// css processors
var sass = require('gulp-sass');
var postcss = require('gulp-postcss');
var autoprefixer = require('gulp-autoprefixer');
var lost = require('lost');
var pxToRem = require('postcss-pxtorem');

/**
* Local development tasks - gulp command = 'gulp'
*/

// html tasks
gulp.task('html', function() {
   return gulp.src(['./**/*.html', '!node_modules'])
        .pipe(gulp.dest('./'))
});

// php tasks
gulp.task('php', function() {
   return gulp.src('./**/*.php')
        .pipe(gulp.dest('./'))
});


// styles tasks
gulp.task('sass', function() {
    var postProcessors = [
        lost(),
        pxToRem({
            propWhiteList: []
        })
    ];
   return gulp.src('./styles/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(postcss(postProcessors))
        .pipe(autoprefixer())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./'))
        .pipe(browsersync.stream());
});

gulp.task('admin-styles', function() {
  var postProcessors = [
      lost(),
      pxToRem({
          propWhiteList: []
      })
  ];
  return gulp.src('./admin-styles/scss/**/*.scss')
      .pipe(sourcemaps.init())
      .pipe(sass())
      .pipe(postcss(postProcessors))
      .pipe(autoprefixer())
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./admin-styles'))
      .pipe(browsersync.stream());
})

// gulp.task('css', function() {
//   return gulp.src('./**/*.css')
//       .pipe(browsersync.stream());
// });

// js tasks
gulp.task('js', function() {
  return gulp.src('./js/**/*.js')
      .pipe(browsersync.reload());
});

// reload browsersync
gulp.task('reload', function() {
  browsersync.reload();
  return;
});

// watch tasks
gulp.task('watch', function() {
  // gulp.watch('./**/*.html', ['reload']);
  // gulp.watch('./**/*.php', ['reload']);
  gulp.watch('./styles/**/*.scss', ['sass']);
  gulp.watch('./admin-styles/scss/**/*.scss', ['admin-styles']);
  // gulp.watch('./**/*.css', ['css']);
  gulp.watch('./js/**/*.js', ['js']);
});

/**
* Migrate to build folder tasks - gulp command = 'gulp-build'
*/

// html tasks
gulp.task('html-build', function() {
   return gulp.src(['./**/*.html', '!node_modules'])
        .pipe(gulp.dest('../build'))
});

// php tasks
gulp.task('php-build', function() {
   return gulp.src('./**/*.php')
        .pipe(gulp.dest('../build'))
});


// styles tasks
gulp.task('styles-build', function() {
    var postProcessors = [
        lost(),
        pxToRem({
            propWhiteList: []
        })
    ];
   return gulp.src('./styles/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(postcss(postProcessors))
        .pipe(autoprefixer())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('../build'));
});

// image tasks
gulp.task('images-build', function() {
   return gulp.src('./images/*')
        .pipe(imagemin())
        .pipe(gulp.dest('../build/images'))
});

// local serve
gulp.task('serve', ['sass', 'admin-styles', 'watch'], function() {
  browsersync.init({
    proxy: 'localhost'
  })
});

// build task
gulp.task('build', ['html-build', 'php-build', 'styles-build', 'images-build', 'watch']);

// default task
gulp.task('default', ['serve']);
