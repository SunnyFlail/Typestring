<?php declare(strict_types=1);

namespace SunnyFlail\Traits\Tests;

use \ReflectionClass;
use \PHPUnit\Framework\TestCase;
use \SunnyFlail\Traits\GetTypesTrait;


/**
 * @coversDefaultClass \SunnyFlail\Traits\GetTypesTrait
 */
final class GetTypesTest extends TestCase
{
    protected $reflector;
    protected $results;
    protected $testClass;

    public function setUp(): void
    {
        $this->reflector = $this->getMockForTrait(GetTypesTrait::class);
        $this->results = [
            'simpleTypes' => ['string'],
            'nullableSimpleTypes' => ['string', 'null'],
            'unionTypes' => ['string', 'int'],
            'nullableUnionTypes' => ['string', 'int', 'null'],
        ];

        $this->testClass = new ReflectionClass(new class('property')
        {
            public function __construct(private string $property) {}

            public function withoutTypes($argument)
            {
                return $argument;
            }

            public function withSimpleTypes(string $argument): string
            {
                return $argument;
            }

            public function withNullableSimpleTypes(?string $argument): ?string
            {
                return $argument;
            }

            public function withUnionTypes(string|int $argument): string|int
            {
                return $argument;
            }

            public function withNullableUnionTypes(string|int|null $argument): string|int|null
            {
                return $argument;
            }

        });
    }

    /**
    * @covers ::getTypeStrings
    */
    public function testWithoutParameterTypes()
    {
        $parameter = $this->testClass->getMethod('withoutTypes')->getParameters()[0];

        $return = $this->reflector->getTypeStrings($parameter);

        $this->assertEmpty(
            $return,
            sprintf("Parameter/Property without types as an argument should return null. Got: '%s'", implode(', ', $return))
        );
    }

    /**
    * @covers ::getTypeStrings
    */
    public function testWithoutReturnTypes()
    {
        $method = $this->testClass->getMethod('withoutTypes');

        $return = $this->reflector->getTypeStrings($method);

        $this->assertEmpty(
            $return,
            sprintf("Function without return types as an argument should return null. Got: '%s'", implode(', ', $return))
        );
    }

    /**
    * @covers ::getTypeStrings
    */
    public function testWithParameterSimpleTypes()
    {
        $parameter = $this->testClass->getMethod('withSimpleTypes')->getParameters()[0];

        $return = $this->reflector->getTypeStrings($parameter);
        
        $this->assertEqualsCanonicalizing(
            $this->results['simpleTypes'],
            $return,
            sprintf(
                "Parameter/Property with simple types as an argument should return '%s' !. Got: '%s'",
                implode(', ', $this->results['simpleTypes']),
                implode(', ', $return)
            )
        );
    }

    /**
    * @covers ::getTypeStrings
    */
    public function testWithReturnSimpleTypes()
    {
        $type = $this->testClass->getMethod('withSimpleTypes');

        $return = $this->reflector->getTypeStrings($type);
       
        $this->assertEqualsCanonicalizing(
            $this->results['simpleTypes'],
            $return,
            sprintf(
                "Function with simple return types as an argument should return '%s' !. Got: '%s'",
                implode(', ', $this->results['simpleTypes']),
                implode(', ', $return)
            )
        );
    }

    /**
    * @covers ::getTypeStrings
    */
    public function testWithParameterNullableSimpleTypes()
    {
        $parameter = $this->testClass->getMethod('withNullableSimpleTypes')->getParameters()[0];

        $return = $this->reflector->getTypeStrings($parameter);
        
        $this->assertEqualsCanonicalizing(
            $this->results['nullableSimpleTypes'],
            $return,
            sprintf(
                "Parameter/Property with nullable simple types as an argument should return '%s' !. Got: '%s'",
                implode(', ', $this->results['nullableSimpleTypes']),
                implode(', ', $return)
            )
        );
    }

    /**
    * @covers ::getTypeStrings
    */
    public function testWithReturnNullableSimpleTypes()
    {
        $type = $this->testClass->getMethod('withNullableSimpleTypes');

        $return = $this->reflector->getTypeStrings($type);
       
        $this->assertEqualsCanonicalizing(
            $this->results['nullableSimpleTypes'],
            $return,
            sprintf(
                "Function with nullable simple return types as an argument should return '%s' !. Got: '%s'",
                implode(', ', $this->results['nullableSimpleTypes']),
                implode(', ', $return)
            )
        );
    }

    /**
    * @covers ::getTypeStrings
    */
    public function testWithParameterUnionTypes()
    {
        $parameter = $this->testClass->getMethod('withUnionTypes')->getParameters()[0];

        $return = $this->reflector->getTypeStrings($parameter);
        
        $this->assertEqualsCanonicalizing(
            $this->results['unionTypes'],
            $return,
            sprintf(
                "Parameter/Property with union types as an argument should return '%s' !. Got: '%s'",
                implode(', ', $this->results['unionTypes']),
                implode(', ', $return)
            )
        );
    }

    /**
    * @covers ::getTypeStrings
    */
    public function testWithReturnUnionTypes()
    {
        $method = $this->testClass->getMethod('withUnionTypes');

        $return = $this->reflector->getTypeStrings($method);
       
        $this->assertEqualsCanonicalizing(
            $this->results['unionTypes'],
            $return,
            sprintf(
                "Function with nullable with union return types as an argument should return '%s' !. Got: '%s'",
                implode(', ', $this->results['unionTypes']),
                implode(', ', $return)
            )
        );
    }

    /**
    * @covers ::getTypeStrings
    */
    public function testWithParameterNullableUnionTypes()
    {
        $parameter = $this->testClass->getMethod('withNullableUnionTypes')->getParameters()[0];

        $return = $this->reflector->getTypeStrings($parameter);
        
        $this->assertEqualsCanonicalizing(
            $this->results['nullableUnionTypes'],
            $return,
            sprintf(
                "Parameter/Property with nullable simple types as an argument should return '%s' !. Got: '%s'",
                implode(', ', $this->results['nullableUnionTypes']),
                implode(', ', $return)
            )
        );
    }

    /**
    * @covers ::getTypeStrings
    */
    public function testWithReturnNullableUnionTypes()
    {
        $type = $this->testClass->getMethod('withNullableUnionTypes');

        $return = $this->reflector->getTypeStrings($type);
       
        $this->assertEqualsCanonicalizing(
            $this->results['nullableUnionTypes'],
            $return,
            sprintf(
                "Function with nullable Union return types as an argument should return '%s' !. Got: '%s'",
                implode(', ', $this->results['nullableUnionTypes']),
                implode(', ', $return)
            )
        );
    }

}
