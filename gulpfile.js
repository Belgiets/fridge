var gulp = require('gulp'),
  minify = require('gulp-clean-css'),
  uglify = require('gulp-uglify'),
  concat = require('gulp-concat'),
  watch = require('gulp-watch'),
  sass = require('gulp-sass'),
  imagemin = require('gulp-imagemin'),
  gulpif = require('gulp-if'),
  clean = require('gulp-clean');

var jsSrc = [
  './node_modules/tether/dist/js/tether.min.js',
  './node_modules/jquery/dist/jquery.min.js',
  './node_modules/jquery-ui-dist/jquery-ui.min.js',
  './node_modules/bootstrap/dist/js/bootstrap.min.js',
  './web-src/js/main.js'
];

var scssSrc = [
  './web-src/sass/*.scss',
  './web-src/sass/_*.scss'
];

var cssSrc = [
  './node_modules/bootstrap/dist/css/bootstrap.min.css',
  './node_modules/jquery-ui-dist/jquery-ui.min.css',
  './web-src/css/*.css'
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
    .pipe(gulp.dest('./web-src/css'));
});

// css
gulp.task('css', function () {
  gulp.src(cssSrc)
    .pipe(gulpif('*.css', minify()))
    .pipe(concat('styles.min.css'))
    .pipe(gulp.dest('./web/css'))
});

// uglify
gulp.task('js', function () {
  gulp.src(jsSrc)
    .pipe(gulpif('*.js', uglify()))
    .pipe(concat("main.min.js"))
    .pipe(gulp.dest('./web/js'));
});

// images
gulp.task('images', function () {
  gulp.src('web-src/img/*')
    .pipe(imagemin())
    .pipe(gulp.dest('./web/img'))

  gulp.src('node_modules/jquery-ui-dist/images/*')
    .pipe(imagemin())
    .pipe(gulp.dest('./web/css/images'))
});

gulp.task('fonts', function () {
  gulp.src('./node_modules/bootstrap/fonts/*')
    .pipe(imagemin())
    .pipe(gulp.dest('./web/fonts'))
});

gulp.task('clean', function () {
  return gulp.src(['web/css/*', 'web/js/libs/*'])
    .pipe(clean());
});

gulp.task('watch', function () {
  // watch scss files
  gulp.watch(scssSrc, ['sass']);

  // watch css files
  gulp.watch('./web-src/css/**/*.css', ['css']);

  // watch js files
  gulp.watch(jsSrc, ['js']);

  // watch images files
  gulp.watch(['web-src/img/*'], ['images']);
});

gulp.task('default', ['clean'], function () {
  var tasks = ['sass', 'css', 'js', 'images', 'fonts'];

  tasks.forEach(function (val) {
    gulp.start(val);
  });
});