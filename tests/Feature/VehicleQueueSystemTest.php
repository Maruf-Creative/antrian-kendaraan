<?php

namespace Tests\Feature;

use App\Models\Antrian;
use App\Models\Kendaraan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleQueueSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_login_page()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Antrian Kendaraan');
    }

    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Tegar',
            'email' => 'tegar@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', ['email' => 'tegar@example.com']);
        $this->assertAuthenticated();
    }

    public function test_registration_validation_fails_for_short_password()
    {
        $response = $this->post('/register', [
            'name' => 'Tegar',
            'email' => 'tegar@example.com',
            'password' => '12345',
            'password_confirmation' => '12345',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_user_can_login_and_logout()
    {
        $user = User::factory()->create([
            'email' => 'driver@example.com',
            'password' => bcrypt('secret1234'),
        ]);

        $response = $this->post('/login', [
            'email' => 'driver@example.com',
            'password' => 'secret1234',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);

        $logoutResponse = $this->post('/logout');
        $logoutResponse->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_dashboard_displays_correct_user_statistics()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $k1 = Kendaraan::create([
            'user_id' => $user1->id,
            'nomor_polisi' => 'B 1234 ABC',
            'jenis_kendaraan' => 'Mobil',
            'nama_pemilik' => 'Tegar',
        ]);

        $k2 = Kendaraan::create([
            'user_id' => $user2->id,
            'nomor_polisi' => 'D 9999 XYZ',
            'jenis_kendaraan' => 'Motor',
            'nama_pemilik' => 'Budi',
        ]);

        Antrian::create([
            'kendaraan_id' => $k1->id,
            'nomor_antrian' => 'A001',
            'tanggal' => '2026-11-12',
            'waktu' => '09:00',
            'status' => 'Menunggu',
        ]);

        Antrian::create([
            'kendaraan_id' => $k2->id,
            'nomor_antrian' => 'A002',
            'tanggal' => '2026-11-12',
            'waktu' => '10:00',
            'status' => 'Selesai',
        ]);

        $response = $this->actingAs($user1)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('B 1234 ABC');
        $response->assertDontSee('D 9999 XYZ');
    }

    public function test_kendaraan_crud_lifecycle()
    {
        $user = User::factory()->create();

        // 1. Create
        $response = $this->actingAs($user)->post('/kendaraan', [
            'nomor_polisi' => 'B 8888 TEG',
            'jenis_kendaraan' => 'Mobil',
            'nama_pemilik' => 'Tegar Owner',
        ]);
        $response->assertRedirect('/kendaraan');
        $this->assertDatabaseHas('kendaraans', ['nomor_polisi' => 'B 8888 TEG']);

        $kendaraan = Kendaraan::where('nomor_polisi', 'B 8888 TEG')->first();

        // 2. Read
        $responseIndex = $this->actingAs($user)->get('/kendaraan');
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee('B 8888 TEG');

        // 3. Search
        $responseSearch = $this->actingAs($user)->get('/kendaraan?nomor_polisi=8888');
        $responseSearch->assertStatus(200);
        $responseSearch->assertSee('B 8888 TEG');

        // 4. Update
        $responseUpdate = $this->actingAs($user)->put('/kendaraan/' . $kendaraan->id, [
            'nomor_polisi' => 'B 8888 MOD',
            'jenis_kendaraan' => 'Truk',
            'nama_pemilik' => 'Tegar Owner Mod',
        ]);
        $responseUpdate->assertRedirect('/kendaraan');
        $this->assertDatabaseHas('kendaraans', ['nomor_polisi' => 'B 8888 MOD']);

        // 5. Delete
        $responseDelete = $this->actingAs($user)->delete('/kendaraan/' . $kendaraan->id);
        $responseDelete->assertRedirect('/kendaraan');
        $this->assertDatabaseMissing('kendaraans', ['nomor_polisi' => 'B 8888 MOD']);
    }

    public function test_user_cannot_access_or_modify_other_user_kendaraan()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $k1 = Kendaraan::create([
            'user_id' => $user1->id,
            'nomor_polisi' => 'B 1111 AAA',
            'jenis_kendaraan' => 'Mobil',
            'nama_pemilik' => 'User One',
        ]);

        // User2 tries to edit User1's vehicle
        $responseEdit = $this->actingAs($user2)->get('/kendaraan/' . $k1->id . '/edit');
        $responseEdit->assertStatus(403);

        // User2 tries to update User1's vehicle
        $responseUpdate = $this->actingAs($user2)->put('/kendaraan/' . $k1->id, [
            'nomor_polisi' => 'B 1111 HCK',
            'jenis_kendaraan' => 'Motor',
            'nama_pemilik' => 'Hacker',
        ]);
        $responseUpdate->assertStatus(403);

        // User2 tries to delete User1's vehicle
        $responseDelete = $this->actingAs($user2)->delete('/kendaraan/' . $k1->id);
        $responseDelete->assertStatus(403);
    }

    public function test_automatic_queue_number_generation_and_daily_reset()
    {
        $user = User::factory()->create();

        $k1 = Kendaraan::create([
            'user_id' => $user->id,
            'nomor_polisi' => 'B 1001 QQQ',
            'jenis_kendaraan' => 'Mobil',
            'nama_pemilik' => 'Queue User',
        ]);

        // First queue on date 2026-11-12 -> A001
        $this->actingAs($user)->post('/antrian', [
            'kendaraan_id' => $k1->id,
            'tanggal' => '2026-11-12',
            'waktu' => '08:30',
        ]);
        $this->assertDatabaseHas('antrians', [
            'nomor_antrian' => 'A001',
            'tanggal' => '2026-11-12',
            'status' => 'Menunggu',
        ]);

        // Second queue on same date 2026-11-12 -> A002
        $this->actingAs($user)->post('/antrian', [
            'kendaraan_id' => $k1->id,
            'tanggal' => '2026-11-12',
            'waktu' => '09:00',
        ]);
        $this->assertDatabaseHas('antrians', [
            'nomor_antrian' => 'A002',
            'tanggal' => '2026-11-12',
        ]);

        // Third queue on NEXT date 2026-11-13 -> Resets to A001
        $this->actingAs($user)->post('/antrian', [
            'kendaraan_id' => $k1->id,
            'tanggal' => '2026-11-13',
            'waktu' => '08:00',
        ]);
        $this->assertDatabaseHas('antrians', [
            'nomor_antrian' => 'A001',
            'tanggal' => '2026-11-13',
        ]);
    }

    public function test_antrian_status_update_and_filtering()
    {
        $user = User::factory()->create();

        $k1 = Kendaraan::create([
            'user_id' => $user->id,
            'nomor_polisi' => 'B 5555 FTR',
            'jenis_kendaraan' => 'Mobil',
            'nama_pemilik' => 'Filter User',
        ]);

        $antrian = Antrian::create([
            'kendaraan_id' => $k1->id,
            'nomor_antrian' => 'A001',
            'tanggal' => '2026-11-12',
            'waktu' => '10:00',
            'status' => 'Menunggu',
        ]);

        // Update status to Diproses
        $this->actingAs($user)->put('/antrian/' . $antrian->id, [
            'kendaraan_id' => $k1->id,
            'tanggal' => '2026-11-12',
            'waktu' => '10:00',
            'status' => 'Diproses',
        ]);
        $this->assertDatabaseHas('antrians', ['id' => $antrian->id, 'status' => 'Diproses']);

        // Update status to Selesai
        $this->actingAs($user)->put('/antrian/' . $antrian->id, [
            'kendaraan_id' => $k1->id,
            'tanggal' => '2026-11-12',
            'waktu' => '10:00',
            'status' => 'Selesai',
        ]);
        $this->assertDatabaseHas('antrians', ['id' => $antrian->id, 'status' => 'Selesai']);

        // Test Filter
        $response = $this->actingAs($user)->get('/antrian?status=Selesai');
        $response->assertStatus(200);
        $response->assertSee('A001');

        $responseEmpty = $this->actingAs($user)->get('/antrian?status=Menunggu');
        $responseEmpty->assertStatus(200);
        $responseEmpty->assertDontSee('A001');
    }

    public function test_pdf_reports_generation_for_kendaraan_and_antrian()
    {
        $user = User::factory()->create();

        $k = Kendaraan::create([
            'user_id' => $user->id,
            'nomor_polisi' => 'B 9999 PDF',
            'jenis_kendaraan' => 'Mobil',
            'nama_pemilik' => 'PDF Owner',
        ]);

        Antrian::create([
            'kendaraan_id' => $k->id,
            'nomor_antrian' => 'A001',
            'tanggal' => '2026-11-12',
            'waktu' => '11:00',
            'status' => 'Menunggu',
        ]);

        // Kendaraan PDF
        $responseKendaraan = $this->actingAs($user)->get('/laporan/kendaraan/pdf');
        $responseKendaraan->assertStatus(200);
        $responseKendaraan->assertHeader('Content-Type', 'application/pdf');

        // Antrian PDF
        $responseAntrian = $this->actingAs($user)->get('/laporan/antrian/pdf');
        $responseAntrian->assertStatus(200);
        $responseAntrian->assertHeader('Content-Type', 'application/pdf');
    }
}

