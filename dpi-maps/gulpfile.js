// utils
const gulp = require('gulp');
const rename = require('gulp-rename');

// css
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');

// js
const webpack = require('webpack-stream');

/**
 * Styles
 */
gulp.task('styles', () => gulp.src('./Assets/styles/source/pluginpage.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(rename('pluginpage.min.css'))
    .pipe(gulp.dest('./Assets/styles'))
);

/**
 * JS 
 */
 gulp.task('js', () => gulp.src('./Assets/js/source/index.js')
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(rename('client.min.js'))
    .pipe(gulp.dest('./Assets/js'))
 );
 
 /**
 * Watch
 */
 gulp.task('watch', () => {
   gulp.watch('./Assets/styles/source/**/*.scss', ['styles']);
   gulp.watch('./ASsets/js/source/**/*.js', ['js']);
 })
 
 /**
 * Tasks
 */
gulp.task('build', ['styles', 'js']);
gulp.task('build-watch', ['styles', 'js', 'watch']);
gulp.task('default', ['build']);