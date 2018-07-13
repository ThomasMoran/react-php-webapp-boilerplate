'use strict';
 
let gulp = require('gulp');
let sass = require('gulp-sass');
 
gulp.task('sass', function () {
  return gulp.src('./dev/styles/**/*.scss')
    .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
    .pipe(gulp.dest('./public/css'));
});
 
gulp.task('sass:watch', function () {
  gulp.watch('./dev/styles/**/*.scss', ['sass']);
  gulp.watch('./dev/js/components/**/*.html', ['copy']);
});


gulp.task('copy', function () {
     return gulp
         .src('./dev/js/components/**/*.html')
         .pipe(gulp.dest('./public/js/components/'));
});

// Default Task
gulp.task('default', ['sass', 'sass:watch']);