<?php

namespace M4nu\ObjectRouteBundle\Component\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader as BaseDelegatingLoader;

/**
 * DelegatingLoader delegates route loading to other loaders using a loader resolver.
 */
class DelegatingLoader extends BaseDelegatingLoader
{
    /**
     * {@inheritDoc}
     */
    public function load($resource, $type = null)
    {
        $collection = parent::load($resource, $type);

        foreach ($collection->all() as $route) {
            $route->setOption('compiler_class', 'M4nu\\ObjectRouteBundle\\Component\\Routing\\RouteCompiler');
        }

        return $collection;
    }
}
