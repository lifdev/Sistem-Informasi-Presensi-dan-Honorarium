<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PresensiSeeder extends Seeder
{
    /**
     * Ganti koordinat ini ke lokasi kantor/yayasan yang sebenarnya.
     * Ini cuma placeholder (contoh: area Jakarta).
     */
    private const LAT_KANTOR = -6.2000000;
    private const LNG_KANTOR = 106.8166660;

    /**
     * Jumlah hari ke belakang yang di-generate ("1 bulan terakhir").
     */
    private const JUMLAH_HARI = 30;

    /**
     * Distribusi status kehadiran (dalam persen, total harus 100).
     */
    private const DISTRIBUSI_STATUS = [
        'hadir' => 85,
        'izin'  => 5,
        'sakit' => 5,
        'alpha' => 5,
    ];

    public function run(): void
    {
        // Reset tabel presensi
        DB::statement("SET FOREIGN_KEY_CHECKS=0;");
        DB::table('presensi')->truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS=1;");

        $karyawanList = Karyawan::all();

        if ($karyawanList->isEmpty()) {
            throw new \Exception(
                "Tidak ada data karyawan. Pastikan KaryawanSeeder sudah dijalankan lebih dulu."
            );
        }

        $tanggalList = $this->getTanggalHariKerja();

        $rows = [];
        $now  = Carbon::now();

        foreach ($karyawanList as $karyawan) {
            foreach ($tanggalList as $tanggal) {

                $status = $this->randomStatus();

                $jamMasuk = null;
                $latMasuk = null;
                $lngMasuk = null;
                $keterangan = null;

                if ($status === 'hadir') {
                    // Jam masuk random 07:00 - 09:00
                    $jamMasuk = sprintf(
                        '%02d:%02d:00',
                        random_int(7, 8),
                        random_int(0, 59)
                    );

                    // Sedikit jitter koordinat biar ga persis sama semua
                    $latMasuk = self::LAT_KANTOR + $this->jitter();
                    $lngMasuk = self::LNG_KANTOR + $this->jitter();
                } else {
                    $keterangan = match ($status) {
                        'izin'  => $this->randomKeterangan([
                            'Izin keperluan keluarga',
                            'Izin acara pribadi',
                            'Izin urusan mendadak',
                        ]),
                        'sakit' => $this->randomKeterangan([
                            'Sakit demam',
                            'Sakit flu',
                            'Sakit, ada surat dokter',
                        ]),
                        'alpha' => null, // tanpa keterangan
                    };
                }

                $rows[] = [
                    'karyawan_id' => $karyawan->id,
                    'tanggal'     => $tanggal->toDateString(),
                    'jam_masuk'   => $jamMasuk,
                    'lat_masuk'   => $latMasuk,
                    'lng_masuk'   => $lngMasuk,
                    'status'      => $status,
                    'keterangan'  => $keterangan,
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ];

                // Insert per 500 baris biar ringan
                if (count($rows) >= 500) {
                    DB::table('presensi')->insert($rows);
                    $rows = [];
                }
            }
        }

        if (!empty($rows)) {
            DB::table('presensi')->insert($rows);
        }
    }

    /**
     * Ambil list tanggal hari kerja (Senin-Jumat) selama JUMLAH_HARI ke belakang.
     *
     * @return Carbon[]
     */
    private function getTanggalHariKerja(): array
    {
        $tanggalList = [];
        $tanggal = Carbon::today()->subDays(self::JUMLAH_HARI);
        $akhir = Carbon::today();

        while ($tanggal->lte($akhir)) {
            if (!$tanggal->isWeekend()) {
                $tanggalList[] = $tanggal->copy();
            }
            $tanggal->addDay();
        }

        return $tanggalList;
    }

    /**
     * Pilih status secara random sesuai distribusi persentase.
     */
    private function randomStatus(): string
    {
        $rand = random_int(1, 100);
        $kumulatif = 0;

        foreach (self::DISTRIBUSI_STATUS as $status => $persen) {
            $kumulatif += $persen;
            if ($rand <= $kumulatif) {
                return $status;
            }
        }

        // fallback, seharusnya tidak pernah kepakai selama total = 100
        return 'hadir';
    }

    private function randomKeterangan(array $opsi): string
    {
        return $opsi[array_rand($opsi)];
    }

    /**
     * Jitter kecil untuk koordinat (+/- ~50 meter).
     */
    private function jitter(): float
    {
        return random_int(-50, 50) / 100000;
    }
}
