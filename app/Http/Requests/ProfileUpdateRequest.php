<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Only allow authenticated users to make this request
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            // The 'password' field rule seems to imply it's required when 'new_password' is present.
            // This might not be necessary if 'password' is the current password. Adjust as needed.
            'password' => 'sometimes|required_with:new_password|string|min:8',
            'new_password' => 'nullable|string|min:8|confirmed',
        ];

        return $rules;
    }
}
