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

## 1.0.0-alpha, May 18, 2015

- Initial release.
