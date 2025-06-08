<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\BufferedOutput;

beforeEach(function () {
    Log::spy();
    DB::table('reports')->truncate();
});

it('shows message if there are no reviewed reports', function () {
    $output = new BufferedOutput();

    Artisan::call('delete:reviewed-reports', [], $output);

    $content = $output->fetch();
    expect($content)->toContain('No hay reportes revisados para eliminar.');
});

it('deletes reviewed reports and logs each deletion', function () {
    $reporterId = DB::table('users')->insertGetId([
        'name' => 'Reporter',
        'email' => 'reporter@example.com',
        'password' => bcrypt('secret'),
    ]);

    $reportedId = DB::table('users')->insertGetId([
        'name' => 'Reported',
        'email' => 'reported@example.com',
        'password' => bcrypt('secret'),
    ]);

    $reviewed1 = DB::table('reports')->insertGetId([
        'status' => 'reviewed',
        'reporter_id' => $reporterId,
        'reported_id' => $reportedId,
        'reason' => 'spam',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $reviewed2 = DB::table('reports')->insertGetId([
        'status' => 'reviewed',
        'reporter_id' => $reporterId,
        'reported_id' => $reportedId,
        'reason' => 'abuse',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $pending = DB::table('reports')->insertGetId([
        'status' => 'pending',
        'reporter_id' => $reporterId,
        'reported_id' => $reportedId,
        'reason' => 'language',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    Log::spy();

    $output = new BufferedOutput();
    Artisan::call('delete:reviewed-reports', [], $output);
    $content = $output->fetch();

    expect($content)->toContain('Se han eliminado 2 reportes revisados.');

    $remaining = DB::table('reports')->pluck('id')->all();
    expect($remaining)->toBe([$pending]);

    Log::shouldHaveReceived('info')->with("Reporte con ID {$reviewed1} eliminado.")->once();
    Log::shouldHaveReceived('info')->with("Reporte con ID {$reviewed2} eliminado.")->once();
});
