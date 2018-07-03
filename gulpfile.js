const gulp = require('gulp')
const sass = require('gulp-sass')
const sourcemaps = require('gulp-sourcemaps')
const cleanCSS = require('gulp-clean-css')
const plumber = require('gulp-plumber')

gulp.task('default', function() {
  return gulp.src(['./scss/style.scss', './scss/admin.scss'])
	  .pipe(plumber())
		.pipe(sourcemaps.init())
	  .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
		.pipe(sourcemaps.write())
		.pipe(cleanCSS({compatibility: 'ie8'}))
    .pipe(gulp.dest('./'));
});
