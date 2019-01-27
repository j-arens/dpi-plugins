// general processors
const gulp = require('gulp');

// js processors
const webpack = require('webpack-stream');

/**
* Webpack
*/
gulp.task('webpack', () => gulp.src('./src/assets/js/app.js')
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(gulp.dest('./dist/dpi-staff/assets/js'))
)

/**
* Migrate php
*/
gulp.task('migrate', () => gulp.src('./src/**/*.php', {base: './src'})
    .pipe(gulp.dest('./dist/dpi-staff'))
);

/**
* Icons
*/
gulp.task('icons', () => gulp.src('./src/assets/icons/*.+(svg|png)')
    .pipe((gulp.dest('./dist/dpi-staff/assets/icons')))
);

/**
* Watch commands
*/
gulp.task('watch', () => {
  gulp.watch('./src/**/*.php', ['migrate']);
  gulp.watch('./src/assets/**/*.+(js|css)', ['webpack']);
});

/**
* Gulp commands
*/
gulp.task('build', ['webpack', 'migrate', 'icons']);

gulp.task('build-watch', ['build', 'watch'])

gulp.task('default', ['build']);
