<?php

namespace App\Trait;

trait HasArguments
{
    public function validateAndAsk(string $nameOfField, string $question, $default = null)
    {
        $value = $this->argument($nameOfField,);
        if (!$value) {
            $value = $this->ask($question);
        }

        return $value ?? $default;
    }

    public function askUntilExit(string $question): array
    {
        $value = null;
        $data = [];
        while (true) {
            $value = $this->ask($question);
            if (str($value)->lower()->value() == 'exit') {
                break;
            }
            $data[] = $value;
        }

        return $data;
    }
}
