<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeminjamanRequest extends FormRequest
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
        return [
            'anggota_id' => [
                'required',
                'exists:anggota,id',
            ],
            'buku_id' => [
                'required',
                'exists:buku,id',
            ],
            'tgl_pinjam' => [
                'required',
                'date',
            ],
            'tgl_harus_kembali' => [
                'required',
                'date',
                'after:tgl_pinjam',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'anggota_id.required' => 'Anggota wajib dipilih.',
            'anggota_id.exists' => 'Anggota yang dipilih tidak valid.',
            'buku_id.required' => 'Buku wajib dipilih.',
            'buku_id.exists' => 'Buku yang dipilih tidak valid.',
            'tgl_pinjam.required' => 'Tanggal pinjam wajib diisi.',
            'tgl_pinjam.date' => 'Tanggal pinjam harus berupa tanggal yang valid.',
            'tgl_harus_kembali.required' => 'Tanggal harus kembali wajib diisi.',
            'tgl_harus_kembali.date' => 'Tanggal harus kembali harus berupa tanggal yang valid.',
            'tgl_harus_kembali.after' => 'Tanggal harus kembali harus setelah tanggal pinjam.',
        ];
    }
}

