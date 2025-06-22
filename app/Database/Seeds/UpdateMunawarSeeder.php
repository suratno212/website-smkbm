<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateMunawarSeeder extends Seeder
{
    public function run()
    {
        // Update nama guru dari Munawar.S.Pd menjadi Munawar, S.Pd
        $this->db->table('guru')
            ->where('nama', 'Munawar.S.Pd')
            ->update([
                'nama' => 'Munawar, S.Pd',
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        $affectedRows = $this->db->affectedRows();
        
        if ($affectedRows > 0) {
            echo "Nama guru berhasil diupdate!\n";
            echo "Dari: Munawar.S.Pd\n";
            echo "Menjadi: Munawar, S.Pd\n";
            echo "Jumlah baris yang diupdate: {$affectedRows}\n";
        } else {
            echo "Tidak ada data yang diupdate. Pastikan guru dengan nama 'Munawar.S.Pd' ada di database.\n";
        }
    }
} 