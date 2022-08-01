<?php

namespace Core\Exceptions\Container;

use Exception;
use Psr\Container\ContainerExceptionInterface;

class ContainerException extends Exception implements ContainerExceptionInterface
{
    public function __toString(): string
    {
        return vsprintf(
            "%s in %s line %u:\n%s",
            [
                __CLASS__,
                $this->getFile(),
                $this->getLine(),
                $this->getMessage(),
            ]
        );
    }
}
