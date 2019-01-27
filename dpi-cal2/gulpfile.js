// nodejs
const path = require('path');

// general processors
const gulp = require('gulp');
const argv = require('yargs');
const segregate = require('gulp-watch');

// js processors
const uglify = require('gulp-uglify');
const webpack = require('webpack-stream');

const env = {
  version: '1.0.0',
  dev: argv.dev || false,
  devPath: '/home/josh/dev/vagrant-local/www/wordpress-default/public_html/wp-content/plugins'
  // devPath: 'C:/xampp/htdocs/wp-content/plugins'
};

/**
* CSS
*/
gulp.task('css', () => gulp.src('./src/css/**/*.css', {base: './src/css'})
    .pipe(gulp.dest(`./dist/dpi-cal-${env.version}/css`))
);

/**
* JS
*/
gulp.task('single-js', () => gulp.src('./src/js/es5/**/*.js', {base: './src/js/es5'})
    .pipe(gulp.dest(`./dist/dpi-cal-${env.version}/js`))
);

gulp.task('bundle-js', () => gulp.src('./src/js/es6/*.js')
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(gulp.dest(`./dist/dpi-cal-${env.version}/js`))
);

/**
* Dist
*/
gulp.task('dist', () => gulp.src('./src/**/*.+(php|json|txt|lock)', {base: './src'})
    .pipe(gulp.dest(`./dist/dpi-cal-${env.version}`))
);

/**
* Migrate to local vagrant install
*/
const distSrc = `./dist/dpi-cal-${env.version}/**/*`;
const distBase = {base: `./dist/dpi-cal-${env.version}`};

gulp.task('migrate-vagrant', () => gulp.src(distSrc, distBase)
    .pipe(segregate(distSrc, distBase))
    .pipe(gulp.dest(env.devPath + `/dpi-cal-${env.version}`))
);

/**
* Watch commands
*/
gulp.task('watch', () => {
  gulp.watch('./src/**/*.php', ['dist']);
  gulp.watch('./src/vendor/**/*', ['dist']);
  gulp.watch('./src/css/**/*.css', ['css']);
  gulp.watch('./src/js/**/*.js', ['js']);
  if (env.dev) {
    gulp.watch('./src/**/*', ['build']);
  }
});

/**
* Gulp commands
*/
gulp.task('build', ['css', 'single-js', 'bundle-js', 'dist']);

gulp.task('build-watch', ['build', 'watch'])

gulp.task('dev', ['build', 'migrate-vagrant']);

gulp.task('dev-watch', ['dev', 'watch']);

gulp.task('default', ['dev-watch']);
