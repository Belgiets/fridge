var gulp = require('gulp');
var minify = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var watch = require('gulp-watch');
var sass = require('gulp-sass');
var imagemin = require('gulp-imagemin');

var jsSrc = [
  './node_modules/bootstrap/dist/js/bootstrap.min.js',
  './src/js/**/*.js'
];

var scssSrc = [
  './src/sass/**/*.scss',
  './src/sass/**/_*.scss'
];

var cssSrc = [
  './node_modules/bootstrap/dist/css/bootstrap-flex.min.css',
  './src/css/**/*.css'
];

// sass
gulp.task('sass', function () {
    gulp.src(scssSrc)
        .pipe(sass({
            noCache: true,
            style: "expanded",
            lineNumbers: true,
            loadPath: './src/sass/*'
        }))
        .pipe(gulp.dest('./src/css'));
});

// css
gulp.task('css', function(){
    gulp.src(cssSrc)
        .pipe(minify())
        .pipe(concat('styles.min.css'))
        .pipe(gulp.dest('./public/css'))
});

// uglify
gulp.task('js', function() {
    gulp.src(jsSrc)
        .pipe(uglify())
        .pipe(concat("app.min.js"))
        .pipe(gulp.dest('./public/js'));
});

// images
gulp.task('images', function() {
        gulp.src('src/img/*')
            .pipe(imagemin())
            .pipe(gulp.dest('./public/img'))
    }
);

gulp.task('watch', function() {
    // watch scss files
    gulp.watch(scssSrc, ['sass']);

    // watch css files
    gulp.watch('./src/css/**/*.css', ['css']);

    // watch js files
    gulp.watch(jsSrc, ['js']);

    // watch images files
    gulp.watch(['src/img/*'], ['images']);
});