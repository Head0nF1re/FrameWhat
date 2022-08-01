<?php

namespace App\Services;

class AnotherService
{
    public function __construct(
        private AnotherDependency $anotherDependency) {
    }

    function print() {
        return 'test DI: '.__CLASS__ . $this->anotherDependency->print();
    }
}
