<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama jika ada agar tidak duplikat saat re-seed
        Contact::truncate();

        Contact::create([
            'nama_lokasi'     => 'Kantor KIA Care — Batam Maju',
            'alamat'          => 'Batam Maju, Kota Batam, Kepulauan Riau',
            'email'           => 'info@kia-care.id',
            'telepon'         => '+62 812 3456 7890',
            'jam_operasional' => 'Senin – Jumat, 08.00 – 17.00 WIB',
            'map_embed'       => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63824.14626312092!2d104.00807014490307!3d1.1539598131875908!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d989899e6487fd%3A0x879190f6bea428ef!2sBatam%20Maju!5e0!3m2!1sid!2sid!4v1779884707367!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'is_active'       => true,
        ]);
    }
}
