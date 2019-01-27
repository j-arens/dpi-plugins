'use-strict';

// utils
const named = require('vinyl-named');
const rename = require('gulp-rename');

// general processors
const gulp = require('gulp');
const sourcemaps = require('gulp-sourcemaps');

// image processors
const imagemin = require('gulp-imagemin');

// css processors
const postcss = require('gulp-postcss');
const next = require('postcss-cssnext');
const nano = require('gulp-cssnano');
const flexbug = require('postcss-flexbugs-fixes');

// js processors
const webpack = require('webpack-stream');

/**
 * Styles
 */
const browserSupport = [
  "Android 2.3",
  "Android >= 4",
  "Chrome >= 20",
  "Firefox >= 24",
  "Explorer >= 8",
  "iOS >= 6",
  "Opera >= 12",
  "Safari >= 6"
];

const plugins = [
  next({
    browsers: browserSupport,
    features: {rem: false}
  }),
  flexbug()
];

gulp.task('styles', () => gulp.src('./assets/css/source/**/*.css')
    .pipe(sourcemaps.init())
    .pipe(postcss(plugins))
    .pipe(nano({zindex: false, reduceIdents: false}))
    .pipe(rename(file => file.extname = '.min.css'))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./assets/css'))
);

/**
 * JS
 */
gulp.task('js', () => gulp.src('./assets/js/source/**/*.js')
    .pipe(named())
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(rename(file => file.extname = '.min.js'))
    .pipe(gulp.dest('./assets/js'))
);

/**
 * Assets
 */
gulp.task('icons', () => gulp.src('./assets/**/*.+(jpg|jpeg|gif|png|svg)', {base: './assets/icons'})
    .pipe(imagemin(
        imagemin.svgo({plugins: [
            {removeUselessStrokeAndFill: false},
            {removeUnknownsAndDefaults: false}
        ]})
    ))
    .pipe(gulp.dest('./assets/icons'))
);


/**
 * Watch
 */
gulp.task('watch', function() {
    // styles
    gulp.watch('./assets/css/source/**/*.css', ['styles']);

    // js
    gulp.watch('./assets/js/source/**/*.js', ['js']);

    // assets
    gulp.watch('./assets/**/*.+(jpg|jpeg|gif|png|svg)', ['icons']);
});

/**
 * Commands
 */
gulp.task('build', ['styles', 'js', 'icons']);
gulp.task('build-watch', ['build', 'watch']);
gulp.task('default', ['build-watch']);