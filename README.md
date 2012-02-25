M4nuObjectRouteBundle
======================

This Symfony2 bundle allows to create routes from an object instead of parameters.

[![Build Status](https://secure.travis-ci.org/M4nu/M4nuObjectRouteBundle.png)](http://travis-ci.org/M4nu/M4nuObjectRouteBundle)

#How to install ?

##Add theses lines into your deps

```
[M4nuObjectRouteBundle]
    git=git://github.com/M4nu/M4nuObjectRouteBundle.git
    target=/bundles/M4nu/M4nuObjectRouteBundle
```

##Add autoloading

```php
#app/autoload.php
$loader->registerNamespaces(array(
    #...
    'M4nu' => __DIR__.'/../vendor/bundles',
));
```

##Register this bundle

```php
#app/AppKernel.php
$bundles = array(
    #...
    new M4nu\ObjectRouteBundle\M4nuObjectRouteBundle(),
);
```

##Install the deps

```shell
php bin/vendors install
```
