var gulp = require('gulp'),
		concat = require('gulp-concat'),
		rename = require('gulp-rename'),
		sass = require('gulp-sass'),
		uglify = require('gulp-uglify'),
		cssmin = require('gulp-cssmin'),
    autoprefixer = require('gulp-autoprefixer'),
		watch = require('gulp-watch'),
    sourcemaps = require('gulp-sourcemaps');

// dependencies task
gulp.task('vendor', function() {
	return gulp.src([
      'node_modules/velocity-animate/velocity.min.js'
    ])
    .pipe(concat('lib.js'))
    .pipe(gulp.dest('public/wp-content/themes/storefront-child/js/'));
});

// scripts task
gulp.task('scripts', function() {
  return gulp.src('src/js/**/*.js')
    .pipe(concat('main.js'))
    .pipe(gulp.dest('public/wp-content/themes/storefront-child/js/'))
    .pipe(sourcemaps.init())
    .pipe(uglify())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(sourcemaps.write("."))
    .pipe(gulp.dest('public/wp-content/themes/storefront-child/js/'));
});


// styles task
gulp.task('styles', function() {
  return gulp.src('src/sass/**/*.scss')
    .pipe(sass())
    .pipe(gulp.dest('public/wp-content/themes/storefront-child/css/'))
    .pipe(sourcemaps.init())
    .pipe(autoprefixer({browsers: ['last 3 versions']}))
    .pipe(cssmin())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(sourcemaps.write("."))
    .pipe(gulp.dest('public/wp-content/themes/storefront-child/css/'));
});

// Watch
gulp.task('watch', function() {
  gulp.watch('src/js/**/*.js', ['scripts']);
  gulp.watch('src/sass/**/*.scss', ['styles']);
});


gulp.task('default', ['vendor', 'scripts', 'styles', 'watch']);
