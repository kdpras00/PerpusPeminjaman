<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BukuRequest extends FormRequest
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
        $buku = $this->route('buku');
        $bukuId = $buku ? $buku->id : $this->route('id');

        return [
            'kode_buku' => [
                'required',
                'string',
                'max:255',
                'unique:buku,kode_buku,' . $bukuId,
            ],
            'judul' => [
                'required',
                'string',
                'max:255',
            ],
            'pengarang' => [
                'required',
                'string',
                'max:255',
            ],
            'penerbit' => [
                'required',
                'string',
                'max:255',
            ],
            'tahun_terbit' => [
                'required',
                'integer',
                'min:1900',
                'max:' . date('Y'),
            ],
            'stok' => [
                'required',
                'integer',
                'min:0',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'kode_buku.required' => 'Kode buku wajib diisi.',
            'kode_buku.unique' => 'Kode buku sudah digunakan.',
            'judul.required' => 'Judul buku wajib diisi.',
            'pengarang.required' => 'Pengarang wajib diisi.',
            'penerbit.required' => 'Penerbit wajib diisi.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa angka.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok tidak boleh negatif.',
        ];
    }
}

