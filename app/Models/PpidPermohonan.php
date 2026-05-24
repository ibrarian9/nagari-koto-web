<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PpidPermohonan extends Model
{
    use LogsActivity, SoftDeletes;

    protected $table = 'ppid_permohonan';

    protected $fillable = [
        'nomor_permohonan', 'nama_pemohon', 'nik', 'no_telepon', 'email',
        'alamat', 'informasi_diminta', 'tujuan_penggunaan',
        'format_informasi', 'cara_mendapatkan', 'lampiran',
        'status', 'catatan_petugas', 'dokumen_balasan', 'tanggal_selesai',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_selesai' => 'datetime',
        ];
    }

    // ─── Status Config ────────────────────────────────────

    public const STATUS_MAP = [
        'menunggu' => ['label' => 'Menunggu', 'color' => 'bg-gray-100 text-gray-700'],
        'diproses' => ['label' => 'Diproses', 'color' => 'bg-blue-100 text-blue-800'],
        'selesai' => ['label' => 'Selesai', 'color' => 'bg-green-100 text-green-800'],
        'ditolak' => ['label' => 'Ditolak', 'color' => 'bg-red-100 text-red-800'],
    ];

    public const FORMAT_MAP = [
        'softcopy' => 'Softcopy (Digital)',
        'hardcopy' => 'Hardcopy (Cetak)',
        'keduanya' => 'Keduanya',
    ];

    public const CARA_MAP = [
        'mengambil_langsung' => 'Mengambil Langsung',
        'email' => 'Dikirim via Email',
        'pos' => 'Dikirim via Pos',
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_MAP[$this->status]['label'] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_MAP[$this->status]['color'] ?? 'bg-gray-100 text-gray-800';
    }

    // ─── Scopes ────────────────────────────────────────────

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Overdue: >10 working days since creation, still menunggu/diproses.
     */
    public function scopeOverdue($query)
    {
        return $query->whereIn('status', ['menunggu', 'diproses'])
            ->where('created_at', '<', now()->subWeekdays(10));
    }

    public function getIsOverdueAttribute(): bool
    {
        return in_array($this->status, ['menunggu', 'diproses'])
            && $this->created_at->diffInWeekdays(now()) > 10;
    }

    // ─── Generator ─────────────────────────────────────────

    /**
     * Generate unique nomor permohonan: PPID-2026-05-0001
     */
    public static function generateNomorPermohonan(): string
    {
        $prefix = 'PPID-' . now()->format('Y-m');
        $lastNumber = static::withTrashed()
            ->where('nomor_permohonan', 'like', "{$prefix}-%")
            ->max('nomor_permohonan');

        if ($lastNumber) {
            $seq = (int) substr($lastNumber, -4) + 1;
        } else {
            $seq = 1;
        }

        return $prefix . '-' . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }

    protected function getActivityModelLabel(): string
    {
        return "Permohonan PPID: {$this->nomor_permohonan}";
    }
}
