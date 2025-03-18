<?php
declare(strict_types=1);

namespace App\Http\Requests\Quota;

use Illuminate\Foundation\Http\FormRequest;

class QuotaRequest extends FormRequest
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
        if ($this->isMethod('put')) {
            return [
                'status' => ['required', 'in:Pendiente,Pagado'],
            ];
        }
    
        return [
            'creditId' => ['required', 'exists:credits,id'],
            'amount'   => ['required', 'numeric', 'min:0'],
            'dueDate'  => ['required', 'date', 'after_or_equal:today'],
        ];
    }
}    
