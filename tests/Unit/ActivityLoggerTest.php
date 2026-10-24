<?php

namespace Tests\Unit;

use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Tests\TestCase;

class ActivityLoggerTest extends TestCase
{
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
}
