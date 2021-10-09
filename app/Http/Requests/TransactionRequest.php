<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;

class TransactionRequest extends FormRequest
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
            'category_id'        =>    ['required', ValidationRule::exists('categories','id')->where('user_id',auth()->user()->id)],
            'amount'             =>    'required',
            'transaction_date'   =>    'required|date',
            'description'        =>    'required',
        ];
    }
}
