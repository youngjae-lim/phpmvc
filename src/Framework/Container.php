<?php

namespace Framework;

use Closure;
use ReflectionClass;

class Container
{
    private array $registry = [];

    /**
     * Register an object instance in the container
     */
    public function set(string $name, Closure $value): void
    {
        $this->registry[$name] = $value;
    }

    /**
     * Get an object instance of the given class name and inject any dependencies
     */
    public function get(string $className): object
    {
        if (array_key_exists($className, $this->registry)) {
            return $this->registry[$className]();
        }

        $reflector = new ReflectionClass($className);
        $constructor = $reflector->getConstructor();

        $dependencies = [];

        if ($constructor === null) {

            return new $className;
        }

        foreach ($constructor->getParameters() as $parameter) {
            $type = (string) $parameter->getType();

            // Recursively get the dependencies of the dependencies
            $dependencies[] = $this->get($type);

        }

        return new $className(...$dependencies);
    }
}
