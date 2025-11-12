<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SelfHealingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'link_konten' => 'required|url',
            'jenis_konten' => 'required|string|max:100',
            'gambar' => 'nullable|image|max:2048',
        ];
    }
}
