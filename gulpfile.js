"use strict";

var gulp = require('gulp');

// ** UTILITY PLUGINS ** //
var concat = require('gulp-concat');
var del = require('del');
var filter = require('gulp-filter');
var debug = require('gulp-debug');
var gulpif = require('gulp-if');
var rsync = require('gulp-rsync');
var mainBowerFiles = require('main-bower-files');
var argv = require('yargs').argv;

// ** JAVASCRIPT PLUGINS ** //
var uglify = require('gulp-uglify');
var jshint = require('gulp-jshint');
var sourcemaps = require('gulp-sourcemaps');

// ** IMAGE OPTIMISATION PLUGINS ** //
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');
var optipng = require('imagemin-optipng');
var jpegoptim = require('imagemin-jpegoptim');

// ** SETTINGS ** //
var production = !!(argv.production);
// To build production site, run: gulp --production

//TASK: CLEAN
gulp.task('clean', function() {
  return del([
    'assets/**/*',
  ]);
});

// TASK: JS Hint
gulp.task('jshint', function() {
  gulp.src(['custom_src/*.js','custom_src/**/*.js'])
    .pipe(jshint())
    .pipe(jshint.reporter('default'));
});

//TASK: JS Compiler
gulp.task('js', ['jshint'], function() {
	return gulp.src( mainBowerFiles().concat(['custom_src/*.js', 'custom_src/**/*.js']) )
		.pipe(filter('*.js'))
    .pipe(gulpif(production, uglify()))
    .pipe(gulp.dest('assets/js/'));
});

//TASK: CSS Compiler
gulp.task('css', function(){
  return gulp.src(mainBowerFiles().concat(['custom_src/*.css', 'custom_src/**/*.css']))
    .pipe( filter('*.css') )
    .pipe(gulp.dest('assets/css/'));
});


//TASK: Images
gulp.task('img', function(){
  return gulp.src('custom_src/images/*.{gif,jpg,png,svg}')
    .pipe(imagemin({
      optimizationLevel: 3,
      progressive: true,
      svgoPlugins: [{
        removeViewBox: false
      }],
      use: [
        pngquant(),
        optipng({
          optimizationLevel: 3
        }),
        jpegoptim({
          max: 50,
          progressive: true
        }),
      ]
    }))
    .pipe(gulp.dest('assets/img/'));

});

//TASK: Data
gulp.task( 'files', function(){
  return gulp.src(['custom_src/data/*'])
    .pipe(gulp.dest('assets/data'));
});

// DEFAULT TASK
gulp.task('default', ['clean'], function() {
  gulp.start('css', 'js', 'img', 'files');
});
