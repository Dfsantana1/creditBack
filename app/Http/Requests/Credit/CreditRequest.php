<?php
declare(strict_types=1);

namespace App\Http\Requests\Credit;

use Illuminate\Foundation\Http\FormRequest;

class CreditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'userId'      => ['required', 'exists:users,id'],
                'amount'      => ['required', 'numeric', 'min:0'],
                'installments'=> ['required', 'integer', 'min:1'],
            ];
        }

        if ($this->isMethod('put')) {
            return [
                'amount'      => ['sometimes', 'numeric', 'min:0'],
                'installments'=> ['sometimes', 'integer', 'min:1'],
            ];
        }

        return [];
    }
}
