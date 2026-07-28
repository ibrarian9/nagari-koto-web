<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Pesan Validasi — Bahasa Indonesia
    |--------------------------------------------------------------------------
    */

    'accepted'             => ':attribute harus diterima.',
    'active_url'           => ':attribute bukan URL yang valid.',
    'after'                => ':attribute harus tanggal setelah :date.',
    'after_or_equal'       => ':attribute harus tanggal setelah atau sama dengan :date.',
    'alpha'                => ':attribute hanya boleh berisi huruf.',
    'alpha_dash'           => ':attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num'            => ':attribute hanya boleh berisi huruf dan angka.',
    'array'                => ':attribute harus berupa array.',
    'before'               => ':attribute harus tanggal sebelum :date.',
    'before_or_equal'      => ':attribute harus tanggal sebelum atau sama dengan :date.',
    'between'              => [
        'numeric' => ':attribute harus antara :min dan :max.',
        'file'    => ':attribute harus antara :min dan :max kilobyte.',
        'string'  => ':attribute harus antara :min dan :max karakter.',
        'array'   => ':attribute harus antara :min dan :max item.',
    ],
    'boolean'              => ':attribute harus bernilai benar atau salah.',
    'confirmed'            => 'Konfirmasi :attribute tidak cocok.',
    'date'                 => ':attribute bukan tanggal yang valid.',
    'date_equals'          => ':attribute harus tanggal yang sama dengan :date.',
    'date_format'          => ':attribute tidak cocok dengan format :format.',
    'different'            => ':attribute dan :other harus berbeda.',
    'digits'               => ':attribute harus :digits digit.',
    'digits_between'       => ':attribute harus antara :min dan :max digit.',
    'dimensions'           => ':attribute memiliki dimensi gambar yang tidak valid.',
    'distinct'             => ':attribute memiliki nilai duplikat.',
    'email'                => ':attribute harus berupa alamat email yang valid.',
    'exists'               => ':attribute yang dipilih tidak valid.',
    'file'                 => ':attribute harus berupa file.',
    'filled'               => ':attribute harus diisi.',
    'gt'                   => [
        'numeric' => ':attribute harus lebih besar dari :value.',
        'file'    => ':attribute harus lebih besar dari :value kilobyte.',
        'string'  => ':attribute harus lebih dari :value karakter.',
        'array'   => ':attribute harus lebih dari :value item.',
    ],
    'gte'                  => [
        'numeric' => ':attribute harus lebih besar atau sama dengan :value.',
        'file'    => ':attribute harus lebih besar atau sama dengan :value kilobyte.',
        'string'  => ':attribute harus lebih atau sama dengan :value karakter.',
        'array'   => ':attribute harus :value item atau lebih.',
    ],
    'image'                => ':attribute harus berupa gambar (JPG, PNG, atau WebP).',
    'in'                   => ':attribute yang dipilih tidak valid.',
    'in_array'             => ':attribute tidak ada di :other.',
    'integer'              => ':attribute harus berupa angka bulat.',
    'ip'                   => ':attribute harus berupa alamat IP yang valid.',
    'json'                 => ':attribute harus berupa JSON yang valid.',
    'lt'                   => [
        'numeric' => ':attribute harus kurang dari :value.',
        'file'    => ':attribute harus kurang dari :value kilobyte.',
        'string'  => ':attribute harus kurang dari :value karakter.',
        'array'   => ':attribute harus kurang dari :value item.',
    ],
    'lte'                  => [
        'numeric' => ':attribute harus kurang atau sama dengan :value.',
        'file'    => ':attribute harus kurang atau sama dengan :value kilobyte.',
        'string'  => ':attribute harus kurang atau sama dengan :value karakter.',
        'array'   => ':attribute tidak boleh lebih dari :value item.',
    ],
    'max'                  => [
        'numeric' => ':attribute tidak boleh lebih dari :max.',
        'file'    => ':attribute tidak boleh lebih dari :max KB.',
        'string'  => ':attribute tidak boleh lebih dari :max karakter.',
        'array'   => ':attribute tidak boleh lebih dari :max item.',
    ],
    'mimes'                => ':attribute harus berupa file bertipe: :values.',
    'mimetypes'            => ':attribute harus berupa file bertipe: :values.',
    'min'                  => [
        'numeric' => ':attribute minimal :min.',
        'file'    => ':attribute minimal :min KB.',
        'string'  => ':attribute minimal :min karakter.',
        'array'   => ':attribute minimal :min item.',
    ],
    'not_in'               => ':attribute yang dipilih tidak valid.',
    'not_regex'            => 'Format :attribute tidak valid.',
    'numeric'              => ':attribute harus berupa angka.',
    'present'              => ':attribute harus ada.',
    'regex'                => 'Format :attribute tidak valid.',
    'required'             => ':attribute wajib diisi.',
    'required_if'          => ':attribute wajib diisi ketika :other adalah :value.',
    'required_unless'      => ':attribute wajib diisi kecuali :other ada di :values.',
    'required_with'        => ':attribute wajib diisi ketika :values ada.',
    'required_with_all'    => ':attribute wajib diisi ketika :values ada.',
    'required_without'     => ':attribute wajib diisi ketika :values tidak ada.',
    'required_without_all' => ':attribute wajib diisi ketika tidak ada :values.',
    'same'                 => ':attribute dan :other harus sama.',
    'size'                 => [
        'numeric' => ':attribute harus :size.',
        'file'    => ':attribute harus :size KB.',
        'string'  => ':attribute harus :size karakter.',
        'array'   => ':attribute harus :size item.',
    ],
    'starts_with'          => ':attribute harus diawali dengan: :values.',
    'string'               => ':attribute harus berupa teks.',
    'timezone'             => ':attribute harus zona waktu yang valid.',
    'unique'               => ':attribute sudah digunakan.',
    'uploaded'             => ':attribute gagal diunggah. Pastikan ukuran file tidak melebihi batas maksimal.',
    'url'                  => ':attribute harus berupa URL yang valid.',
    'uuid'                 => ':attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Pesan Validasi Khusus
    |--------------------------------------------------------------------------
    */
    'custom' => [
        'newPhoto' => [
            'image' => 'File foto harus berupa gambar.',
            'mimes' => 'Format foto harus JPG, PNG, atau WebP.',
            'max'   => 'Ukuran foto maksimal 2MB.',
        ],
        'newLogo' => [
            'image' => 'File logo harus berupa gambar.',
            'mimes' => 'Format logo harus JPG, PNG, atau WebP.',
            'max'   => 'Ukuran logo maksimal 2MB.',
        ],
        'photo' => [
            'image' => 'File foto harus berupa gambar.',
            'mimes' => 'Format foto harus JPG, PNG, atau WebP.',
            'max'   => 'Ukuran foto maksimal 2MB.',
        ],
        'logo' => [
            'image' => 'File logo harus berupa gambar.',
            'mimes' => 'Format logo harus JPG, PNG, atau WebP.',
            'max'   => 'Ukuran logo maksimal 2MB.',
        ],
        'thumbnail' => [
            'image' => 'File thumbnail harus berupa gambar.',
            'mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'max'   => 'Ukuran gambar maksimal 2MB.',
        ],
        'file' => [
            'max'      => 'Ukuran file dokumen maksimal 2MB.',
            'mimes'    => 'Format file tidak sesuai.',
            'uploaded' => 'File gagal diunggah. Ukuran file melebihi batas server.',
        ],
        'attachmentUpload' => [
            'max' => 'Ukuran dokumen lampiran maksimal 2MB.',
            'mimes' => 'Lampiran harus berformat PDF.',
        ],
        'imageUpload' => [
            'max' => 'Ukuran foto maksimal 2MB.',
        ],
        'dokumenBalasan' => [
            'max' => 'Ukuran dokumen balasan maksimal 2MB.',
        ],
        'badan_hukum_file_upload' => [
            'max' => 'Ukuran dokumen badan hukum maksimal 2MB.',
        ],
        'nikahTemplate' => [
            'max' => 'Ukuran file template maksimal 2MB.',
        ],


        'nik' => [
            'required' => 'NIK wajib diisi.',
            'digits'   => 'NIK harus 16 digit.',
        ],
        'full_name' => [
            'required' => 'Nama lengkap wajib diisi.',
        ],
        'program_name' => [
            'required' => 'Pilih program terlebih dahulu.',
        ],
        'email' => [
            'required' => 'Email wajib diisi.',
            'email'    => 'Format email tidak valid.',
        ],
        'password' => [
            'required' => 'Password wajib diisi.',
            'min'      => 'Password minimal :min karakter.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Nama Atribut — Label Ramah Pengguna
    |--------------------------------------------------------------------------
    */
    'attributes' => [
        'name'             => 'Nama',
        'email'            => 'Email',
        'password'         => 'Password',
        'password_confirmation' => 'Konfirmasi Password',
        'nik'              => 'NIK',
        'full_name'        => 'Nama Lengkap',
        'program_name'     => 'Program',
        'program_type'     => 'Tipe Program',
        'address'          => 'Alamat',
        'phone'            => 'Telepon',
        'title'            => 'Judul',
        'content'          => 'Konten',
        'description'      => 'Deskripsi',
        'tagline'          => 'Tagline',
        'village_code'     => 'Kode Desa',
        'area_ha'          => 'Luas Wilayah',
        'established_year' => 'Tahun Berdiri',
        'province'         => 'Provinsi',
        'regency'          => 'Kabupaten',
        'district'         => 'Kecamatan',
        'map_embed_url'    => 'URL Peta',
        'newPhoto'         => 'Foto',
        'newLogo'          => 'Logo',
        'photo'            => 'Foto',
        'logo'             => 'Logo',
        'start_period'     => 'Periode Mulai',
        'end_period'       => 'Periode Selesai',
        'is_active'        => 'Status Aktif',
        'vision'           => 'Visi',
        'mission'          => 'Misi',
        'history'          => 'Sejarah',
        'position'         => 'Jabatan',
        'period'           => 'Periode',
        'category'         => 'Kategori',
        'date'             => 'Tanggal',
        'time'             => 'Waktu',
        'location'         => 'Lokasi',
        'price'            => 'Harga',
        'year'             => 'Tahun',
        'amount'           => 'Jumlah',
        'role'             => 'Peran',
    ],
];
