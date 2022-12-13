<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGalleryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|min:2|max:255',
            'description' => 'string|max:1000|nullable',
            'images' => 'sometimes|array',
            'images.*.image_url' => 'sometimes|url|ends_with:png,jpg,jpeg'
        ];
    }
    public function messages()
    {
        return [
            'images.*.image_url.ends_with' => 'Image must be of a png, jpg or jpeg format',
            'images.*.image_url.url' => 'Image must be a valid url',
        ];
    }
}