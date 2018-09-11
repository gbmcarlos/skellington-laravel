# What's this?
This skeleton allows to have a working Laravel application running inside a Docker container completely out of the box, and configurable through environment variables.

## Features
* Run as a [Docker](https://docs.docker.com/) container: one dependency, one tool, Docker.
* [Laravel 5.6](https://laravel.com/docs/5.6) application.
* Xdebug support
* `up.sh` and `local.up.sh` included: get the application running anywhere with the simple command `./deploy/up.sh` or `./deploy/local.up.sh`
* Production-ready: Optimize Composer's autoload, optimize assets compilation, add HTTP Basic Authentication, set PHP configuration values [the right way](https://www.phptherightway.com/#error_reporting) or enable [OPCache](https://secure.php.net/book.opcache).
* Configure your build by using simple environment variables

## How to install it
* This skeleton is available as a [composer package in packagist.org](https://packagist.org/packages/gbmcarlos/skellington), so you only need to run `composer create-project --remove-vcs --no-install --ignore-platform-reqs gbmcarlos/skellington target-directory 3.1.*` with the name of the folder where you want to create the project
* After that, just `cd` into the project folder and start a new repository with `git init` and add your new remote with `git remote add origin {new_remote}`
* Start working

## Requirements
* Docker
* To install it in the way stated above you will need PHP and Composer. ([Here](https://getcomposer.org/download/)'s how to get composer)

## Environment variables available
These environment variables are used and given a default value only in the `up.sh` and `local.up.sh` scripts as part of the docker `build` and `run` commands. If you build the docker image and run the docker container on your own, make sure to pass the values to those commands accordingly.

|       ENV VAR        |                 Default value                 | Description |
| -------------------- | --------------------------------------------- | ----------- |
| PROJECT_NAME         | Name of the project's root folder             | Used to name the docker image and docker container from the `up.sh` files |
| HOST_PORT            | 80                                            | The port Docker will use as the host port in the network bridge. This is the external port, the one your app will be called through |
| OPTIMIZE_PHP         | `true` for `up.sh`, `false` for `local.up.sh` | Set PHP's configuration values about error reporting and display [the right way](https://www.phptherightway.com/#error_reporting) and enables [OPCache](https://secure.php.net/book.opcache) (build argument only) |
| OPTIMIZE_COMPOSER    | `true` for `up.sh`, `false` for `local.up.sh` | Optimize Composer's autoload with [Optimization Level 2/A](https://getcomposer.org/doc/articles/autoloader-optimization.md#optimization-level-2-a-authoritative-class-maps) (build argument only) |
| OPTIMIZE_ASSETS      | `true` for `up.sh`, `false` for `local.up.sh` | Optimize assets compilation (build argument only) |
| BASIC_AUTH_ENABLED   | `true` for `up.sh`, `false` for `local.up.sh` | Enable Basic Authentication with Apache (Persisted environment variable) |
| BASIC_AUTH_USER      | admin                                         | If `BASIC_AUTH_ENABLED` is `true`, this will be used to run `htpasswd` together with `BASIC_AUTH_PASSWORD` to encrypt with bcrypt (cost 10) (build argument only) |
| BASIC_AUTH_PASSWORD  | `PROJECT_NAME`_password                       | If `BASIC_AUTH_ENABLED` is `true`, this will be used to run `htpasswd` together with `BASIC_AUTH_USER` to encrypt with bcrypt (cost 10) (build argument only) |
| XDEBUG_ENABLED       | `false` for `up.sh`, `true` for `local.up.sh` | Enables Xdebug inside the container. (build argument only) |
| XDEBUG_REMOTE_HOST   | 10.254.254.254                                | Used as the `xdebug.remote_host` PHP ini configuration value (build argument only) |
| XDEBUG_REMOTE_PORT   | 9000                                          | Used as the `xdebug.remote_port` PHP ini configuration value (build argument only) |
| XDEBUG_IDE_KEY       | `PROJECT_NAME`_PHPSTORM                       | Used as the `xdebug.idekey` PHP ini configuration value (build argument only) |

Example:
`HOST_PORT=8000 BASIC_AUTH_ENABLED=true BASIC_AUTH_USER=user BASIC_AUTH_PASSWORD=secure_password XDEBUG_ENABLED=true ./deploy/local.up.sh`

## Built-in Stack
* [Alpine Linux 3.8 (:stretch slim)](https://hub.docker.com/_/alpine/)
* [Nginx 1.14.1](http://nginx.org/)
* [PHP 7.2.8 (:7.2-fpm-alpine)](https://hub.docker.com/_/php/)
* [Xdebug 2.6.1](https://xdebug.org/)
* [Laravel 5.6](https://laravel.com/docs/5.6/)
* [Node.js 8.11.4](https://nodejs.org/en/docs/)

## License
This project is licensed under the terms of the [MIT license](https://opensource.org/licenses/MIT).