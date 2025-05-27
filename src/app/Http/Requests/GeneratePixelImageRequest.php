<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GeneratePixelImageRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'required|image|max:1024', // max 1MB
        ];
    }

    public function messages(): array {
        return [
            'image.required' => 'Image is required.',
            'image.image' => 'Uploaded file must be an image.',
            'image.max' => 'Max size of the file is 1MB!',
        ];
    }

}
