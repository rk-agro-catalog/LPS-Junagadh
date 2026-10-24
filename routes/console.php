<?php

use App\Models\ActivityLog;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * Prune activity logs older than 90 days.
 */
Artisan::command('logs:prune-90', function () {
    $count = ActivityLog::where('created_at', '<', now()->subDays(90))->delete();
    $this->info("Successfully pruned {$count} activity log(s) older than 90 days.");
})->purpose('Automatically prune activity logs older than 90 days');

/**
 * Schedule automatic daily pruning of activity logs older than 90 days.
 */
Schedule::command('model:prune', ['--model' => [ActivityLog::class]])->daily();
