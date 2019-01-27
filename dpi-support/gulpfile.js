'use-strict';

// node
const path = require('path');
// const stream = require('stream');
// const through = require('through2');

// general processors
const gulp = require('gulp');
const sourcemaps = require('gulp-sourcemaps');
const rename = require('gulp-rename');

// css processors
const postcss = require('gulp-postcss');
const next = require('postcss-cssnext');
const cssImport = require('postcss-partial-import');
const nano = require('gulp-cssnano');
const flexbug = require('postcss-flexbugs-fixes');

// js processors
const webpack = require('webpack-stream');

// const cacheBust = (version) => {
//     return through.obj((file, enc, cb) => {
//         // const cacheVer = Date.now().toString().split('').reverse().slice(0, 4).join('');
//         const ext = path.extname(file.path);
//         const basename = path.basename(file.path, ext);
//         const renamed = `${basename}.${version + ext}`;

//         file.path = path.join(file.dirname + '/' + renamed);

//         if (file.sourceMap) {
//             file.sourceMap.file = file.relative;
//         }

//         cb(null, file);
//     });
// }

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
    cssImport(),
    next({browsers: browserSupport, features: {rem: false}}),
    flexbug()
];

gulp.task('styles', () => gulp.src('./source/styles/style.css')
    .pipe(sourcemaps.init())
    .pipe(postcss(plugins))
    .pipe(nano({zindex: false, reduceIdents: false}))
    .pipe(rename('style.min.css'))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./distribution/styles'))
);

/**
 * JS
 */
gulp.task('js', () => gulp.src('./source/js/index.js')
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(gulp.dest('./distribution/js'))
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
    // gulp.watch('./source/assets/**/*', ['assets']);
});

/**
 * Commands
 */
gulp.task('build', ['styles', 'js', 'php', 'composer']);
gulp.task('build-watch', ['build', 'watch']);
gulp.task('default', ['build-watch']);