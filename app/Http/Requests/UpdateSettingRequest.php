<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Theme;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'ukuran_font_arab' => ['required', 'integer', 'min:18', 'max:50'],
            'tampilkan_latin' => ['required', 'boolean'],
            'tampilkan_terjemahan' => ['required', 'boolean'],
            'tema' => ['required', Rule::enum(Theme::class)],
        ];
    }
}
