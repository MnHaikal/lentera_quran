<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminAyahUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'teks_arab' => ['required', 'string'],
            'teks_latin' => ['required', 'string'],
            'terjemahan' => ['required', 'string'],
            'juz' => ['required', 'integer', 'min:1', 'max:30'],
            'halaman' => ['nullable', 'integer', 'min:1', 'max:604'],
            'audio_url' => ['nullable', 'url', 'max:255'],
        ];
    }
}

