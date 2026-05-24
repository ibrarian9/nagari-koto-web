<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class PpidDikecualikan extends Model
{
    use LogsActivity;

    protected $table = 'ppid_dikecualikan';

    protected $fillable = ['content', 'updated_by'];

    /**
     * Single-row pattern — get or create the config record.
     */
    public static function getContent(): self
    {
        return static::firstOrCreate([], [
            'content' => self::defaultContent(),
        ]);
    }

    /**
     * Default content based on UU No. 14 Tahun 2008.
     */
    public static function defaultContent(): string
    {
        return <<<'HTML'
<h3>Informasi yang Dikecualikan</h3>
<p>Berdasarkan <strong>Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik</strong>, Pasal 17, berikut adalah kategori informasi yang dikecualikan dari akses publik:</p>
<ol>
<li><strong>Informasi yang dapat menghambat proses penegakan hukum</strong></li>
<li><strong>Informasi yang dapat mengganggu kepentingan perlindungan hak atas kekayaan intelektual</strong></li>
<li><strong>Informasi yang dapat membahayakan pertahanan dan keamanan negara</strong></li>
<li><strong>Informasi yang dapat mengungkap kekayaan alam Indonesia</strong></li>
<li><strong>Informasi yang dapat merugikan ketahanan ekonomi nasional</strong></li>
<li><strong>Informasi yang dapat merugikan kepentingan hubungan luar negeri</strong></li>
<li><strong>Informasi yang dapat mengungkap isi akta otentik yang bersifat pribadi</strong></li>
<li><strong>Memorandum atau surat-surat antar badan publik yang bersifat rahasia</strong></li>
<li><strong>Informasi yang tidak boleh diungkap berdasarkan undang-undang</strong></li>
</ol>
<p>Pengecualian informasi dilakukan melalui <strong>uji konsekuensi</strong> berdasarkan pertimbangan bahwa membuka informasi tersebut dapat menimbulkan kerugian yang lebih besar dibanding manfaatnya.</p>
<h3>Dasar Hukum</h3>
<ul>
<li>UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik</li>
<li>PP No. 61 Tahun 2010 tentang Pelaksanaan UU KIP</li>
<li>Peraturan Komisi Informasi No. 1 Tahun 2010</li>
</ul>
HTML;
    }

    protected function getActivityModelLabel(): string
    {
        return "PPID Informasi Dikecualikan";
    }
}
