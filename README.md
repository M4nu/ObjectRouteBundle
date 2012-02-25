M4nuObjectRouteBundle
======================

This Symfony2 bundle allows to create routes from an object instead of parameters.

[![Build Status](https://secure.travis-ci.org/M4nu/M4nuObjectRouteBundle.png)](http://travis-ci.org/M4nu/M4nuObjectRouteBundle)

#How to install ?

##Add theses lines into your deps

```
[M4nuObjectRouteBundle]
    git=git://github.com/M4nu/M4nuObjectRouteBundle.git
    target=/bundles/M4nu/ObjectRouteBundle
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

#Examples

Let's say we have a Category and a Message object :

```php
$category = new Category();
$category->setSlug('my-category');

$message = new Message();
$message->setSlug('my-message');
$message->setCategory($category);
```

And the corresponding route :

```yaml
message_show:
    pattern:   /message/{category.slug}/{slug}
```

## Create the corresponding route

```php
$router->generate('message_show', $message);
```

```twig
{{ path('message_show', message) }}
```

Will output: ``/message/my-category/my-message``

## Override parameters
```php
$router->generate('message_show', array('_object' => $message, 'slug' => 'my-custom-slug'));
```

```twig
{{ path('message_show', {'_object': message, 'slug': 'my-custom-slug'}) }}
```

Will output: ``/message/my-category/my-custom-slug``
