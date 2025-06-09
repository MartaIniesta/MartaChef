<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoBadWords implements Rule
{
    protected array $badWords = ['tonto', 'idiota', 'subnormal', 'mierda'];

    public function passes($attribute, $value): bool
    {
        foreach ($this->badWords as $word) {
            if (stripos($value, $word) !== false) {
                return false;
            }
        }
        return true;
    }

    public function message(): string
    {
        return 'Tu comentario contiene lenguaje inapropiado.';
    }
}
