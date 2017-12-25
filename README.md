# CMYii CMS

CMYii - is CMS admin system based on Yii Framework 2.

CMYii provides only a framework for management with data, you need to implement the data blocks yourself.

This module provides the admin system itself.

## Demo

[http://cmyii.paulzi.ru/admin](http://cmyii.paulzi.ru/admin)

## Install

```bash
composer require paulzi/cmyii
```

## Usage


### Apply migrations

Apply migrations in `migrations` folder. To do this, use one of the following methods:

1) Add `paulzi\cmyii\migrations` namespace to your console app:

```php
return [
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => null,
            'migrationNamespaces' => [
                'console\migrations',
                'paulzi\cmyii\migrations',
            ],
        ],
    ],
]
```

2) Run command:

```bash
./yii migrate --migrationPath= --migrationNamespaces=paulzi\cmyii\migrations
```

Specify in the configs of the application:

```php
return [
    'bootstrap' => ['cmyii'],
    'modules' => [
        'cmyii' => [
            'class' => 'paulzi\cmyii\Cmyii',
        ],
        'admin' => [
            'class' => 'paulzi\cmyii\admin\CmyiiAdmin',
            'adminBlocks' => [
                'common\cmyii\text\TextAdminWidget',
            ],
        ],
    ],
];
```

### Add area in layout

Add Area widgets in your layout:

```php
<?= \paulzi\cmyii\widgets\Area::widget(['id' => 'main']) ?>
```

### Configure RBAC

[Configure RBAC](http://www.yiiframework.com/doc-2.0/guide-security-authorization.html#rbac) and add `admin` role. 

### Implement block widget

See in [`example` folder](https://github.com/paulzi/cmyii/blob/master/example) for text block widget sample.

Add your first layout and site (example `domains`: `http?://*`).

Include widget in `adminBlocks` section of config module.

### Go to admin

Follow to URL `http://yourdomain/admin/` and add block on page.

## Documentation

To do