<?php

namespace App\Http\Requests;
use App\Models\Visitor;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class VisitorUpdateRequest extends FormRequest
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
            'name' =>  ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'lowercase', 
                'email', 
                'max:255', 
                Rule::unique(Visitor::class)->ignore($this->route('visitor'))
            ],            
            'phone_number' => ['required', 'string', 'regex:/^\d{1,15}$/'],
            'address' => ['required', 'string', 'max:255'],
            'postal_code' => ['nullable', 'integer'],
        ];
    }
}
