<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'alat_id',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'status',
        'keterangan',
        'alasan_batal',
        'disetujui_oleh',
    ];

    public const STATUS_MENUNGGU    = 'menunggu';
    public const STATUS_DISETUJUI  = 'disetujui';
    public const STATUS_DIPINJAM   = 'dipinjam';
    public const STATUS_DITOLAK    = 'ditolak';
    public const STATUS_DIBATALKAN = 'dibatalkan';
    public const STATUS_EXPIRED    = 'expired';
    public const STATUS_SELESAI    = 'selesai';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }
}
