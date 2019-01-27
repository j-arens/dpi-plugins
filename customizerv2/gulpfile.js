// general
const gulp = require('gulp');
const argv = require('yargs');
const segregate = require('gulp-watch');
const named = require('vinyl-named');

// css processors
const postcss = require('gulp-postcss');
const cssImport = require('postcss-import');
const cssNext = require('postcss-cssnext');
const cssNano = require('gulp-cssnano');

// js processors
const webpack = require('webpack-stream');

const env = {
  version: '1.0.0',
  dev: argv.dev || false,
  // devPath: '/home/josh/dev/vagrant-local/www/wordpress-default/public_html/wp-content/plugins',
  devPath: 'C:/Users/DPI/Desktop/dev/wordpress/ctk-atlanta/wp-content/plugins'
};

/**
* CSS
*/
const plugins = [
  cssImport(),
  cssNext({
    browsers: [
      "Android 2.3",
      "Android >= 4",
      "Chrome >= 20",
      "Firefox >= 24",
      "Explorer >= 8",
      "iOS >= 6",
      "Opera >= 12",
      "Safari >= 6"
    ],
    features: {
      rem: false,
      customProperties: {
        strict: false
      }
    }
  })
];

gulp.task('css', () => gulp.src('./source/css/**/*.css')
    .pipe(postcss(plugins))
    .pipe(cssNano())
    .pipe(gulp.dest(`./distribution/dpi-customizer-${env.version}/css`))
);

/**
* JS
*/
gulp.task('js', () => gulp.src('./source/js/**/*.js')
    .pipe(named())
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(gulp.dest(`./distribution/dpi-customizer-${env.version}/js`))
);

/**
* Dist
*/
gulp.task('dist', () => gulp.src('./source/**/*.+(php|json|txt|lock)', {base: './source'})
    .pipe(gulp.dest(`./distribution/dpi-customizer-${env.version}`))
);

/**
* Migrate to local vagrant install
*/
const distSrc = `./distribution/dpi-customizer-${env.version}/**/*`;
const distBase = {base: `./distribution/dpi-customizer-${env.version}`};

gulp.task('migrate-vagrant', () => gulp.src(distSrc, distBase)
    .pipe(segregate(distSrc, distBase))
    .pipe(gulp.dest(env.devPath + `/dpi-customizer-${env.version}`))
);

/**
* Watch commands
*/
gulp.task('watch', () => {
  gulp.watch('./source/**/*.php', ['dist']);
  gulp.watch('./source/css/**/*.css', ['css']);
  gulp.watch('./source/js/**/*.js', ['js']);
  if (env.dev) {
    gulp.watch('./src/**/*', ['build']);
  }
});

/**
* Gulp commands
*/
gulp.task('build', ['css', 'js', 'dist']);

gulp.task('build-watch', ['build', 'watch'])

gulp.task('dev', ['build', 'migrate-vagrant']);

gulp.task('dev-watch', ['dev', 'watch']);

gulp.task('default', ['dev-watch']);
