<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255','unique:slug'],
            'description' => ['required', 'string'],
        ];
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        if ($this->user()->can('create products')) {
            return true;
        }
        return false;
    }
}
