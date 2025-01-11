<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\UpdateSettingRequestDTO;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'key' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'method' => 'required|string|in:sms,email,telegram',
        ];
    }


    public function toDTO(): UpdateSettingRequestDTO
    {
        return new UpdateSettingRequestDTO(
            userId: auth()->id(),
            key: $this->input('key'),
            value: $this->input('value'),
            method: $this->input('method')
        );
    }
}
