<?php

namespace App\Constants;

class StatusConstants
{
    // Status Peminjaman
    public const STATUS_DIPINJAM = 'dipinjam';
    public const STATUS_DIKEMBALIKAN = 'dikembalikan';

    // Status Anggota
    public const STATUS_AKTIF = 'aktif';
    public const STATUS_NONAKTIF = 'nonaktif';

    // Pagination
    public const PAGINATION_PER_PAGE = 10;
    public const RECENT_ITEMS_LIMIT = 5;

    // Denda
    public const DENDA_PER_HARI = 1000;

    /**
     * Get all peminjaman statuses
     */
    public static function getPeminjamanStatuses(): array
    {
        return [
            self::STATUS_DIPINJAM,
            self::STATUS_DIKEMBALIKAN,
        ];
    }

    /**
     * Get all anggota statuses
     */
    public static function getAnggotaStatuses(): array
    {
        return [
            self::STATUS_AKTIF,
            self::STATUS_NONAKTIF,
        ];
    }
}

