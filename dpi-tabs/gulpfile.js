// utils
const gulp = require('gulp');
const sourcemaps = require('gulp-sourcemaps');
const rename = require('gulp-rename');

// css
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const nano = require('gulp-cssnano');

/**
 * Styles
 */
gulp.task('styles', () => gulp.src('./Assets/styles/source/style.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(nano({zindex: false, reduceIdents: false}))
    .pipe(rename('tabs-fe.min.css'))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./Assets/styles'))
);

/**
 * Watch
 */
gulp.task('watch', () => {
    gulp.watch('./Assets/styles/source/**/*.scss', ['styles']);
});

/**
 * Tasks
 */
gulp.task('build', ['styles']);
gulp.task('build-watch', ['styles', 'watch']);
gulp.task('default', ['build']);