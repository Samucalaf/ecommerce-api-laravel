<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'owner' => [
                'required',
                'string',
                'max:255',
            ],
            'street' => [
                'required',
                'string',
                'max:255',
            ],
            'number' => [
                'required',
                'string',
                'max:50',
            ],
            'complement' => [
                'nullable',
                'string',
                'max:255',
            ],
            'neighborhood' => [
                'required',
                'string',
                'max:255',
            ],
            'city' => [
                'required',
                'string',
                'max:255',
            ],
            'federation_unit' => [
                'required',
                'string',
                'max:2',
            ],
            'zip_code' => [
                'required',
                'string',
                'max:20',
            ],
        ];
    }
}
