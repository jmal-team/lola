<?php

namespace App\Trait;

trait HasError
{
    public function errorAndDie(string $error)
    {
        $this->error($error);
        die;
    }
}
