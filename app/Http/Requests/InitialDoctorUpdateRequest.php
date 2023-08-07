<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class InitialDoctorUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('doctor')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */

    public function rules()
    {
        return [
            'email' => 'required|email',
            'name' => 'required|string',
            'address' => 'required|string|max:255',
            'registration_no' => 'required|string|max:255',
            'about' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'specializations' => 'required|array',
            'specializations.*' => 'required|integer|exists:specializations,id',
            'document_types' => 'required|array',
            'document_types.*' => 'required|integer|exists:document_types,id',
            'documents' => 'required|array',
            'documents.*' => 'required|file|mimes:pdf,doc,docx,jpeg,png,jpg|max:2048',
            'experience' => 'required|numeric',
            'image' => 'nullable|file|mimes:jpeg,png,jpg|max:1024',
        ];
    }
}
