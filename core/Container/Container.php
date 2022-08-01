<?php

namespace Core\Container;

use Closure;
use Core\Exceptions\Container\ContainerException;
use Core\Exceptions\Container\NotFoundEntryException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;
use Throwable;

class Container implements ContainerInterface
{
    /**
     *  Maps classes to instances
     *
     *  @var array<string, object> $entries
     */
    private array $entries = [];

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get(string $id)
    {
        if (! $this->has($id)) {
            throw new NotFoundEntryException(
                "Entry [$id] not found in the container"
            );
        }

        return $this->entries[$id];
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        return in_array($id, $this->entries);
    }

    public function set(string $id, Closure $callable): void
    {
        $this->entries[$id] = $callable($this);
    }

    public function resolve(string $id)
    {
        if ($this->has($id)) {
            return $this->get($id);
        }

        $class = new ReflectionClass($id);

        if(! $class->isInstantiable()) {
            throw new ContainerException(
                "Target [$id] is not instantiable"
            );
        }


        if($class->getConstructor() === null ) {
            return $class->newInstance();
        }

        $params = $class->getConstructor()->getParameters();

        if(count($params) === 0 ) {
            return $class->newInstance();
        }

        $dependencies = array_map(function(ReflectionParameter $param) use ($id) {

            $this->checkInvalidTypes($param, $id);

            return $this->resolve($param->getType()->getName());
        } , $params);

        return $class->newInstanceArgs($dependencies);
    }

    private function checkInvalidTypes(ReflectionParameter $param, string $id)
    {
        if (! $param->hasType()) {
            throw new ContainerException(
                "Failed to resolve class [$id]: parameter [{$param->getName()}] has no type hint"
            );
        }

        if ($this->isBuiltinType($param) || $param->getType() instanceof ReflectionUnionType) {
            throw new ContainerException(
                "Failed to resolve class [$id]: parameter [{$param->getName()}] has invalid type"
            );
        }
    }

    private function isBuiltinType(ReflectionParameter $param): bool
    {
         return ($param->getType() instanceof ReflectionNamedType && $param->getType()->isBuiltin());
    }

}
