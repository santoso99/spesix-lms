<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'Kolom :attribute harus berupa array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'Kolom :attribute harus berisi benar atau salah.',
    'confirmed' => 'Kolom konfirmasi :attribute tidak cocok.',
    'date' => 'Kolom :attribute bukan tanggal yang valid.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'exists' => 'Kolom :attribute terpilih tidak valid.',
    'file' => 'Kolom :attribute harus berupa file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'Nilai :attribute harus lebih besar dari :value.',
        'file' => 'Ukuran :attribute harus lebih besar dari :value kilobytes.',
        'string' => 'Panjang :attribute harus lebih besar dari :value karakter.',
        'array' => 'Kolom :attribute harus memiliki lebih dari :value item.',
    ],
    'gte' => [
        'numeric' => 'Nilai :attribute harus lebih besar dari or equal :value.',
        'file' => 'Ukuran :attribute harus lebih besar dari or equal :value kilobytes.',
        'string' => 'Panjang :attribute harus lebih besar dari or equal :value karakter.',
        'array' => 'Kolom :attribute harus memiliki :value item atau lebih.',
    ],
    'image' => 'Input harus berupa gambar.',
    'in' => 'Nilai :attribute yang dipilih tidak valid.',
    'in_array' => 'Nilai :attribute tidak ditemukan pada :other.',
    'integer' => 'Nilai :attribute harus berupa bilangan bulat.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'Nilai :attribute harus lebih kecil dari :value.',
        'file' => 'Ukuran :attribute harus lebih kecil dari :value kilobytes.',
        'string' => 'Panjang :attribute harus lebih kecil dari :value karakter.',
        'array' => 'Kolom :attribute harus memiliki kurang dari :value item.',
    ],
    'lte' => [
        'numeric' => 'Nilai :attribute lebih kecil dari or equal :value.',
        'file' => 'Ukuran :attribute lebih kecil dari or equal :value kilobytes.',
        'string' => 'Panjang :attribute lebih kecil dari or equal :value karakter.',
        'array' => 'Kolom :attribute harus berisi tidak lebih dari :value item.',
    ],
    'max' => [
        'numeric' => 'Nilai :attribute tidak boleh lebih besar dari :max.',
        'file' => 'Ukuran :attribute tidak boleh lebih besar dari :max kilobytes.',
        'string' => 'Panjang :attribute tidak boleh lebih besar dari :max karakter.',
        'array' => 'Kolom :attribute tidak boleh berisi lebih dari :max item.',
    ],
    'mimes' => 'Kolom :attribute harus memiliki tipe file: :values.',
    'mimetypes' => 'Kolom :attribute harus memiliki tipe file: :values.',
    'min' => [
        'numeric' => 'Kolom :attribute harus kurang dari :min.',
        'file' => 'Kolom :attribute harus kurang dari :min kilobytes.',
        'string' => 'Kolom :attribute harus kurang dari :min karakter.',
        'array' => 'Kolom :attribute harus berisi kurang dari :min item.',
    ],
    'not_in' => 'Kolom :attribute terpilih tidak valid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'Kolom :attribute harus berupa angka.',
    'password' => 'Isian password salah.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'Kolom :attribute harus diisi.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'Kolom :attribute dan :other harus cocok.',
    'size' => [
        'numeric' => 'Kolom :attribute harus berukuran :size.',
        'file' => 'Kolom :attribute harus berukuran :size kilobytes.',
        'string' => 'Kolom :attribute harus berukuran :size karakter.',
        'array' => 'Kolom :attribute harus berisi :size item.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'Kolom :attribute harus berupa susunan huruf.',
    'timezone' => 'Kolom :attribute harus berupa zona waktu yang valid.',
    'unique' => 'Kolom :attribute telah digunakan.',
    'uploaded' => 'Isian :attribute gagal untuk diupload.',
    'url' => 'Format kolom :attribute tidak valid.',
    'uuid' => 'Kolom :attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'identity_number' => [
            'exists' => 'NIS/NIY tidak terdaftar',
        ],
        'competency_id' => [
            'required' => 'Kompetensi dasar tidak boleh kosong',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
