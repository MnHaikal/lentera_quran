<?php

namespace App\Http\Requests\Auth\Concerns;

use Illuminate\Support\Str;

trait NormalizesEmail
{
    protected function normalizeEmail(): void
    {
        if ($this->has('email') && is_string($this->input('email'))) {
            $this->merge([
                'email' => Str::lower(trim($this->input('email'))),
            ]);
        }
    }
}

