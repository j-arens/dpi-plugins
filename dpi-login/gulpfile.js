// general
const gulp = require('gulp');
const segregate = require('gulp-watch');

// js processors
const webpack = require('webpack-stream');

const env = {
  version: '1.0.0',
//   dev: argv.dev || false,
  devPath: '/home/josh/dev/vvv/www/wordpress-develop/public_html/src/wp-content/plugins',
  devURL: ''
};


/**
* JS
*/
gulp.task('js', () => gulp.src('./source/js/plugin-page.js')
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(gulp.dest(`./distribution/dpi-login-${env.version}/js`))
);

/**
* Dist
*/
gulp.task('dist', () => gulp.src('./source/**/*.+(css|php|json|txt|lock)', {base: './source'})
    .pipe(gulp.dest(`./distribution/dpi-login-${env.version}`))
);

/**
* Migrate to local vagrant install
*/
const distSrc = `./distribution/dpi-login-${env.version}/**/*`;
const distBase = {base: `./distribution/dpi-login-${env.version}`};

gulp.task('migrate-vagrant', () => gulp.src(distSrc, distBase)
    .pipe(segregate(distSrc, distBase))
    .pipe(gulp.dest(env.devPath + `/dpi-login-${env.version}`))
);

/**
* Watch commands
*/
gulp.task('watch', () => {
  gulp.watch('./source/**/*.php', ['dist']);
  gulp.watch('./source/css/**/*.css', ['dist']);
  gulp.watch('./source/js/**/*.js', ['js']);

//   if (env.dev) {
//     gulp.watch('./src/**/*', ['build']);
//   }
});

/**
* Gulp commands
*/
gulp.task('build', ['js', 'dist']);

gulp.task('build-watch', ['build', 'watch'])

gulp.task('dev', ['build', 'migrate-vagrant']);

gulp.task('dev-watch', ['dev', 'watch']);

gulp.task('default', ['dev-watch']);