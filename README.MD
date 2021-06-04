#Typestring
A simple trait for getting Reflection return types as a string
#Sample usage
```php
use SunnyFlail\Traits\GetTypesTrait;

$implementator = new class {
    use GetTypesTrait;

    public function sampleUsage()
    {
        $reflection = new ReflectionClass(PDO::class);
        $method = $reflection->getMethod("prepare");
        $param = $method->getParameters()[0];
        var_dump($this->getTypeStrings($param));
    }

};
```
