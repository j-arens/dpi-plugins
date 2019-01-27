'use-strict';

// general processors
const gulp = require('gulp');
const sourcemaps = require('gulp-sourcemaps');

// css processors
const postcss = require('gulp-postcss');
const vars = require('postcss-simple-vars');
const nested = require('postcss-nested');
const autoprefixer = require('gulp-autoprefixer');
const nano = require('gulp-cssnano');

// js processors
const webpack = require('webpack-stream');

/**
* Nav styles
*/
const plugins = [
  vars(),
  nested()
];

gulp.task('nav-styles', () => gulp.src('./src/assets/css/mm-nav.css')
    .pipe(sourcemaps.init())
    .pipe(postcss(plugins))
    .pipe(autoprefixer({browsers: ['last 2 versions']}))
    .pipe(nano({zindex: false}))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./dist/dpi-mm/assets/css'))
);

/**
* Plugin page styles
*/
gulp.task('admin-styles', () => gulp.src('./src/assets/css/admin-styles.css')
    .pipe(sourcemaps.init())
    .pipe(postcss(plugins))
    .pipe(autoprefixer({browsers: ['last 2 versions']}))
    .pipe(nano())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./dist/dpi-mm/assets/css'))
);

/**
* Javascript
*/
gulp.task('js', () => gulp.src('./src/assets/js/*.js')
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(gulp.dest('./dist/dpi-mm/assets/js'))
)

/**
* Migrate php
*/
const targets = [
  './src/DPI_MM.php',
  './src/index.php',
  './src/inc/DPI_MM_Options_Page.php',
  './src/inc/DPI_MM_Custom_Styles.php',
  './src/inc/DPI_MM_Shortcode.php',
  './src/inc/DPI_MM_Walker.php',
  './src/inc/DPI_MM_Nav.php',
];

gulp.task('migrate', () => gulp.src(targets, {base: './src'})
    .pipe(gulp.dest('./dist/dpi-mm'))
);

/**
* Gulp commands
*/
gulp.task('build', ['nav-styles', 'admin-styles', 'js', 'migrate']);

gulp.task('default', ['build']);
