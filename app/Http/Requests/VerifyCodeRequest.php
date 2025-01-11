<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\VerifyCodeRequestDTO;

class VerifyCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:6',
        ];
    }

    public function toDTO(): VerifyCodeRequestDTO
    {
        return new VerifyCodeRequestDTO(
            userId: auth()->id(),
            code: $this->input('code')
        );
    }
}
