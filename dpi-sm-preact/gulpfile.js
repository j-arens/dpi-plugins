// nodejs
const path = require('path');

// general processors
const gulp = require('gulp');
const argv = require('yargs');
const segregate = require('gulp-watch');

// js processors
const webpack = require('webpack-stream');

const env = {
  dev: argv.dev || false,
  devPath: '/home/josh/dev/vagrant-local/www/wordpress-default/public_html/wp-content/plugins'
  // devPath: 'C:/xampp/htdocs/wp-content/plugins'
};

/**
* CSS
*/
gulp.task('css', () => gulp.src('./src/css/**/*.css')
    .pipe(gulp.dest('./dist/dpi-super-menu/css'))
);

/**
* Webpack
*/
gulp.task('webpack', () => gulp.src('./src/js/backend/app.js')
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(gulp.dest('./dist/dpi-super-menu/js/backend'))
)

/**
* Migrate php
*/
gulp.task('migrate', () => gulp.src('./src/**/*.php', {base: './src'})
    .pipe(gulp.dest('./dist/dpi-super-menu'))
);

/**
* Migrate to local vagrant install
*/
const distSrc = './dist/dpi-super-menu/**/*';
const distBase = {base: './dist/dpi-super-menu'};

console.log(env.devPath);
gulp.task('migrate-vagrant', () => gulp.src(distSrc, distBase)
    .pipe(segregate(distSrc, distBase))
    .pipe(gulp.dest(path.resolve(env.devPath, 'dpi-super-menu')))
);

/**
* Watch commands
*/
gulp.task('watch', () => {
  gulp.watch('./src/**/*.php', ['migrate']);
  gulp.watch('./src/**/*.css', ['css']);
  gulp.watch('./src/js/backend/**/*.js', ['webpack']);
  if (env.dev) {
    gulp.watch('./src/**/*', ['build']);
  }
});

/**
* Gulp commands
*/
gulp.task('build', ['css', 'webpack', 'migrate']);

gulp.task('build-watch', ['build', 'watch'])

gulp.task('dev', ['build', 'migrate-vagrant']);

gulp.task('dev-watch', ['dev', 'watch']);

gulp.task('default', ['build']);
