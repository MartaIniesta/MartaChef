<?php

use App\Livewire\UserHistory;
use App\Jobs\GenerateUserHistoryPdfJob;
use App\Models\{User, Post, Comment};
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;

beforeEach(function () {
    Storage::fake('public');
    Queue::fake();
});

it('mounts the component and loads user data, reports, posts, and comments', function () {
    $user = User::factory()->create();

    $post = Post::factory()->for($user)->create();
    $comment = Comment::factory()->for($user)->for($post)->create();

    DB::table('reports')->insert([
        'reporter_id' => $user->id,
        'reported_id' => $user->id,
        'reason' => 'Test reason',
        'status' => 'pending',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    Livewire::test(UserHistory::class, ['userId' => $user->id])
        ->assertSet('user.id', $user->id)
        ->assertSet('posts.0.id', $post->id)
        ->assertSet('comments.0.id', $comment->id)
        ->assertSee('Test reason');
});

it('dispatches job if pdf does not exist', function () {
    $user = User::factory()->create();

    Livewire::test(UserHistory::class, ['userId' => $user->id]);

    $safeName = Str::slug($user->name);
    $pdfPath = "pdfs/historial_{$safeName}.pdf";

    Storage::disk('public')->assertMissing($pdfPath);

    Queue::assertPushed(GenerateUserHistoryPdfJob::class, function ($job) use ($user) {
        $ref = new ReflectionProperty($job, 'userId');
        $userId = $ref->getValue($job);
        return $userId === $user->id;
    });
});

it('dispatches job if data updated after pdf last modified', function () {
    $user = User::factory()->create();

    $safeName = Str::slug($user->name);
    $pdfPath = "pdfs/historial_{$safeName}.pdf";

    Storage::shouldReceive('disk')->with('public')->andReturnSelf();
    Storage::shouldReceive('exists')->with($pdfPath)->andReturn(true);
    Storage::shouldReceive('lastModified')->with($pdfPath)->andReturn(now()->subDays(2)->timestamp);

    Post::factory()->for($user)->create(['updated_at' => now()]);

    Livewire::test(UserHistory::class, ['userId' => $user->id]);

    Queue::assertPushed(GenerateUserHistoryPdfJob::class, function ($job) use ($user) {
        $ref = new ReflectionProperty($job, 'userId');
        return $ref->getValue($job) === $user->id;
    });
});

it('does not dispatch job if pdf is up to date', function () {
    $user = User::factory()->create();

    $safeName = Str::slug($user->name);
    $pdfPath = "pdfs/historial_{$safeName}.pdf";

    Storage::disk('public')->put($pdfPath, 'content');
    $nowTimestamp = now()->timestamp;

    Storage::shouldReceive('disk')->with('public')->andReturnSelf();
    Storage::shouldReceive('exists')->with($pdfPath)->andReturn(true);
    Storage::shouldReceive('lastModified')->with($pdfPath)->andReturn($nowTimestamp);

    Post::factory()->for($user)->create(['updated_at' => now()->subDay()]);

    Livewire::test(UserHistory::class, ['userId' => $user->id]);

    Queue::assertNotPushed(GenerateUserHistoryPdfJob::class);
});
