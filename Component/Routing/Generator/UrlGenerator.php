<?php

namespace M4nu\ObjectRouteBundle\Component\Routing\Generator;

use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Generator\UrlGenerator as BaseUrlGenerator;

class UrlGenerator extends BaseUrlGenerator
{
    protected function doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens)
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

            $propertyAccessor = PropertyAccess::createPropertyAccessor();

            foreach ($remainingParams as $name) {
                try {
                    $parameters[$name] = $propertyAccessor->getValue($object, $name);
                } catch (NoSuchPropertyException $e) {}
            }
        }

        return parent::doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens);
    }
}
