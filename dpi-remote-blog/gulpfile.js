'use-strict';

// node
const path = require('path');

// utils
const named = require('vinyl-named');

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

gulp.task('styles', () => gulp.src('./source/styles/*.css')
    .pipe(sourcemaps.init())
    .pipe(postcss(plugins))
    .pipe(nano({zindex: false, reduceIdents: false}))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./distribution/styles'))
);

/**
 * JS
 */
gulp.task('js', () => gulp.src('./source/js/*.js')
    .pipe(named())
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(gulp.dest('./distribution/js'))
);

/**
 * Assets
 */
gulp.task('assets', () => gulp.src('./source/assets/**/*.+(jpg|jpeg|gif|png|svg)', {base: './source/assets'})
    .pipe(imagemin())
    .pipe(gulp.dest('./distribution/assets'))
);

/**
 * PHP
 */
gulp.task('php', () => gulp.src('./source/**/*.php', {base: './source'})
    .pipe(gulp.dest('./distribution'))
);

/**
 * Composer
 */
gulp.task('composer', () => gulp.src('./source/*.+(json|lock|txt)', {base: './source'})
    .pipe(gulp.dest('./distribution'))
);

/**
 * Watch
 */
gulp.task('watch', function() {
    // styles
    gulp.watch('./source/styles/**/*.css', ['styles']);

    // js
    gulp.watch('./source/js/**/*.js', ['js']);

    // php
    gulp.watch('./source/**/*.php', ['php']);

    // composer
    gulp.watch('./source/*.+(json|lock|txt)', ['composer']);

    // assets
    gulp.watch('./source/assets/**/*', ['assets']);
});

/**
 * Commands
 */
gulp.task('build', ['styles', 'js', 'php', 'composer', 'assets']);
gulp.task('build-watch', ['build', 'watch']);
gulp.task('default', ['build-watch']);