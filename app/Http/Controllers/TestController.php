<?php

namespace App\Http\Controllers;

use App\Services\AnotherService;
use App\Services\SomeService;

// Testing Container and Router
class TestController
{
    public function __construct(
        private AnotherService $anotherService,
        private SomeService $someService) {
    }

    public function testOne()
    {
        echo <<<FORM
<form action="/hmm" method="post">
  <label for="fname">First name:</label><br>
  <input type="text" id="fname" name="fname" value="John"><br>
  <label for="lname">Last name:</label><br>
  <input type="text" id="lname" name="lname" value="Doe"><br><br>
  <input type="submit" value="Submit">
</form>
FORM;
        echo $this->anotherService->print();
        echo $this->someService->print();
    }

    public function testTwo()
    {
        echo 'Test 2';
    }

    public function another()
    {
        echo 'another';
    }
}
