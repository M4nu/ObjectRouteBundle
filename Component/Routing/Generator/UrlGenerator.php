<?php

namespace M4nu\ObjectRouteBundle\Component\Routing\Generator;

use Symfony\Component\Form\Util\PropertyPath;
use Symfony\Component\Form\Exception\FormException;
use Symfony\Component\Routing\Generator\UrlGenerator as BaseUrlGenerator;

class UrlGenerator extends BaseUrlGenerator
{
    protected function doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $absolute)
    {
        if (is_object($parameters)) {
            $object     = $parameters;
            $parameters = array();
        } elseif (isset($parameters['_object'])) {
            if (!is_object($parameters['_object'])) {
                throw new \InvalidArgumentException(sprintf(
                    'Invalid type for parameter "_object". Expected object, but got %s.',
                    gettype($parameters['_object'])
                ));
            }

            $object = $parameters['_object'];
            unset($parameters['_object']);
        }

        if (isset($object)) {
            $remainingParams = array_diff($variables, array_keys($parameters));

            foreach ($remainingParams as $name) {
                $path = new PropertyPath($name);

                try {
                    $parameters[$name] = $path->getValue($object);
                } catch (FormException $e) {}
            }
        }

        return parent::doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $absolute);
    }
}
