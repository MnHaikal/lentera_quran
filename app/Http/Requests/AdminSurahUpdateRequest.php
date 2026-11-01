<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\RevelationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminSurahUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'nama_arab' => ['required', 'string', 'max:50'],
            'nama_latin' => ['required', 'string', 'max:60'],
            'arti' => ['required', 'string', 'max:100'],
            'tempat_turun' => ['required', Rule::enum(RevelationType::class)],
            'deskripsi' => ['nullable', 'string'],
            'audio_url' => ['nullable', 'url', 'max:255'],
        ];
    }
}

