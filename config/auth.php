<?php

// =====================================================
// FILE 1: config/auth.php
// =====================================================
// Ganti isi file config/auth.php dengan ini:

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        // Guard untuk User (kepala_sekolah, kesiswaan, bk, wali_kelas, orang_tua)
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Guard untuk Siswa (login pakai NISN)
        'siswa' => [
            'driver' => 'session',
            'provider' => 'siswa',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'siswa' => [
            'driver' => 'eloquent',
            'model' => App\Models\Siswa::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'siswa' => [
            'provider' => 'siswa',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];