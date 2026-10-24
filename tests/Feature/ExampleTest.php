<?php

namespace Tests\Feature;

use App\Models\Bhumidan;
use App\Models\BookingInquiry;
use App\Models\Event;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test home page returns 200.
     */
    public function test_the_home_page_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ');
    }

    /**
     * Test sankalp page returns 200.
     */
    public function test_sankalp_page_returns_successful_response(): void
    {
        $response = $this->get('/sankalp');
        $response->assertStatus(200);
        $response->assertSee('પ્રમુખ સેવા સંકલ્પ');
    }

    /**
     * Test bhumidan page returns 200.
     */
    public function test_bhumidan_page_returns_successful_response(): void
    {
        $response = $this->get('/bhumidan');
        $response->assertStatus(200);
        $response->assertSee('૨૫૦૦');
    }

    /**
     * Test booking page returns 200.
     */
    public function test_booking_page_returns_successful_response(): void
    {
        $response = $this->get('/booking');
        $response->assertStatus(200);
        $response->assertSee('બુકિંગ');
    }

    /**
     * Test submitting a bhumidan donation pledge.
     */
    public function test_bhumidan_pledge_submission_succeeds(): void
    {
        $response = $this->post('/bhumidan', [
            'donor_name' => 'પરીક્ષણ દાતાશ્રી',
            'phone' => '9876543210',
            'village' => 'જૂનાગઢ',
            'city' => 'જૂનાગઢ',
            'sq_yards' => 2,
            'payment_method' => 'UPI',
            'transaction_id' => 'TEST12345',
            'notes' => 'ટેસ્ટ નોંધ',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('bhumidans', [
            'donor_name' => 'પરીક્ષણ દાતાશ્રી',
            'sq_yards' => 2,
            'total_amount' => 5000,
        ]);
    }

    /**
     * Test unauthenticated user is redirected from admin to login page.
     */
    public function test_guest_is_redirected_to_admin_login(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    }

    /**
     * Test admin login page loads successfully.
     */
    public function test_admin_login_page_renders_successfully(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        $response->assertSee('એડમિન લૉગિન');
        $response->assertSee('admin@lpsjunagadh.com');
    }

    /**
     * Test admin can authenticate with correct credentials.
     */
    public function test_admin_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@lpsjunagadh.com',
            'password' => bcrypt('admin123'),
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@lpsjunagadh.com',
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test receipt page displays 1-click WhatsApp share buttons.
     */
    public function test_receipt_page_shows_whatsapp_share_buttons(): void
    {
        $donation = Bhumidan::create([
            'receipt_number' => 'LPS-JND-2026-TEST',
            'donor_name' => 'રમેશભાઈ પટેલ',
            'phone' => '9876543210',
            'city' => 'જૂનાગઢ',
            'sq_yards' => 2,
            'rate_per_yard' => 2500,
            'total_amount' => 5000,
            'payment_method' => 'UPI',
            'status' => 'verified',
        ]);

        // 1. Guest access is forbidden - redirects to bhumidan page
        $guestResponse = $this->get('/bhumidan/receipt/'.$donation->receipt_number);
        $guestResponse->assertRedirect(route('bhumidan'));

        // 2. Authenticated Admin can view and share receipt
        $admin = User::factory()->create();
        $adminResponse = $this->actingAs($admin)->get('/bhumidan/receipt/'.$donation->receipt_number);
        $adminResponse->assertStatus(200);
        $adminResponse->assertSee('WhatsApp પર શેર કરો');
        $adminResponse->assertSee('api.whatsapp.com/send');
        $adminResponse->assertSee('909 33 909 34');
    }

    /**
     * Test bhumidan page contains 1-click UPI pay button.
     */
    public function test_bhumidan_page_shows_upi_button(): void
    {
        $response = $this->get('/bhumidan');
        $response->assertStatus(200);
        $response->assertSee('dynamicUpiPayBtn');
        $response->assertSee('upi://pay');
    }

    /**
     * Test public events page loads and displays events.
     */
    public function test_public_events_page_renders_successfully(): void
    {
        Event::create([
            'title' => 'ટેસ્ટ સમાજ સ્નેહમિલન',
            'category' => 'સ્નેહમિલન',
            'event_date' => now()->addDays(5)->toDateString(),
            'venue' => 'જૂનાગઢ સંકુલ',
            'is_active' => true,
        ]);

        $response = $this->get('/events');
        $response->assertStatus(200);
        $response->assertSee('ટેસ્ટ સમાજ સ્નેહમિલન');
        $response->assertSee('જૂનાગઢ સંકુલ');
    }

    /**
     * Test admin can create offline bhumidan donor and delete it.
     */
    public function test_admin_can_manage_offline_bhumidan(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/bhumidans/store', [
            'donor_name' => 'ઓફલાઇન દાતાશ્રી',
            'phone' => '9988776655',
            'city' => 'જૂનાગઢ',
            'sq_yards' => 4,
            'payment_method' => 'Cash',
            'status' => 'verified',
        ]);

        $response->assertRedirect('/admin/bhumidans');
        $this->assertDatabaseHas('bhumidans', [
            'donor_name' => 'ઓફલાઇન દાતાશ્રી',
            'sq_yards' => 4,
            'total_amount' => 10000,
            'payment_method' => 'Cash',
        ]);

        $bhumidan = Bhumidan::where('donor_name', 'ઓફલાઇન દાતાશ્રી')->first();
        $delResponse = $this->actingAs($admin)->delete('/admin/bhumidans/'.$bhumidan->id);
        $delResponse->assertRedirect('/admin/bhumidans');
        $this->assertDatabaseMissing('bhumidans', ['id' => $bhumidan->id]);
    }

    /**
     * Test admin can create offline booking and delete it.
     */
    public function test_admin_can_manage_offline_booking(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/bookings/store', [
            'applicant_name' => 'ઓફલાઇન અરજદાર',
            'phone' => '9825123456',
            'section_type' => 'વિભાગ-૧',
            'facility_name' => 'પાર્ટી પ્લોટ',
            'event_type' => 'લગ્ન પ્રસંગ',
            'event_date' => now()->addDays(20)->toDateString(),
            'approx_guests' => 600,
            'status' => 'confirmed',
        ]);

        $response->assertRedirect('/admin/bookings');
        $this->assertDatabaseHas('booking_inquiries', [
            'applicant_name' => 'ઓફલાઇન અરજદાર',
            'status' => 'confirmed',
        ]);

        $booking = BookingInquiry::where('applicant_name', 'ઓફલાઇન અરજદાર')->first();
        $delResponse = $this->actingAs($admin)->delete('/admin/bookings/'.$booking->id);
        $delResponse->assertRedirect('/admin/bookings');
        $this->assertDatabaseMissing('booking_inquiries', ['id' => $booking->id]);
    }

    /**
     * Test admin can create offline member and delete it.
     */
    public function test_admin_can_manage_offline_member(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/members/store', [
            'full_name' => 'કાંતિભાઈ પટેલ',
            'surname' => 'પટેલ',
            'gender' => 'male',
            'current_address' => 'જૂનાગઢ બાયપાસ',
            'city' => 'જૂનાગઢ',
            'phone' => '9898012345',
            'family_members_count' => 5,
            'status' => 'approved',
        ]);

        $response->assertRedirect('/admin/members');
        $this->assertDatabaseHas('members', [
            'full_name' => 'કાંતિભાઈ પટેલ',
            'phone' => '9898012345',
        ]);

        $member = Member::where('full_name', 'કાંતિભાઈ પટેલ')->first();
        $delResponse = $this->actingAs($admin)->delete('/admin/members/'.$member->id);
        $delResponse->assertRedirect('/admin/members');
        $this->assertDatabaseMissing('members', ['id' => $member->id]);
    }

    /**
     * Test admin can manage gallery and events.
     */
    public function test_admin_can_manage_events_and_gallery(): void
    {
        $admin = User::factory()->create();

        // Event creation
        $evResponse = $this->actingAs($admin)->post('/admin/events/store', [
            'title' => 'ટેસ્ટ કાર્યક્રમ',
            'category' => 'સામાજિક',
            'event_date' => now()->addDays(10)->toDateString(),
            'venue' => 'LPS Junagadh સંકુલ',
            'is_active' => true,
        ]);
        $evResponse->assertRedirect('/admin/events');
        $this->assertDatabaseHas('events', ['title' => 'ટેસ્ટ કાર્યક્રમ']);

        // Gallery creation
        $galResponse = $this->actingAs($admin)->post('/admin/gallery/store', [
            'title' => 'સંકુલ ફોટો ટેસ્ટ',
            'category' => 'construction',
            'media_type' => 'image',
            'media_url' => 'https://example.com/test.jpg',
        ]);
        $galResponse->assertRedirect('/admin/gallery');
        $this->assertDatabaseHas('gallery_items', ['title' => 'સંકુલ ફોટો ટેસ્ટ']);
    }

    /**
     * Test OWASP defensive security headers are attached to responses.
     */
    public function test_security_headers_are_present_on_responses(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
    }

    /**
     * Test admin can update password securely.
     */
    public function test_admin_can_update_password_securely(): void
    {
        $admin = User::factory()->create([
            'password' => bcrypt('oldpassword123'),
        ]);

        $response = $this->actingAs($admin)->post('/admin/security/password', [
            'current_password' => 'oldpassword123',
            'password' => 'NewSecurePass@2026',
            'password_confirmation' => 'NewSecurePass@2026',
        ]);

        $response->assertSessionHas('success');
        $admin->refresh();
        $this->assertTrue(Hash::check('NewSecurePass@2026', $admin->password));
    }

    /**
     * Test admin cannot update password with incorrect current password.
     */
    public function test_admin_cannot_update_password_with_wrong_current_password(): void
    {
        $admin = User::factory()->create([
            'password' => bcrypt('oldpassword123'),
        ]);

        $response = $this->actingAs($admin)->post('/admin/security/password', [
            'current_password' => 'wrongpassword',
            'password' => 'NewSecurePass@2026',
            'password_confirmation' => 'NewSecurePass@2026',
        ]);

        $response->assertSessionHasErrors(['current_password']);
        $admin->refresh();
        $this->assertTrue(Hash::check('oldpassword123', $admin->password));
    }
}
