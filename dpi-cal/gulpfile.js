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

const plugins = [
  vars(),
  nested()
];

/**
* Plugin page styles
*/
gulp.task('admin-styles', () => gulp.src('./src/assets/css/plugin-page.css')
    .pipe(sourcemaps.init())
    .pipe(postcss(plugins))
    .pipe(autoprefixer({browsers: ['last 4 versions']}))
    .pipe(nano())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./dist/dpi-cal/assets/css'))
);

/**
* Calendar styles
*/
gulp.task('cal-styles', () => gulp.src('./src/assets/css/fullcalendar.css')
    .pipe(autoprefixer({browsers: ['last 4 versions']}))
    .pipe(nano())
    .pipe(gulp.dest('./dist/dpi-cal/assets/css'))
);

/**
* Calendar print styles
*/
gulp.task('cal-print-styles', () => gulp.src('./src/assets/css/fullcalendar.print.css')
    .pipe(autoprefixer({browsers: ['last 4 versions']}))
    .pipe(nano())
    .pipe(gulp.dest('./dist/dpi-cal/assets/css'))
);

/**
* Javascript
*/
gulp.task('js', () => gulp.src('./src/assets/js/cal-modals.js')
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(gulp.dest('./dist/dpi-cal/assets/js'))
)

gulp.task('gcal-js', () => gulp.src('./src/assets/js/gcal.js')
    .pipe(webpack(require('./webpack.gcal.js')))
    .pipe(gulp.dest('./dist/dpi-cal/assets/js'))
);

const jsTargets = [
  './src/assets/js/fullcalendar.min.js',
  './src/assets/js/moment.min.js'
]

gulp.task('migrate-js', () => gulp.src(jsTargets, {base: './src'})
    .pipe(gulp.dest('./dist/dpi-cal'))
);

/**
* Migrate php
*/
const phpTargets = [
  './src/DPI_Cal.php',
  './src/index.php',
  './src/views/DPI_Cal_Backend.php',
  './src/views/DPI_Cal_Frontend.php',
  './src/components/Calendar.php',
  './src/components/Events_list.php'
];

gulp.task('migrate-php', () => gulp.src(phpTargets, {base: './src'})
    .pipe(gulp.dest('./dist/dpi-cal'))
);

/**
* Gulp commands
*/
gulp.task('build', ['admin-styles', 'cal-styles', 'cal-print-styles', 'js', 'migrate-js', 'migrate-php']);

gulp.task('default', ['build']);
