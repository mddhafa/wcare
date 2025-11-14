<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// <<<<<<< HEAD
// =======
/**

 * @bodyParam email string required Alamat email yang unik. Contoh: john@example.com
 * @bodyParam password string required Kata sandi minimal 6 karakter. Contoh: rahasia123
 * @bodyParam role_id integer required ID dari role yang tersedia. Contoh: 2
 */
// >>>>>>> 9f19b2d005664097d4bde2ffd86e7f22eea44af3
class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
// <<<<<<< HEAD
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
// =======
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role_id'  => 'required|exists:roles,id',
// >>>>>>> 9f19b2d005664097d4bde2ffd86e7f22eea44af3
        ];
    }
}
