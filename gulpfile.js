var gulp = require('gulp');
var minify = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var watch = require('gulp-watch');
var sass = require('gulp-sass');
var imagemin = require('gulp-imagemin');
var gulpif = require('gulp-if');

var jsSrc = [
  './node_modules/tether/dist/js/tether.min.js',
  './node_modules/jquery/dist/jquery.min.js',
  './node_modules/bootstrap/dist/js/bootstrap.min.js',
  './node_modules/angular/angular.min.js',
  './node_modules/angular-route/angular-route.min.js',
  // './src/app/controllers/*.js',
  // './src/app/services/*.js',
  // './src/app/app.js',
  // './src/js/**/*.js'
];

var scssSrc = [
  './web-src/sass/**/*.scss',
  './web-src/sass/**/_*.scss'
];

var cssSrc = [
  './node_modules/bootstrap/dist/css/bootstrap-flex.min.css',
  './web-src/css/**/*.css'
];

// sass
gulp.task('sass', function () {
  gulp.src(scssSrc)
    .pipe(sass({
      noCache: true,
      style: "expanded",
      lineNumbers: true,
      loadPath: './web-src/sass/*'
    }))
    .pipe(gulp.dest('./src/css'));
});

// css
gulp.task('css', function(){
  gulp.src(cssSrc)
    .pipe(minify())
    .pipe(concat('styles.min.css'))
    .pipe(gulp.dest('./angular/css'))
});

// uglify
gulp.task('js', function() {
  gulp.src(jsSrc)
    .pipe(gulpif('*.js', uglify()))
    .pipe(concat("libs.min.js"))
    .pipe(gulp.dest('./angular/js/libs'));
});

// images
gulp.task('images', function() {
    gulp.src('web-src/img/*')
      .pipe(imagemin())
      .pipe(gulp.dest('./angular/img'))
  }
);

gulp.task('watch', function() {
  // watch scss files
  gulp.watch(scssSrc, ['sass']);

  // watch css files
  gulp.watch('./web-src/css/**/*.css', ['css']);

  // watch js files
  gulp.watch(jsSrc, ['js']);

  // watch images files
  gulp.watch(['web-src/img/*'], ['images']);
});

gulp.task('default', function () {
  var tasks = ['sass', 'css', 'js', 'images'];

  tasks.forEach(function (val) {
    gulp.start(val);
  });
});