<?php

namespace App\Services;

class AnotherDependency
{
    public function print()
    {
        return 'test DI: ' . __CLASS__;
    }
}
