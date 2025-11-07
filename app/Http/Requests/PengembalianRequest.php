<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengembalianRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $rules = [
            'tgl_kembali_realisasi' => [
                'required',
                'date',
            ],
        ];

        // Only require peminjaman_id on create
        if ($this->isMethod('post')) {
            $rules['peminjaman_id'] = [
                'required',
                'exists:peminjaman,id',
            ];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'peminjaman_id.required' => 'Peminjaman wajib dipilih.',
            'peminjaman_id.exists' => 'Peminjaman yang dipilih tidak valid.',
            'tgl_kembali_realisasi.required' => 'Tanggal kembali realisasi wajib diisi.',
            'tgl_kembali_realisasi.date' => 'Tanggal kembali realisasi harus berupa tanggal yang valid.',
        ];
    }
}

