<?php

namespace App\Trait;

use Illuminate\Database\Eloquent\Builder;

trait HasSearch
{
    public function search(string $question, string $queryColumn, Builder $query, string $errorMessage, bool $required = true)
    {
        $value = $this->choice(
            $question,
            $query->pluck($queryColumn, 'slug')->toArray(),
            multiple: true
        );

        if (!$value) {
            die;
        }

        $model = $query->where($queryColumn, $value)->first();

        if (!$model) {
            $this->errorAndDie($errorMessage);
        }

        return $model;
    }
}
