<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed admin and customer users
        $this->call(UserSeeder::class);

        // User::factory(10)->create();

        

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $data = [
            'Elektronik' => [
                ['name' => 'Smartphone Galaxy S24 Ultra', 'price' => 19999000, 'stock' => 15, 'desc' => 'Smartphone flagship dengan kamera 200MP dan fitur AI.'],
                ['name' => 'Laptop Pro 14 Inch M3', 'price' => 25499000, 'stock' => 10, 'desc' => 'Laptop berperforma tinggi cocok untuk editing video dan coding.'],
                ['name' => 'Wireless Noise Cancelling Headphones', 'price' => 4299000, 'stock' => 25, 'desc' => 'Headphone premium dengan fitur peredam bising aktif.'],
                ['name' => 'Smart TV 4K UHD 55 Inch', 'price' => 7499000, 'stock' => 8, 'desc' => 'Televisi pintar dengan resolusi gambar super tajam.'],
                ['name' => 'Mechanical Keyboard RGB', 'price' => 850000, 'stock' => 40, 'desc' => 'Keyboard mekanikal dengan switch tactile dan lampu RGB.'],
                ['name' => 'Wireless Gaming Mouse', 'price' => 650000, 'stock' => 50, 'desc' => 'Mouse gaming responsif dengan sensitivitas hingga 12000 DPI.'],
                ['name' => 'Powerbank 20000mAh Fast Charging', 'price' => 299000, 'stock' => 100, 'desc' => 'Pengisi daya portabel kapasitas besar mendukung pengisian cepat.'],
                ['name' => 'Robot Vacuum Cleaner', 'price' => 3190000, 'stock' => 12, 'desc' => 'Penyedot debu otomatis yang bisa dikontrol lewat aplikasi smartphone.'],
                ['name' => 'External SSD 1TB USB 3.2', 'price' => 1450000, 'stock' => 30, 'desc' => 'Penyimpanan eksternal super cepat dan tahan guncangan.'],
                ['name' => 'Action Camera 4K Waterproof', 'price' => 2750000, 'stock' => 18, 'desc' => 'Kamera aksi tangguh untuk merekam momen petualangan outdoor.'],
            ],
            'Pakaian Pria' => [
                ['name' => 'Kemeja Flanel Kotak-Kotak', 'price' => 249000, 'stock' => 35, 'desc' => 'Kemeja flanel bahan katun tebal dan nyaman dipakai sehari-hari.'],
                ['name' => 'Celana Chino Slim Fit Chino', 'price' => 299000, 'stock' => 45, 'desc' => 'Celana panjang chino elastis cocok untuk acara kasual maupun semi-formal.'],
                ['name' => 'Jaket Bomber Canvas', 'price' => 389000, 'stock' => 20, 'desc' => 'Jaket bomber dengan lapisan dalam furing hangat.'],
                ['name' => 'Kaos Polos Cotton Combed 30s', 'price' => 650000, 'stock' => 200, 'desc' => 'Kaos polos bahan katun murni yang menyerap keringat dengan baik.'],
                ['name' => 'Sweater Hoodie Polos', 'price' => 199000, 'stock' => 60, 'desc' => 'Hoodie kasual dengan saku depan kantong kanguru.'],
                ['name' => 'Celana Pendek Cargo', 'price' => 175000, 'stock' => 40, 'desc' => 'Celana pendek kasual dengan banyak saku fungsional.'],
                ['name' => 'Baju Batik Pria Lengan Panjang', 'price' => 320000, 'stock' => 15, 'desc' => 'Baju batik cap premium motif modern elegan.'],
                ['name' => 'Sepatu Sneakers Kasual', 'price' => 450000, 'stock' => 22, 'desc' => 'Sepatu sneakers trendi berbahan kulit sintetis.'],
                ['name' => 'Jas Blazer Formal Hitam', 'price' => 550000, 'stock' => 10, 'desc' => 'Blazer formal pria potongan slim fit dengan bantalan busa di bahu.'],
                ['name' => 'Topi Baseball Polos', 'price' => 50000, 'stock' => 80, 'desc' => 'Topi kasual dengan pengait besi di bagian belakang.'],
            ],
            'Pakaian Wanita' => [
                ['name' => 'Blouse Katun V-Neck', 'price' => 165000, 'stock' => 40, 'desc' => 'Atasan wanita lengan panjang gaya kasual minimalis.'],
                ['name' => 'Midi Dress Casual Floral', 'price' => 289000, 'stock' => 25, 'desc' => 'Gaun panjang sedang bermotif bunga dengan bahan sifon mengalir.'],
                ['name' => 'Celana Kulot High Waist', 'price' => 185000, 'stock' => 50, 'desc' => 'Celana kulot potongan pinggang tinggi membuat efek kaki jenjang.'],
                ['name' => 'Cardigan Rajut Oversize', 'price' => 149000, 'stock' => 35, 'desc' => 'Outer rajutan longgar bergaya ala Korea.'],
                ['name' => 'Rok Plisket Panjang Premium', 'price' => 120000, 'stock' => 70, 'desc' => 'Rok panjang dengan lipatan rapi dan bahan jatuh anggun.'],
                ['name' => 'Tunik Denim Lengan Panjang', 'price' => 210000, 'stock' => 18, 'desc' => 'Atasan tunik berbahan soft denim yang adem.'],
                ['name' => 'Jaket Jeans Wanita', 'price' => 260000, 'stock' => 20, 'desc' => 'Jaket denim bergaya washed jeans untuk tampilan tomboi kasual.'],
                ['name' => 'Hijab Segi Empat Voal Premium', 'price' => 65000, 'stock' => 150, 'desc' => 'Hijab voal tegak di dahi dan mudah dibentuk.'],
                ['name' => 'Flat Shoes Kulit Sintetis', 'price' => 195000, 'stock' => 30, 'desc' => 'Sepatu flat empuk anti lecet cocok untuk kerja jalan-jalan.'],
                ['name' => 'Baju Tidur Pajamas Satin', 'price' => 175000, 'stock' => 40, 'desc' => 'Setelan baju tidur mewah berbahan satin lembut berkilau.'],
            ],
            'Kesehatan & Kecantikan' => [
                ['name' => 'Sunscreen SPF 50 PA++++', 'price' => 89000, 'stock' => 120, 'desc' => 'Tabir surya ringan tanpa whitecast, melindungi dari sinar UV.'],
                ['name' => 'Moisturizer Gel Ceramide', 'price' => 139000, 'stock' => 90, 'desc' => 'Pelembab wajah bertekstur gel untuk memperbaiki skin barrier.'],
                ['name' => 'Serum Vitamin C Brightening', 'price' => 125000, 'stock' => 80, 'desc' => 'Serum wajah untuk menyamarkan noda hitam dan mencerahkan kulit.'],
                ['name' => 'Micellar Water Cleansing 400ml', 'price' => 75000, 'stock' => 110, 'desc' => 'Pembersih make-up sekali usap tanpa bilas, lembut di kulit.'],
                ['name' => 'Clay Mask Pore Clarifying', 'price' => 95000, 'stock' => 60, 'desc' => 'Masker lumpur pembersih pori-pori dan pengontrol minyak berlebih.'],
                ['name' => 'Lip Tint Matte Longlasting', 'price' => 69000, 'stock' => 200, 'desc' => 'Pewarna bibir hasil matte natural, awet seharian.'],
                ['name' => 'Shampoo Keratin Anti Hairfall', 'price' => 55000, 'stock' => 100, 'desc' => 'Sampo penguat akar rambut untuk mengatasi kerontokan.'],
                ['name' => 'Body Lotion Brightening Sakura', 'price' => 48000, 'stock' => 130, 'desc' => 'Losion tubuh wangi bunga sakura yang melembabkan kulit kering.'],
                ['name' => 'Facial Wash Gentle Cleanser', 'price' => 85000, 'stock' => 95, 'desc' => 'Sabun cuci muka formula lembut tanpa kandungan sabun keras.'],
                ['name' => 'Parfum Eau De Parfum Unisex 50ml', 'price' => 250000, 'stock' => 40, 'desc' => 'Wewangian tahan lama dengan aroma mewah berkelas.'],
            ],
            'Buku & Alat Tulis' => [
                ['name' => 'Buku Cetak Belajar Laravel 12', 'price' => 135000, 'stock' => 25, 'desc' => 'Panduan lengkap membangun sistem web modern menggunakan Laravel.'],
                ['name' => 'Novel Fiksi Best Seller', 'price' => 99000, 'stock' => 30, 'desc' => 'Buku cerita fiksi drama yang menyentuh hati pembaca.'],
                ['name' => 'Buku Desain Grafis Untuk Pemula', 'price' => 115000, 'stock' => 15, 'desc' => 'Tutorial dasar menguasai software desain populer dari nol.'],
                ['name' => 'Notebook Jurnal Cover Kulit A5', 'price' => 75000, 'stock' => 50, 'desc' => 'Buku catatan bersampul kulit estetik dengan kertas bergaris.'],
                ['name' => 'Set Pulpen Gel Hitam (12 Pcs)', 'price' => 36000, 'stock' => 100, 'desc' => 'Pulpen gel tinta hitam pekat, ujung pena runcing 0.5mm.'],
                ['name' => 'Pensil Warna Seni isi 36 Warna', 'price' => 145000, 'stock' => 40, 'desc' => 'Pensil warna berkualitas tinggi dengan pigmentasi cerah.'],
                ['name' => 'Binder Kuliah Loose Leaf B5', 'price' => 45000, 'stock' => 65, 'desc' => 'Binder multifungsi untuk mencatat materi kuliah sekolah.'],
                ['name' => 'Sticky Notes Memo Pad Set', 'price' => 22000, 'stock' => 150, 'desc' => 'Kertas catatan tempel warna-warni penanda halaman penting.'],
                ['name' => 'Highlighter Pastel Set isi 6', 'price' => 38000, 'stock' => 85, 'desc' => 'Pena penanda teks dengan warna pastel lembut di mata.'],
                ['name' => 'Ransel Sekolah Backpack Canvas', 'price' => 189000, 'stock' => 20, 'desc' => 'Tas punggung bahan kanvas tebal dengan kompartemen laptop.'],
            ],
        ];

        // Looping untuk memasukkan data ke database secara terstruktur
        foreach ($data as $categoryName => $products) {
            // 1. Buat kategori terlebih dahulu
            $category = ProductCategory::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
            ]);

            // 2. Masukkan produk yang berada di dalam kategori tersebut
            foreach ($products as $product) {
                Product::create([
                    'product_category_id' => $category->id,
                    'name'        => $product['name'],
                    'slug'        => Str::slug($product['name']),
                    'description' => $product['desc'],
                    'price'       => $product['price'],
                    'stock'       => $product['stock'],
                    'image'       => 'products/default.jpg', // Default image placeholder
                ]);
            }
        }
    }
}
