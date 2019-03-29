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
  return gulp.src([
    src + '/sass/*.sass',
    src + '/js/*.js'
  ])
    .pipe(bust())
    .pipe(gulp.dest(dist))
});

// Development Tasks
gulp.task('dev-css', (cb) => {
  return gulp.src([
      src + '/sass/*.sass'
    ])
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(concat('main.css'))
    .pipe(cleanCSS({
      minify: false
    }))
    .pipe(postcss([
      precss,
      autoprefixer({browsers: 'last 2 version', cascade: false}),
      shortColor
    ]))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(dist + '/css'))
});

gulp.task('dev-js', (cb) => {
  return gulp.src([
      src + '/js/*.js'
    ])
    .pipe(sourcemaps.init())
    .pipe(concat('main.js'))
    .pipe(babel({
      presets: ['@babel/preset-env']
    }))
    .pipe(uglify({
      mangle: false,
      compress: false
    }))
    .pipe(sourcemaps.write("."))
    .pipe(gulp.dest(dist + '/js'))
});


gulp.task('dev-css-vendor', (cb) => {
  if (vendors.css || vendors.css !== '') {
    return gulp.src(vendors.css)
      .pipe(concat('vendor.css'))
      .pipe(cleanCSS({
        compatibility: 'ie8',
        minify: false
      }))
      .pipe(gulp.dest(dist + '/css'))
  }
  cb();
  console.log('Não há vendors.css para compilar! Próxima task...');
});

gulp.task('dev-js-vendor', (cb) => {
  if ( vendors.js || vendors.js !== '' ) {
    return gulp.src(vendors.js)
      .pipe(concat('vendor.js'))
      .pipe(uglify({
        mangle: false,
        compress: false
      }))
      .pipe(gulp.dest(dist + '/js'))
  }
  cb();
  console.log('Não há vendors.js para compilar! Próxima task...');
});

// Production Tasks
gulp.task('css', (cb) => {
    return gulp.src([
      src + '/sass/*.sass'
    ])
    .pipe(sass().on('error', sass.logError))
    .pipe(concat('main.css'))
    .pipe(cleanCSS({
      minify: true
    }))
    .pipe(postcss([
      precss,
      autoprefixer({browsers: 'last 2 version', cascade: false}),
      shortColor
    ]))
    .pipe(gulp.dest(dist + '/css'))
});

gulp.task('js', (cb) => {
  return gulp.src([
    src + '/js/*.js'
  ])
    .pipe(concat('main.js'))
    .pipe(babel({
      presets: ['@babel/preset-env']
    }))
    .pipe(uglify({
      mangle: true,
      compress: true
    }))
    .pipe(gulp.dest(dist + '/js'))
});

gulp.task('css-vendor', (cb) => {
  return gulp.src(vendors.css)
    .pipe(concat('vendor.css'))
    .pipe(cleanCSS({
      compatibility: 'ie8',
      minify: true
    }))
    .pipe(gulp.dest(dist + '/css'))
});

gulp.task('js-vendor', (cb) => {
  return gulp.src(vendors.js)
    .pipe(concat('vendor.js'))
    .pipe(uglify({
      mangle: true,
      compress: true
    }))
    .pipe(gulp.dest(dist + '/js'))
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
