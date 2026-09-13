<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount'      => 'required|numeric|min:1',
            'proof_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'payer_name'  => 'nullable|string|max:255',
            'bank_name'   => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required'      => 'Jumlah pembayaran wajib diisi.',
            'amount.min'           => 'Jumlah pembayaran minimal 1.',
            'proof_image.required' => 'Bukti pembayaran wajib diunggah.',
            'proof_image.image'    => 'File harus berupa gambar.',
            'proof_image.mimes'    => 'Format gambar harus JPG, JPEG, atau PNG.',
            'proof_image.max'      => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
