<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        return match ($this->method()) {
            'PATCH', 'PUT' => [
                'name' => 'required',
                "image" => "nullable|mimes:jpeg,jpg,png,svg,webp,gif|image|max:1024",
                'purchase_price' => 'required',
                'sale_price' => 'required',
            ],
            default => [
                'name' => 'required|string',
                "image" => "nullable|mimes:jpeg,jpg,png,svg,webp,gif|image|max:1024",
                'purchase_price' => 'required',
                'sale_price' => 'required',
            ],
        };
    }
}
