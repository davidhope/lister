'use strict';

var gulp = require('gulp'),
 sass = require('gulp-sass'),
 concat = require('gulp-concat'),
 cleancss = require('gulp-clean-css'),
 uglify = require('gulp-uglify'),
 rename = require('gulp-rename'),
 sourcemaps = require('gulp-sourcemaps');

gulp.task('default', ['minify-angular','minify-data','minify-js','styles']);

gulp.task('watch',function(){
  gulp.watch('sass/**/*.scss',['styles']);
});

gulp.task('styles', function() {
    gulp.src('sass/**/*.scss')
      .pipe(sourcemaps.init())
      .pipe(concat('styles.scss'))
      .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
      .pipe(rename('styles.min.css'))
      .pipe(sourcemaps.write('maps'))
      .pipe(gulp.dest('dist/css/'));
});

gulp.task('minify-angular',function(){
  gulp.src(['js/app.js','js/ListingControllers.js','js/ListingService.js','js/animations.js','js/directives.js','js/filters.js'])
    .pipe(sourcemaps.init())
    .pipe(concat('lister.js'))
    .pipe(gulp.dest('dist/js'))
    .pipe(uglify())
    .pipe(rename('lister.min.js'))
    .pipe(sourcemaps.write('maps'))
    .pipe(gulp.dest('dist/js'))
});

gulp.task('minify-data',function(){
  gulp.src(['js/flot-data.js','js/morris-data.js'])
    .pipe(sourcemaps.init())
    .pipe(concat('data.js'))
    .pipe(gulp.dest('dist/js'))
    .pipe(uglify())
    .pipe(rename('data.min.js'))
    .pipe(sourcemaps.write('maps'))
    .pipe(gulp.dest('dist/js'))
});

gulp.task('minify-js',function(){
  gulp.src(['js/sb-admin-2.js'])
    .pipe(sourcemaps.init())
    .pipe(concat('client.js'))
    .pipe(gulp.dest('dist/js'))
    .pipe(uglify())
    .pipe(rename('client.min.js'))
    .pipe(sourcemaps.write('maps'))
    .pipe(gulp.dest('dist/js'))
});
