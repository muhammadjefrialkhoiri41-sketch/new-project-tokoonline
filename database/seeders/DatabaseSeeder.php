<?php 
 
namespace Database\Seeders; 
 
// use Illuminate\Database\Console\Seeds\WithoutModelEvents; 
use Illuminate\Database\Seeder; 
use App\Models\User; 
use App\Models\Kategori;
use App\Models\Produk;

class DatabaseSeeder extends Seeder 
{ 
    /** 
     * Seed the application's database. 
     */ 
    public function run(): void 
    { 
        User::create([ 
            'nama' => 'Administrator', 
            'email' => 'admin@gmail.com', 
            'role' => '1', 
            'status' => 1, 
            'hp' => '0812345678901', 
            'password' => bcrypt('P@55word'), 
        ]); 
        #untuk record berikutnya silahkan, beri nilai berbeda pada nilai: nama, email, hp dengan ph
        User::create([ 
            'nama' => 'jefri', 
            'email' => 'jeffloid@gmail.com', 
            'role' => '1', 
            'status' => 1, 
            'hp' => '083878113436', 
            'password' => bcrypt('P@55word'), 
        ]); 
        #data kategori 
        Kategori::create([ 
            'nama_kategori' => 'sosis ayam', 
        ]); 
        Kategori::create([ 
            'nama_kategori' => 'sosis sapi', 
        ]);         
    } 
} 
 