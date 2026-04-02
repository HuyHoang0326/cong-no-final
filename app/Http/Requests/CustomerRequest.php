<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'customer_code' => 'string|max:50|unique:customers,customer_code',
            'name' => 'string|max:255',
            'phone' => 'string|max:20',
            'address' => 'string|max:255',
            'email' => 'nullable|email|max:255',

            'is_potential' => 'nullable|boolean',

            'paid_orders_count' => 'nullable|integer|min:0',
            'unpaid_orders_count' => 'nullable|integer|min:0',

            'total_purchased_amount' => 'nullable|numeric|min:0',
            'outstanding_amount' => 'nullable|numeric|min:0',
        ];
    }
    public function messages()
{
    return [
        'customer_code.string' => 'Mã khách hàng phải là chuỗi',
        'customer_code.max' => 'Mã khách hàng không được vượt quá 50 ký tự',
        'customer_code.unique' => 'Mã khách hàng đã tồn tại',

        'name.string' => 'Tên khách hàng phải là chuỗi',
        'name.max' => 'Tên khách hàng không được vượt quá 255 ký tự',

        'phone.string' => 'Số điện thoại phải là chuỗi',
        'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự',

        'address.string' => 'Địa chỉ phải là chuỗi',
        'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',

        'email.email' => 'Email không đúng định dạng',
        'email.max' => 'Email không được vượt quá 255 ký tự',

        'is_potential.boolean' => 'Trạng thái khách hàng tiềm năng không hợp lệ',

        'paid_orders_count.integer' => 'Số đơn đã thanh toán phải là số nguyên',
        'paid_orders_count.min' => 'Số đơn đã thanh toán không được nhỏ hơn 0',

        'unpaid_orders_count.integer' => 'Số đơn chưa thanh toán phải là số nguyên',
        'unpaid_orders_count.min' => 'Số đơn chưa thanh toán không được nhỏ hơn 0',

        'total_purchased_amount.numeric' => 'Tổng tiền mua phải là số',
        'total_purchased_amount.min' => 'Tổng tiền mua không được nhỏ hơn 0',

        'outstanding_amount.numeric' => 'Số tiền còn nợ phải là số',
        'outstanding_amount.min' => 'Số tiền còn nợ không được nhỏ hơn 0',
    ];
}
}
