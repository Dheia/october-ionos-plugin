IONOS Updater for OctoberCMS
============================

![PHP Version](https://img.shields.io/badge/PHP-7.2%2B-4f5b93?style=flat-square)
![October Version](https://img.shields.io/badge/OctoberCMS-2.0%2B-DB6A26?style=flat-square)
![Plugin Version](https://img.shields.io/github/v/release/SynderDEV/october-ionos-plugin?style=flat-square&label=Version)
![Plugin License](https://img.shields.io/github/license/SynderDEV/october-ionos-plugin?style=flat-square&label=License)

A really simple plugin, which allows you to easily update your OctoberCMS websites on php-restricted 
webhosting providers, such as IONOS, using the new command `ionos:update`.


What's the difference to october:update?
----------------------------------------

The `october:update` command pass `php ...` to the `passthru` PHP function, which is completely 
cool on almost all environments and hosting provider in the world wide web. However, some providers, 
which offers an SSH access to their webhosting packages, support multiple PHP versions side-by-side 
and a few of them use a deprecated version for the standard `php` command. For example: IONOS uses 
version 4.4.9 on the default `php` command, which can easily be changed when using SSH, but not when 
PHP itself calls his own command.

The new provided `ionos:update` uses `php7.4-cli` instead of `php`, but allows you to change this 
default by adding the option `--phpv=[PHP_ENV]`. When, for whatever reason, your PHP environment 
command does not start with `php`, you can skip this check with `--skip-nophp` as well. Keep in mind 
that you MAY need to add `-cli` after the version number depending on your setup, since the update 
MAY aborts if the non-CLI / CGI version is used.


Locate Composer File
--------------------

The Composer file should be located in the root directory of your OctoberCMS website, which may 
already is. If not, you can download and install composer by executing the following commands, while 
you're in the root path of your OctoberCMS website:

```
> wget https://getcomposer.org/installer installer
> php7.4-cli installer --filename composer
``` 


Copyright & License
-------------------

Synder.IONOS is published under the MIT license.<br />
Copyright ?? 2021 Synder (info@synder.dev)
