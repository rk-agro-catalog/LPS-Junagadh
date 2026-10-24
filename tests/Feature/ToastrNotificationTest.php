<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class ToastrNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_includes_toastr_script(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('js/lps-toast.js');
        $response->assertSee('window.toastr', false);
    }

    public function test_admin_login_page_includes_toastr_script(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('js/lps-toast.js');
        $response->assertSee('window.toastr', false);
    }

    public function test_flash_success_triggers_toastr_success(): void
    {
        $response = $this->withSession([
            'success' => 'દાન નોંધણી સફળતાપૂર્વક થઈ ગઈ છે.',
        ])->get('/');

        $response->assertStatus(200);
        $response->assertSee('window.toastr.success("દાન નોંધણી સફળતાપૂર્વક થઈ ગઈ છે.")', false);
    }

    public function test_flash_error_triggers_toastr_error(): void
    {
        $response = $this->withSession([
            'error' => 'ચુકવણી વિગતમાં ભૂલ જણાઈ છે.',
        ])->get('/');

        $response->assertStatus(200);
        $response->assertSee('window.toastr.error("ચુકવણી વિગતમાં ભૂલ જણાઈ છે.")', false);
    }

    public function test_validation_errors_render_consolidated_toastr_validation_call(): void
    {
        $errors = new MessageBag([
            'donor_name' => ['દાતાશ્રીનું નામ જરૂરી છે.'],
            'phone' => ['૧૦ અંકનો મોબાઈલ નંબર દાખલ કરવો જરૂરી છે.'],
        ]);
        $viewErrorBag = new ViewErrorBag;
        $viewErrorBag->put('default', $errors);

        $view = $this->view('partials.toastr', [
            'errors' => $viewErrorBag,
        ]);

        $view->assertSee('window.toastr.validation', false);
        $view->assertSee('દાતાશ્રીનું નામ જરૂરી છે.', false);
        $view->assertSee('૧૦ અંકનો મોબાઈલ નંબર દાખલ કરવો જરૂરી છે.', false);
    }
}
