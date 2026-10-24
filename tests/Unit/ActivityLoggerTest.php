<?php

namespace Tests\Unit;

use App\Models\ActivityLog;
use App\Services\ActivityLogger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ActivityLoggerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_resolves_samsung_galaxy_device_model(): void
    {
        $ua = 'Mozilla/5.0 (Linux; Android 14; SM-S928B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Mobile Safari/537.36';
        $info = ActivityLogger::parseUserAgent($ua, ['screen' => '412x915']);

        $this->assertEquals('Mobile', $info['device_type']);
        $this->assertEquals('Android 14', $info['os']);
        $this->assertStringContainsString('Samsung Galaxy S24 Ultra', $info['device_name']);
        $this->assertStringContainsString('412x915', $info['device_name']);
    }

    public function test_it_resolves_iphone_model(): void
    {
        $ua = 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Mobile/15E148 Safari/604.1';
        $info = ActivityLogger::parseUserAgent($ua, ['screen' => '393x852']);

        $this->assertEquals('Mobile', $info['device_type']);
        $this->assertEquals('iOS 17.4', $info['os']);
        $this->assertEquals('Safari 17', $info['browser']);
        $this->assertStringContainsString('Apple iPhone 14 / 15 / 16 Pro', $info['device_name']);
    }

    public function test_it_resolves_windows_pc_with_gpu(): void
    {
        $ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36';
        $info = ActivityLogger::parseUserAgent($ua, [
            'screen' => '1920x1080',
            'gpuRenderer' => 'ANGLE (Intel, Intel(R) Iris(R) Xe Graphics Direct3D11)',
        ]);

        $this->assertEquals('Desktop', $info['device_type']);
        $this->assertEquals('Windows 10 / 11', $info['os']);
        $this->assertStringContainsString('Intel Iris', $info['device_name']);
        $this->assertStringContainsString('1920x1080', $info['device_name']);
    }

    public function test_it_resolves_client_location_telemetry(): void
    {
        $request = Request::create('/test', 'POST');
        $clientSystem = [
            'city' => 'Junagadh',
            'region' => 'Gujarat',
            'postal' => '362001',
            'country' => 'India',
            'isp' => 'Reliance Jio Infocomm Limited',
        ];

        $location = ActivityLogger::resolveLocation($request, $clientSystem);
        $this->assertEquals('Junagadh, Gujarat, (362001), India • Reliance Jio Infocomm Limited', $location);
    }

    public function test_activity_logs_older_than_90_days_are_pruned(): void
    {
        // 1. Create an old log (95 days ago)
        $oldLog = ActivityLog::create([
            'action' => 'test_old',
            'description' => '95-day-old log entry',
            'created_at' => now()->subDays(95),
            'updated_at' => now()->subDays(95),
        ]);

        // 2. Create a recent log (10 days ago)
        $recentLog = ActivityLog::create([
            'action' => 'test_recent',
            'description' => '10-day-old log entry',
            'created_at' => now()->subDays(10),
            'updated_at' => now()->subDays(10),
        ]);

        // 3. Run model pruning
        Artisan::call('model:prune', [
            '--model' => [ActivityLog::class],
        ]);

        // 4. Assert old log was pruned and recent log is preserved
        $this->assertDatabaseMissing('activity_logs', ['id' => $oldLog->id]);
        $this->assertDatabaseHas('activity_logs', ['id' => $recentLog->id]);
    }

    public function test_logs_prune_90_artisan_command(): void
    {
        $oldLog = ActivityLog::create([
            'action' => 'test_old_artisan',
            'description' => '91-day-old log entry',
            'created_at' => now()->subDays(91),
            'updated_at' => now()->subDays(91),
        ]);

        Artisan::call('logs:prune-90');

        $this->assertDatabaseMissing('activity_logs', ['id' => $oldLog->id]);
    }
}
