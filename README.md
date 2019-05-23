# Blueshoon's custom understrap-child theme
Basic child theme for UnderStrap Theme Framework based on: https://github.com/understrap/understrap

## How it works
Understrap Child Theme shares all PHP files with the parent theme and adds its own functions.php on top of the UnderStrap parent theme's functions.php.

It does not load the parent themes CSS file(s). Instead it uses Bootstrap and FontAwesome as dependencies via npm and compiles its own CSS file from it.

Understrap Child Theme uses the Enqueue method to load and sort the CSS file the correct WordPress way.

## Installation
1. Clone the default theme from the Blueshoon github account
   - `$ git clone https://github.com/blueshoon/understrap-child.git`
1. Disconnect from the git remote origin
   - `$ git remote rm origin`
1. Add your new remote origin
   - `$ git remote add origin yourNewProjectRepoUrl`
1. Install dependencies
   - [See Section below titled Installing Dependencies](#installing-dependencies)
1. Build source files
   - [See Section below titled Building](#building)
1. Go into your WordPress admin backend 
1. Go to "Appearance -> Themes"
1. Activate the UnderStrap Child theme

## Editing
Add your own CSS styles to `assets/src/sass/theme/_child_theme.scss`

To overwrite Bootstrap's default variables or add your own, just add your values to:
`assets/src/sass/theme/_child_theme_variables.scss`

Existing Bootstrap variables can be found in:
`assets/vendor/sass/bootstrap4/_variables.scss`

## Plugin Dependencies
This theme requires Advanced Custom Fields Pro for building Gutenberg blocks.  This dependency can be removed by uncommenting the following line in the theme functions file:
- `require_once('blocks/register-blocks.php');`

An additional plugin, **Understrap Blocks**, is included with this theme.  This plugin removes many of the default WordPress Gutenberg blocks.  To alter the list of allowed blocks, edit `/plugins/understrap-blocks/blocks/src/block/whitelist.js`

## Developing With NPM, Gulp, SASS and Browser Sync

### Installing Dependencies
This process installs the parent Understrap theme, Bootstrap SASS and JavaScript libraries, Font Awesome and other dependencies
- Make sure you have installed Node.js and Gulp on your computer globally
- Open your terminal and browse to the location of your UnderStrap copy
- Run: `$ npm install`

### Running
To process and compile your Sass and JavaScript files on the fly, run the command:
- `$ gulp watch`

### Building
There are two different commands for building files depending on the desired output.
- `$ gulp build-dev` will build files uncompressed and with sourcemaps
- `$ gulp build` will build files for use in production

CSS will be output to:
`assets/dist/css/child-theme.css`

JavaScript will be output to:
`assets/dist/js/child-theme.js`

## Continuous Integration
The Blueshoon Understrap Child Theme includes configurations for automatically deploying code to WP Engine via Codeship.  The deploy script can be found in `./wpengine-codeship-ci`.

### Environment Variables
To complete this set up, the following Environment variables need to be added to in Codeship
- `WPE_INSTALL_PROD` (the subdomain for the wpengine production install)
- `REPO_NAME` (the name of the repo in git)

Optionally, you can add the following variables for deploying to staging and development sites:
- `WPE_INSTALL_STAGING`
- `WPE_INSTALL_DEV`

### Deploy Script
Add the following Custom Script to the Deploy section of your Codeship project
```
chmod 555 ./wpengine-codeship-ci/deploy.sh
./wpengine-codeship-ci/deploy.sh
```

### Build Triggers
Set the builds to run for the following branches (staging and development are optional if not using those environments)
- master
- staging
- development
