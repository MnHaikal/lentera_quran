<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminDoaCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $category = $this->route('kategoriDoa') ?? $this->route('kategori');
        $categoryId = is_object($category) ? $category->id : $category;

        return [
            'nama' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:120', Rule::unique('doa_categories', 'slug')->ignore($categoryId)],
            'urutan' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
