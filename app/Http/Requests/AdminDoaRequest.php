<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminDoaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $doaId = $this->route('doa')?->id ?? null;

        return [
            'doa_category_id' => ['required', 'integer', 'exists:doa_categories,id'],
            'judul' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:170', Rule::unique('doas', 'slug')->ignore($doaId)],
            'teks_arab' => ['required', 'string'],
            'teks_latin' => ['required', 'string'],
            'terjemahan' => ['required', 'string'],
            'sumber' => ['nullable', 'string', 'max:255'],
            'is_published' => ['boolean'],
        ];
    }
}

