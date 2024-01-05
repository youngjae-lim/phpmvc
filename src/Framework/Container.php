<?php

// Must be at the top of the file. This will enable strict typing mode.
declare(strict_types=1);

namespace Framework;

use Closure;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionNamedType;

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
        // Check if the class name is registered in the container, if so, invoke the closure to get the object instance
        if (array_key_exists($className, $this->registry)) {
            return $this->registry[$className]();
        }

        $reflector = new ReflectionClass($className);
        $constructor = $reflector->getConstructor();

        $dependencies = [];

        // Check if the class has a constructor
        if ($constructor === null) {

            return new $className;
        }

        // Get the constructor parameters
        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();

            // Check if the constructor parameter has a type declaration
            if ($type === null) {
                throw new InvalidArgumentException("Constructor parameter '{$parameter->getName()}' in the $className class has no type declaration");
            }

            // Check if the type is a named type
            if (! $type instanceof ReflectionNamedType) {
                throw new InvalidArgumentException("Constructor parameter '{$parameter->getName()}' in the $className class is an invalid type: '$type' - only single named types supported");
            }

            // Check if the type is a built-in type like string, int, etc in PHP
            if ($type->isBuiltin()) {
                throw new InvalidArgumentException("Unable to resolve constructor parameter '{$parameter->getName()}' of type '$type' in the $className class");
            }

            // Recursively get the dependencies of the dependencies
            $dependencies[] = $this->get((string) $type);

        }

        // Create a new instance of the class and inject the dependencies and return it
        return new $className(...$dependencies);
    }
}
