<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
