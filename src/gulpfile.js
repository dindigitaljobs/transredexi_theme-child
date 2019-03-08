// Dependencies
const gulp = require('gulp');
const gutil = require('gulp-util');
const sourcemaps = require('gulp-sourcemaps');
const bust = require('gulp-buster');
const pump = require('pump');
const concat = require('gulp-concat');
const del = require('del');

const sass = require('gulp-sass');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const precss = require('precss');
const shortColor = require('postcss-short-color');
const cleanCSS = require('gulp-clean-css');

const babel = require('gulp-babel');
const uglify = require('gulp-uglify');

// Folders
const npm = 'node_modules';
const src = 'assets';
const dist = '../assets';

// Vendors
const vendors = {
  css: [
    npm + '/normalize.css/normalize.css',
  ],
  js: [
    npm + '/jquery-mask-plugin/dist/jquery.mask.min.js'
  ]
};

// Version
gulp.task('version', (cb) => {
  pump([
    gulp.src([
      src + '/sass/*.sass',
      src + '/js/*.js'
    ]),
    bust(),
    gulp.dest(dist)
  ], cb);
});

// Development Tasks
gulp.task('dev-css', (cb) => {
  pump([
    gulp.src([
      src + '/sass/*.sass'
    ]),
    sourcemaps.init(),
    sass().on('error', sass.logError),
    concat('main.css'),
    cleanCSS({
      minify: false
    }),
    postcss([
      precss,
      autoprefixer({browsers: 'last 2 version', cascade: false}),
      shortColor
    ]),
    sourcemaps.write('.'),
    gulp.dest(dist + '/css')
  ], cb);
});

gulp.task('dev-js', (cb) => {
  pump([
    gulp.src([
      src + '/js/*.js'
    ]),
    sourcemaps.init(),
    concat('main.js'),
    babel({
      presets: ['@babel/preset-env']
    }),
    uglify({
      mangle: false,
      compress: false
    }),
    sourcemaps.write("."),
    gulp.dest(dist + '/js')
  ], cb);
});


gulp.task('dev-css-vendor', (cb) => {
  if (vendors.css || vendors.css !== '') {
    return pump([
      gulp.src(vendors.css),
      concat('vendor.css'),
      cleanCSS({
        compatibility: 'ie8',
        minify: false
      }),
      gulp.dest(dist + '/css')
    ], cb);
  }
  cb();
  console.log('Não há vendors.css para compilar! Próxima task...');
});

gulp.task('dev-js-vendor', (cb) => {
  if ( vendors.js || vendors.js !== '' ) {
    return pump([
      gulp.src(vendors.js),
      concat('vendor.js'),
      uglify({
        mangle: false,
        compress: false
      }),
      gulp.dest(dist + '/js')
    ], cb);
  }
  cb();
  console.log('Não há vendors.js para compilar! Próxima task...');
});

// Production Tasks
gulp.task('css', (cb) => {
  pump([
    del(dist + '/css/main.css.map', { force: true }),
    gulp.src([
      src + '/sass/*.sass'
    ]),
    sass().on('error', sass.logError),
    concat('main.css'),
    cleanCSS({
      minify: true
    }),
    postcss([
      precss,
      autoprefixer({browsers: 'last 2 version', cascade: false}),
      shortColor
    ]),
    gulp.dest(dist + '/css')
  ], cb);
});

gulp.task('js', (cb) => {
  pump([
    del(dist + '/js/main.js.map', { force: true }),
    gulp.src([
      src + '/js/*.js'
    ]),
    concat('main.js'),
    babel({
      presets: ['@babel/preset-env']
    }),
    uglify({
      mangle: true,
      compress: true
    }),
    gulp.dest(dist + '/js')
  ], cb);
});

gulp.task('css-vendor', (cb) => {
  pump([
    gulp.src(vendors.css),
    concat('vendor.css'),
    cleanCSS({
      compatibility: 'ie8',
      minify: true
    }),
    gulp.dest(dist + '/css')
  ], cb);
});

gulp.task('js-vendor', (cb) => {
  pump([
    gulp.src(vendors.js),
    concat('vendor.js'),
    uglify({
      mangle: true,
      compress: true
    }),
    gulp.dest(dist + '/js')
  ], cb);
});

// Tasks
const tasks = {
  development: ['dev-css', 'dev-js', 'dev-css-vendor', 'dev-js-vendor'],
  production: ['css', 'js', 'css-vendor', 'js-vendor']
};

gulp.task('development', () => {
  gulp.watch(src + '/**/*', gulp.series(tasks.development));
});

gulp.task('default', gulp.series(tasks.production));
