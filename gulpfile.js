'use strict';

var gulp = require('gulp'),
 sass = require('gulp-sass'),
 concat = require('gulp-concat'),
 uglify = require('gulp-uglify'),
 rename = require('gulp-rename'),
 sourcemaps = require('gulp-sourcemaps'),
 clean = require('gulp-clean');

gulp.task('default', ['minify-angular','styles']);

gulp.task('watch',function(){
  gulp.watch('sass/**/*.scss',['styles']);
});

gulp.task('styles', ['clean-styles'],function() {
    gulp.src('sass/**/*.scss')
      .pipe(sourcemaps.init())
      .pipe(concat('styles.scss'))
      .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
      .pipe(rename('styles.min.css'))
      .pipe(sourcemaps.write('maps'))
      .pipe(gulp.dest('dist/css/'));
});

gulp.task('js',['clean-scripts'],function(){
  gulp.src(['js/client.js','js/app.js','js/ListingControllers.js','js/ListingService.js','js/animations.js','js/directives.js','js/filters.js'])
    .pipe(sourcemaps.init())
    .pipe(concat('lister.js'))
    .pipe(gulp.dest('dist/js'))
    .pipe(uglify())
    .pipe(rename('lister.min.js'))
    .pipe(sourcemaps.write('maps'))
    .pipe(gulp.dest('dist/js'))
});

gulp.task('clean-scripts', function () {
  return gulp.src('dist/js/**/*.*', {read: false})
    .pipe(clean());
});

gulp.task('clean-styles', function () {
  return gulp.src('dist/css/**/*.*', {read: false})
    .pipe(clean());
});
