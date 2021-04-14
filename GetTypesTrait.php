<?php

namespace SunnyFlail\Traits;

use \ReflectionParameter;
use \ReflectionProperty;
use \ReflectionFunctionAbstract;
use \ReflectionUnionType;

trait GetTypesTrait
{

    /**
     * Returns array containing string names of types of property / parameter / function returned values
     * 
     * @param ReflectionParameter|ReflectionProperty|ReflectionFunctionAbstract $reflection
     * @return array<string>
    */
    public function getTypeStrings(
        ReflectionParameter|ReflectionProperty|ReflectionFunctionAbstract $reflection
    ): array
    {
        $types = $reflection instanceof ReflectionFunctionAbstract ? $reflection->getReturnType() : $reflection->getType();

        if (is_null($types))
        {
            return [];
        }

        if ($types instanceof ReflectionUnionType)
        {
            $types = $types->getTypes();
            return array_map(fn($type) => $type->getName(), $types);
        }

        $returnedArray = [];

        if ($types->allowsNull())
        {
            $returnedArray[] = 'null';
        }

        $returnedArray[] = $types->getName();

        return $returnedArray;
    }

}