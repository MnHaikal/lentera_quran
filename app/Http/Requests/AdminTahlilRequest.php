<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminTahlilRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'urutan' => ['required', 'integer', 'min:1'],
            'judul' => ['required', 'string', 'max:150'],
            'teks_arab' => ['required', 'string'],
            'teks_latin' => ['required', 'string'],
            'terjemahan' => ['required', 'string'],
            'jumlah_baca' => ['required', 'integer', 'min:1', 'max:1000'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'is_published' => ['boolean'],
        ];
    }
}

