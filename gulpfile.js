/*eslint-env node */
'use strict';

var gulp = require('gulp'),
  browserSync = require('browser-sync').create(),
  sass = require('gulp-sass'),
  concat = require('gulp-concat'),
  uglify = require('gulp-uglify'),
  rename = require('gulp-rename'),
  sourcemaps = require('gulp-sourcemaps'),
  clean = require('gulp-clean'),
  imagemin = require('gulp-imagemin'),
  pngquant = require('imagemin-pngquant'),
  autoprefixer = require('gulp-autoprefixer'),
  eslint = require('gulp-eslint');
  //bower = require('gulp-bower-files');
  //replace = require('gulp-replace');

gulp.task('default', ['lint','copy-html','copy-images','copy-php','styles','scripts'], function(){
    

    gulp.watch('./sass/*.scss', ['styles']);
    gulp.watch('./js/**/*.js',['lint','scripts']);
    gulp.watch('./index.html', ['copy-html']); // watches dev copy for changes and copies it to dist
    gulp.watch('./fileUpload.html', ['copy-html']); // watches dev copy for changes and copies it to dist
    gulp.watch('./partials/*.html', ['copy-html']); // watches dev copy for changes and copies it to dist
    // gulp.watch('./**/*.php', ['copy-php']); // watches dev copy for changes and copies it to dist
    gulp.watch('dist/**/*.html').on('change', browserSync.reload); // watches dist copy and reloads the browser

    browserSync.init({server: "./dist"});
});

//Process CSS
gulp.task('styles',['copy-vendor-css', 'copy-fonts'], function() {
    gulp.src('sass/**/*.scss')
      .pipe(sourcemaps.init())
      .pipe(concat('styles.min.scss'))
      .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
      .pipe(autoprefixer({
        browsers: ['last 2 versions']
      }))
      .pipe(rename('styles.min.css'))
      .pipe(sourcemaps.write('maps'))
      .pipe(gulp.dest('dist/css/'));    
});

//Copy Vendor CSS files
gulp.task('copy-vendor-css',function(){
  gulp.src(['bower_components/bootstrap/dist/css/bootstrap.min.css',
                'bower_components/font-awesome/css/font-awesome.min.css',
                'bower_components/metisMenu/dist/metisMenu.min.css',
                'bower_components/morrisjs/morris.css'])
      .pipe(sourcemaps.init())
      .pipe(concat('vendors.min.css'))
      .pipe(sourcemaps.write('maps'))
      .pipe(gulp.dest('dist/css/'));
});

gulp.task('copy-fonts', function(){
  gulp.src('bower_components/font-awesome/fonts/*.*')
    .pipe(gulp.dest('dist/fonts/'));
});

// Process JS files
gulp.task('scripts',['copy-chart-js','bower'], function(){
  gulp.src(['js/*.js','!morris-data.js','!flot-data.js'])
    .pipe(sourcemaps.init())
    .pipe(concat('lister.min.js'))
    .pipe(uglify())
    .pipe(sourcemaps.write('maps'))
    .pipe(gulp.dest('dist/js'));

});

//Copy mock chart data JS files - won't be needed with prod release
gulp.task('copy-chart-js',function(){
  gulp.src(['js/morris-data.js','js/flot-data.js'])
    .pipe(gulp.dest('dist/js'));
});


//Copy Bower main js files
gulp.task('bower', function() {

  gulp.src(['bower_components/jquery/dist/jquery.min.js',
  'bower_components/bootstrap/dist/js/bootstrap.min.js',
  'bower_components/angular/angular.min.js',
  'bower_components/angular-animate/angular-animate.js',
  'bower_components/angular-route/angular-route.js',
  'bower_components/angular-resource/angular-resource.js',
  'bower_components/metisMenu/dist/metisMenu.min.js',
  'bower_components/raphael/raphael.min.js',
  'bower_components/morrisjs/morris.min.js',
  'bower_components/flot/excanvas.min.js',
  'bower_components/flot/jquery.flot.js',
  'bower_components/flot/jquery.flot.pie.js',
  'bower_components/flot/jquery.flot.resize.js',
  'bower_components/flot/jquery.flot.time.js',
  'bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js'])
    .pipe(sourcemaps.init())
    .pipe(concat('vendor.min.js'))
    .pipe(sourcemaps.write('maps'))
    .pipe(gulp.dest('dist/js'));

  
  /*
  bower()
    .pipe(sourcemaps.init())
    .pipe(concat('vendor.min.js'))
    .pipe(sourcemaps.write('maps'))
    .pipe(gulp.dest('dist/js'));
  */

}); 

gulp.task('lint', function() {
    // ESLint ignores files with "node_modules" paths. 
    // So, it's best to have gulp ignore the directory as well. 
    // Also, Be sure to return the stream from the task; 
    // Otherwise, the task may end before the stream has finished. 
    return gulp.src(['js/**/*.js','!node_modules/**','!bower_components/**'])
        // eslint() attaches the lint output to the "eslint" property 
        // of the file object so it can be used by other modules. 
        .pipe(eslint())
        // eslint.format() outputs the lint results to the console. 
        // Alternatively use eslint.formatEach() (see Docs). 
        .pipe(eslint.format())
        // To have the process exit with an error code (1) on 
        // lint error, return the stream and pipe to failAfterError last. 
        .pipe(eslint.failAfterError());
});

//Copy HTML Files
gulp.task('copy-html',['copy-html-index','copy-html-upload','copy-html-partials']);

gulp.task('copy-html-index', function(){
  gulp.src('index.html')
    .pipe(gulp.dest('./dist/').on('error', sass.logError));
});

gulp.task('copy-html-upload', function(){
  gulp.src('fileUpload.html')
    .pipe(gulp.dest('./dist/').on('error', sass.logError));
});

gulp.task('copy-html-partials', function(){
  gulp.src('partials/*.html')
    .pipe(gulp.dest('./dist/partials/').on('error', sass.logError));
});

//Copy Images
gulp.task('copy-images', function(){
  gulp.src('img/*')
    .pipe(imagemin({
      progressive: true,
      use:[pngquant()]
    }))
    .pipe(gulp.dest('dist/img'));
});

//Copy PHP Files
gulp.task('copy-php',['copy-php-includes','copy-php-classes','copy-php-services']);

gulp.task('copy-php-includes', function(){
  gulp.src('includes/*.php')
    .pipe(gulp.dest('./dist/includes/'));
});

gulp.task('copy-php-classes', function(){
  gulp.src('classes/*.php')
    .pipe(gulp.dest('./dist/classes/'));
});

gulp.task('copy-php-services', function(){
  gulp.src('services/*.php')
   .pipe(gulp.dest('./dist/services/'));
});

gulp.task('dist', ['clean-dist','lint','copy-html','copy-images','copy-php','styles','scripts']);

gulp.task('clean-dist', function () {
  return gulp.src('dist', {read: false})
    .pipe(clean({force: true}));
});


gulp.task('font-awesome', ['copy-vendor-css'], function(){
  gulp.src('bower_components/font-awesome/scss/**/*.scss')
      .pipe(sourcemaps.init())
      .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
      .pipe(autoprefixer({
        browsers: ['last 2 versions']
      }))
      .pipe(rename('font-awesome.min.css'))
      .pipe(sourcemaps.write())
      .pipe(gulp.dest('./bower_components/font-awesome/css/'));    
})