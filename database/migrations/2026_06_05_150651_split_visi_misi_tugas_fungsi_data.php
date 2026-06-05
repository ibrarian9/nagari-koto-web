<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Split visi_misi: content has combined VISI + MISI text
        $visiMisi = DB::table('ppid_contents')->where('type', 'visi_misi')->first();
        if ($visiMisi && !empty($visiMisi->content) && empty($visiMisi->content_extra)) {
            $content = $visiMisi->content;
            // Try splitting on "MISI" keyword line
            $parts = preg_split('/\n\s*MISI\s*\n/i', $content, 2);
            if (count($parts) === 2) {
                $visi = trim(preg_replace('/^VISI\s*\n/i', '', $parts[0]));
                $misi = trim($parts[1]);
                DB::table('ppid_contents')->where('type', 'visi_misi')->update([
                    'content'       => $visi,
                    'content_extra' => $misi,
                ]);
            }
        }

        // Split tugas_fungsi: content has combined TUGAS + FUNGSI text
        $tugasFungsi = DB::table('ppid_contents')->where('type', 'tugas_fungsi')->first();
        if ($tugasFungsi && !empty($tugasFungsi->content) && empty($tugasFungsi->content_extra)) {
            $content = $tugasFungsi->content;
            // Try splitting on "FUNGSI PPID" keyword line
            $parts = preg_split('/\n\s*FUNGSI\s+PPID\s*\n/i', $content, 2);
            if (count($parts) === 2) {
                $tugas = trim(preg_replace('/^TUGAS\s+PPID\s*\n/i', '', $parts[0]));
                $fungsi = trim($parts[1]);
                DB::table('ppid_contents')->where('type', 'tugas_fungsi')->update([
                    'content'       => $tugas,
                    'content_extra' => $fungsi,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Re-combine if needed
        $visiMisi = DB::table('ppid_contents')->where('type', 'visi_misi')->first();
        if ($visiMisi && !empty($visiMisi->content_extra)) {
            $combined = "VISI\n" . $visiMisi->content . "\n\nMISI\n" . $visiMisi->content_extra;
            DB::table('ppid_contents')->where('type', 'visi_misi')->update([
                'content'       => $combined,
                'content_extra' => null,
            ]);
        }

        $tugasFungsi = DB::table('ppid_contents')->where('type', 'tugas_fungsi')->first();
        if ($tugasFungsi && !empty($tugasFungsi->content_extra)) {
            $combined = "TUGAS PPID\n" . $tugasFungsi->content . "\n\nFUNGSI PPID\n" . $tugasFungsi->content_extra;
            DB::table('ppid_contents')->where('type', 'tugas_fungsi')->update([
                'content'       => $combined,
                'content_extra' => null,
            ]);
        }
    }
};
