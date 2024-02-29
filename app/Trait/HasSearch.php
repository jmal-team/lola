<?php

namespace App\Trait;

use Illuminate\Database\Eloquent\Builder;

trait HasSearch
{
    use HasError;

    public function search(string $question, string $queryColumn, Builder $query, string $errorMessage, bool $required = true)
    {
        $value = $this->choice(
            $question,
            $query->pluck($queryColumn, 'slug')->toArray(),
            multiple: true
        );

        if (!$value) {
            exit;
        }

        $model = $query->whereIn('slug', $value)->get();

        if (!$model) {
            $this->errorAndDie($errorMessage);
        }

        return $model;
    }
}
