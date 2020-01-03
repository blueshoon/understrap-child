// Defining requirements
var autoprefixer = require( 'gulp-autoprefixer' );
var babel = require('gulp-babel');
var browserSync = require( 'browser-sync' ).create();
var concat = require( 'gulp-concat' );
var del = require( 'del' );
var gulp = require( 'gulp' );
var rename = require('gulp-rename');
var rev = require('gulp-rev');
var sass = require( 'gulp-sass' );
var sourcemaps = require( 'gulp-sourcemaps' );
var uglify = require( 'gulp-uglify' );

// Configuration file to keep your code DRY
var cfg = require( './gulpconfig.json' );
var paths = cfg.paths;

// Run:
// gulp sassDev
// Compiles SCSS files in CSS
// Includes sourcemaps, non compressed for development
gulp.task( 'sassDev', function() {
    var stream = gulp.src( `${paths.sass}/*.scss` )
        .pipe( sourcemaps.init( { loadMaps: true } ) )
		.pipe(sass().on('error', sass.logError))
		.pipe(autoprefixer({
            cascade: false,
			grid: true
        }))
        .pipe( sourcemaps.write( './' ) )
        .pipe(rev())
        .pipe( gulp.dest( paths.css ) )
        .pipe(rev.manifest(paths.dist + '/rev-manifest.json', {
            base: paths.dist,
            merge: true
        }))
        .pipe(gulp.dest(paths.dist));
    return stream;
});

// Run:
// gulp sass
// Compiles SCSS files in CSS
gulp.task( 'sass', function() {
    var stream = gulp.src( `${paths.sass}/child-theme.scss` )
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(autoprefixer({
            cascade: false,
			grid: true
        }))
        .pipe(rev())
        .pipe( gulp.dest( paths.css ) )
        .pipe(rev.manifest(paths.dist + '/rev-manifest.json', {
            base: paths.dist,
            merge: true
        }))
        .pipe(gulp.dest(paths.dist));
        return stream;
});

/* Function to build processed css file for admin */
gulp.task( 'adminsass', function() {
    var stream = gulp.src( `${paths.sass}/custom-editor-style.scss` )
		.pipe(sass().on('error', sass.logError))
		.pipe(autoprefixer({
            cascade: false,
			grid: true
        }))
		.pipe(rename('blocks.editor.build.css'))
        .pipe(gulp.dest(`${paths.plugins}/understrap-blocks/blocks/dist`));
    return stream;
});

// Run:
// gulp watch
// Starts watcher. Watcher runs gulp sass task on changes
gulp.task( 'watch', function() {
    gulp.watch( `${paths.sass}/**/*.scss`, gulp.series('dist-clean-css', 'stylesDev') );
    gulp.watch( [`${paths.dev}/js/**/*.js`, `${paths.vendor}/js/**/*.js`], gulp.series('dist-clean-js', 'scripts') );
    gulp.watch( `${paths.plugins}/understrap-blocks/blocks/src/**/*.js`, gulp.series('pluginScripts') );
});

// gulp style tasks
gulp.task( 'stylesDev', gulp.series( 'sassDev', 'adminsass' ));
gulp.task( 'styles', gulp.series( 'sass', 'adminsass' ));

// Run:
// gulp browser-sync
// Starts browser-sync task for starting the server.
gulp.task( 'browser-sync', function() {
    browserSync.init( cfg.browserSyncWatchFiles, cfg.browserSyncOptions );
} );

// Run:
// gulp scripts.
// Uglifies and concat all JS files into one
gulp.task( 'scripts', function() {
    var scripts = [
        //Popper - bootstrap dependency
        `${paths.vendor}/js/popper.min.js`,
        // Required bootstrap js - select only neccessary items per project
        `${paths.vendor}/js/bootstrap4/util.js`,
        `${paths.vendor}/js/bootstrap4/alert.js`,
        `${paths.vendor}/js/bootstrap4/button.js`,
        `${paths.vendor}/js/bootstrap4/carousel.js`,
        `${paths.vendor}/js/bootstrap4/collapse.js`,
        `${paths.vendor}/js/bootstrap4/dropdown.js`,
        `${paths.vendor}/js/bootstrap4/modal.js`,
        `${paths.vendor}/js/bootstrap4/tooltip.js`,
        `${paths.vendor}/js/bootstrap4/popover.js`,
        `${paths.vendor}/js/bootstrap4/scrollspy.js`,
        `${paths.vendor}/js/bootstrap4/tab.js`,
        `${paths.vendor}/js/bootstrap4/toast.js`,

        //lazyload JS library for images
        `${paths.dev}/js/vendor/lazysizes.min.js`,

        // Adding currently empty javascript file to add on for your own themes' customizations
        // Please add any customizations to this .js file only!
        `${paths.dev}/js/custom.js`,
    ];

  return gulp.src( scripts, { allowEmpty: true } )
    .pipe( concat( 'child-theme.js' ) )
    .pipe( uglify() )
    .pipe(rev())
    .pipe( gulp.dest( paths.js ) )
    .pipe(rev.manifest(paths.dist + '/rev-manifest.json', {
        base: paths.dist,
        merge: true
    }))
    .pipe(gulp.dest(paths.dist));
});


gulp.task( 'pluginScripts', function() {
    return gulp.src([`${paths.plugins}/understrap-blocks/blocks/src/block/whitelist.js`])
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe(uglify({mangle: false}))
        .pipe(rename('blocks.build.js'))
		.pipe(gulp.dest(`${paths.plugins}/understrap-blocks/blocks/dist`));
});

// Run:
// gulp watch-bs
// Starts watcher with browser-sync. Browser-sync reloads page automatically on your browser
gulp.task( 'watch-bs', gulp.parallel('browser-sync', 'watch', 'scripts'));

// Run:
// gulp copy-assets.
// Copy all needed dependency assets files from bower_component assets to themes /js, /scss and /fonts folder. Run this task after bower install or bower update

////////////////// All Bootstrap SASS  Assets /////////////////////////
gulp.task( 'copy-assets', function() {

////////////////// All Bootstrap 4 Assets /////////////////////////
// Copy all JS files
    var stream = gulp.src( `${paths.node}bootstrap/js/dist/**/*.js` )
        .pipe( gulp.dest( `${paths.vendor}/js/bootstrap4` ) );

// Copy all Bootstrap SCSS files
    gulp.src( `${paths.node}bootstrap/scss/**/*.scss` )
        .pipe( gulp.dest( `${paths.vendor}/sass/bootstrap4` ) );

////////////////// End Bootstrap 4 Assets /////////////////////////

// Copy all Font Awesome Fonts
    gulp.src( `${paths.node}font-awesome/fonts/**/*.{ttf,woff,woff2,eot,svg}` )
        .pipe( gulp.dest( `${paths.theme}/assets/fonts` ) );

// Copy all Font Awesome SCSS files
    gulp.src( `${paths.node}font-awesome/scss/*.scss` )
        .pipe( gulp.dest( `${paths.vendor}/sass/fontawesome` ) );

// Copy Popper JS files
    gulp.src( `${paths.node}popper.js/dist/umd/popper.js` )
        .pipe( gulp.dest( `${paths.vendor}/js` ) );

// Copy Parent Theme files
    gulp.src( `${paths.node}understrap/**` )
        .pipe( gulp.dest( `${paths.themes}/understrap` ) );

    return stream;
});

// Deleting the files distributed by the copy-assets task
gulp.task( 'clean-vendor-assets', function() {
  return del( [`${paths.vendor}/js/bootstrap4/**`, `${paths.vendor}/sass/bootstrap4/**`, './assets/fonts/*wesome*.{ttf,woff,woff2,eot,svg}', `${paths.vendor}/sass/fontawesome/**`, `${paths.vendor}/js/popper.js`] );
});

gulp.task('dist-clean', function() {
    return del([paths.dist + '/**/*']);
});

gulp.task('dist-clean-css', function() {
    return del([paths.dist + '/css/*']);
});

gulp.task('dist-clean-js', function() {
    return del([paths.dist + '/js/*']);
});

//build for development
gulp.task( 'build-dev', gulp.series( 'dist-clean', 'stylesDev', 'scripts', 'pluginScripts' ));
//build for production
gulp.task( 'build', gulp.series( 'dist-clean', 'styles', 'scripts', 'pluginScripts' ));
