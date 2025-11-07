<?php

namespace App\Http\Requests;

use App\Constants\StatusConstants;
use Illuminate\Foundation\Http\FormRequest;

class AnggotaRequest extends FormRequest
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
            'nama' => [
                'required',
                'string',
                'max:255',
            ],
            'alamat' => [
                'required',
                'string',
            ],
            'no_telp' => [
                'required',
                'string',
                'max:20',
            ],
            'tgl_daftar' => [
                'required',
                'date',
            ],
            'status' => [
                'required',
                'in:' . implode(',', StatusConstants::getAnggotaStatuses()),
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama anggota wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'tgl_daftar.required' => 'Tanggal daftar wajib diisi.',
            'tgl_daftar.date' => 'Tanggal daftar harus berupa tanggal yang valid.',
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status harus aktif atau nonaktif.',
        ];
    }
}

