MATA CMS Carousel
==========================================

![MATA CMS Module](https://s3-eu-west-1.amazonaws.com/qi-interactive/assets/mata-cms/gear-mata-logo%402x.png)


Carousel module allows manage carousels with photo and video items.


Installation
------------

- Add the module using composer:

```json
"matacms/matacms-carousel": "~1.0.0"
```

-  Run migrations
```
php yii migrate/up --migrationPath=@vendor/matacms/matacms-carousel/migrations
```


Client
------

Carousel Client extends [`matacms\clients`](https://github.com/qi-interactive/matacms-base/blob/master/clients/SimpleClient.php).

In addition, it exposes the following methods:

```php
public function findByRegion($region) {}
```
Returns Carousel for a given region.


Changelog
---------

## 1.0.5.4-alpha, October 30, 2015

- Fixed matacms\carousel\widgets\carousel\CarouselAsset

## 1.0.5.3-alpha, October 8, 2015

- Migration fixed

## 1.0.5.2-alpha, October 8, 2015

- Added matacms-language

## 1.0.5.1-alpha, October 7, 2015

- Updated psr-4

## 1.0.5-alpha, June 24, 2015

- Fixed predefined carousel item creation with Media

## 1.0.4-alpha, May 28, 2015

- Removed versions
- Removed delete button from Production (!YII_DEBUG)
- Added missing overlay for revisions in carousel manager

## 1.0.3-alpha, May 27, 2015

- Bug fix

## 1.0.2-alpha, May 26, 2015

- Updated header for managing carousel items
- Shown Add Crousel button to dev mode only

## 1.0.1-alpha, May 22, 2015

- Bug fixes.

## 1.0.0-alpha, May 18, 2015

- Initial release.
