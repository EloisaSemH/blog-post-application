<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiSaveCommentRequest extends FormRequest
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
            'uuid' => 'required',
            'username' => 'required|max:255',
            'comment' => 'required',
            'level' => 'required|integer|max:3|min:1',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'message' => 'Validation errors',
                    'code' => 400,
                    'data' => $validator->errors()
                ]
            )
        );
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'A username is required',
            'comment.required' => 'A message for the comment is required',
        ];
    }
}