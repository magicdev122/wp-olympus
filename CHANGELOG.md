## v0.0.34 (December 28, 2022)
![][added] Add new constants.
![][updated] Update displayError() calls and default WordPress ABSPATH constant.
![][updated] Update the Debugger call.

## v0.0.33 (June 28, 2022)
![][fixed] Fix array to bool conversion on Processor handler.

## v0.0.32 (June 19, 2022)
![][fixed] Fix required file on Processor handler.

## v0.0.31 (June 19, 2022)
![][fixed] Fix `.htaccess.dist` file contents.  
![][fixed] Fix Processor handler via composer.

## v0.0.30 (February 12, 2022)
![][added] Add a better CHANGELOG display.  
![][added] Add new `--no-interaction` command compatibility to work with automatic deploy scripts.  
![][fixed] Fix composer integration.

## v0.0.29 (February 5, 2022)
![][fixed] Fix the `siteurl` and `home` multisite options with HTTPS protocol.  
![][updated] Update composer command lines and default WordPress theme.  
![][updated] Update TwentyTwentyTwo theme from composer.

## v0.0.28 (January 2, 2022)
![][fixed] Fix the `siteurl` multisite option by adding the `WORDPRESSDIR` constant.

## v0.0.27 (March 6, 2021)
![][added] Auto detect https use from site url.  
![][added] Add options to fully customize WordPress installation, as multisite or single site.  
![][added] Make themes directory overridable through `get_template_directory()` and `get_template_directory_uri()` functions.

## v0.0.26 (December 25, 2020)
![][fixed] Fix `Configurator` and `Processor` Handler components.

## v0.0.25 (April 08, 2020)
![][updated] Update composer and autoload.

## v0.0.24 (March 25, 2020)
![][added] Add new Olympus components integration.

## v0.0.23 (January 12, 2020)
![][updated] Update TwentyTwenty theme from composer.

## v0.0.22 (December 11, 2019)
![][updated] Update `ErrorDebugger` class with error file rotation.

## v0.0.21 (July 16, 2018)
![][added] Add `opts.php` file.  
![][added] New PHPCS validation.

## v0.0.20 (March 24, 2018)
![][updated] PHPCS validation.

## v0.0.19 (March 24, 2018)
![][added] Log file integration with Whoops package.  
![][updated] Update required PHP version.

## v0.0.18 (March 23, 2018)
![][updated] Update main package with new Whoops integration.

## v0.0.17 (February 03, 2017)
![][updated] Update composer components with Guzzle.

## v0.0.16 (December 17, 2016)
![][added] Replace TwentySixteen theme with the new TwentySeventeen.  
![][updated] Update `Handler` component to make install more efficient.

## v0.0.15 (November 14, 2016)
![][added] Add `web/resources/dist/fonts` folder.

## v0.0.14 (October 22, 2016)
![][updated] Update `web/resources/dist` folder contents.

## v0.0.13 (October 21, 2016)
![][added] Add `DISTPATH` static to be used in Olympus Hera or other packages.

## v0.0.12 (October 21, 2016)
![][updated] Update `.gitignore` files, add new `/web/resources/dist` folder for packages assets.

## v0.0.11 (October 09, 2016)
![][fixed] Fix composer missing bash command line.

## v0.0.10 (October 08, 2016)
![][added] Add new Cache folder variable, fix composer bash command lines update composer vendors.

## v0.0.9 (September 28, 2016)
![][updated] Update `composer.json` file, add `.gitkeep` file.

## v0.0.8 (May 20, 2016)
![][added] Add an `own.php` file for your own custom constants.  
![][added] Add the `robots.txt` process into composer and symlink to `xmlrpc.php` file.

## v0.0.7 (May 14, 2016)
![][added] Adds Olympus Hera integration.  
![][fixed] Fix bugs via PHPCS integration.

## v0.0.6 (April 23, 2016)
![][added] Travis and PHPCS integration.  
![][added] New Error debugger with Whoops and File logger with Monolog.  
![][added] New Olympus Hera mu-plugin integration.

## v0.0.5 (April 13, 2016)
![][added] Travis and PHPCS integration.

## v0.0.4 (April 12, 2016)
Please welcome Must Use Plugins :)  
![][added] In this new version, PHPCS recommandations have been followed.  
![][added] A new `MuPlugins Autoloader` class has been written.  
![][added] The wonderful WP-API Rest plugin is included as a mu-plugins.  
![][added] And capistrano processes has been written.

## v0.0.3 (April 08, 2016)
I've been working hard to make Composer install more efficient for developers :)  
![][added] Configuration files are auto-generated via composer install command.

## v0.0.2 (March 29, 2016)
_It's been a while..._  
![][added] Capistrano integration is now available. Not yet full optimised, but works efficiently.

## v0.0.1 (January 09, 2016)
**INITIAL RELEASE**

<!-- links & imgs dfn's -->
[added]: https://img.shields.io/badge/ADDED-27bd07.svg?style=flat-square
[fixed]: https://img.shields.io/badge/FIXED-f0506e.svg?style=flat-square
[updated]: https://img.shields.io/badge/UPDATED-115cfa.svg?style=flat-square
