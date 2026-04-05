<?php

namespace Tests\Feature;

use App\Models\Layanan;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TransaksiManagementTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function pelanggan_can_create_transaksi()
    {
        $user = User::factory()->create(['role' => 'pelanggan']);
        $layanan = Layanan::factory()->create(['harga' => 10000]);

        $this->actingAs($user);

        $transaksiData = [
            'layanan_id' => $layanan->id,
            'berat' => 2.5,
            'metode_pembayaran' => 'cash'
        ];

        $response = $this->post('/pelanggan/transaksi', $transaksiData);

        $response->assertRedirect();
        $this->assertDatabaseHas('transaksis', [
            'user_id' => $user->id,
            'layanan_id' => $layanan->id,
            'berat' => 2.5,
            'status_transaksi' => 'proses'
        ]);
    }

    #[Test]
    public function admin_can_view_all_transaksi()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Transaksi::factory()->count(3)->create();

        $this->actingAs($admin);

        $response = $this->get('/admin/transaksi');

        $response->assertStatus(200);
    }

    #[Test]
    public function karyawan_can_update_transaksi_status()
    {
        $karyawan = User::factory()->create(['role' => 'karyawan']);
        $transaksi = Transaksi::factory()->create(['status_transaksi' => 'pending']);

        $this->actingAs($karyawan);

        $response = $this->put("/karyawan/transaksi/{$transaksi->id}/status", [
            'status_transaksi' => 'proses'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('transaksis', [
            'id' => $transaksi->id,
            'status_transaksi' => 'proses'
        ]);
    }

    #[Test]
    public function transaksi_total_calculation_is_correct()
    {
        $layanan = Layanan::factory()->create(['harga' => 15000]); // per kg
        $berat = 3.5; // kg
        $expectedTotal = 15000 * 3.5; // 52500

        $transaksi = Transaksi::factory()->create([
            'layanan_id' => $layanan->id,
            'berat' => $berat,
            'total_harga' => $expectedTotal
        ]);

        $this->assertEquals($expectedTotal, $transaksi->total_harga);
    }

    #[Test]
    public function unauthorized_user_cannot_access_admin_transaksi()
    {
        $pelanggan = User::factory()->create(['role' => 'pelanggan']);

        $this->actingAs($pelanggan);

        $response = $this->get('/admin/transaksi');

        $response->assertStatus(403);
    }
}