<?php

namespace M4nu\ObjectRouteBundle\Tests\Component\Routing\Generator;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;

use M4nu\ObjectRouteBundle\Component\Routing\Generator\UrlGenerator;

class UrlGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testRoute()
    {
        $routes = new RouteCollection();
        $routes->add('bye', new Route('/bye'));

        $generator = new UrlGenerator($routes, new RequestContext());

        $this->assertEquals('/bye', $generator->generate('bye'));
    }

    public function testRouteWithParameters()
    {
        $routes = new RouteCollection();
        $routes->add('hello', new Route('/hello/{name}', array('name' => 'World')));

        $generator = new UrlGenerator($routes, new RequestContext());

        $this->assertEquals('/hello', $generator->generate('hello'));
        $this->assertEquals('/hello/test', $generator->generate('hello', array('name' => 'test')));
    }

    public function testRouteWithObject()
    {
        $routes = new RouteCollection();
        $routes->add('object', new Route('/object/{slug}/{id}'));

        $generator = new UrlGenerator($routes, new RequestContext());

        $this->assertEquals('/object/nice-slug/20', $generator->generate('object', $this->getObject()));
    }

    public function testRouteWithObjectParameter()
    {
        $routes = new RouteCollection();
        $routes->add('object', new Route('/object/{slug}/{id}'));

        $generator = new UrlGenerator($routes, new RequestContext());

        $this->assertEquals('/object/nice-slug/20', $generator->generate('object', array('_object' => $this->getObject())));
    }

    public function testRouteWithInvalidObjectParameter()
    {
        $this->setExpectedException('\InvalidArgumentException');

        $routes = new RouteCollection();
        $routes->add('object', new Route('/'));

        $generator = new UrlGenerator($routes, new RequestContext());
        $generator->generate('object', array('_object' => false));
    }

    public function testRouteWithObjectAndRelation()
    {
        $route = new Route('/object/{slug}/{category.slug}');
        $route->setOption('compiler_class', 'M4nu\\ObjectRouteBundle\\Component\\Routing\\RouteCompiler');

        $routes = new RouteCollection();
        $routes->add('object', $route);

        $generator = new UrlGenerator($routes, new RequestContext());

        $this->assertEquals('/object/nice-slug/cool-category-slug', $generator->generate('object', $this->getObject()));
    }

    public function testRouteWithObjectAndParameters()
    {
        $route = new Route('/object/{slug}');

        $routes = new RouteCollection();
        $routes->add('object', $route);

        $generator = new UrlGenerator($routes, new RequestContext());

        $this->assertEquals('/object/forced-slug', $generator->generate('object', array(
            '_object' => $this->getObject(),
            'slug' => 'forced-slug',
        )));
    }

    protected function getObject()
    {
        $category = new \StdClass;
        $category->slug = 'cool-category-slug';

        $object = new \StdClass;
        $object->id       = 20;
        $object->slug     = 'nice-slug';
        $object->category = $category;

        return $object;
    }
}
