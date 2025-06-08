<?php

use App\Jobs\GenerateUserHistoryPdfJob;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

beforeEach(function () {
    Storage::fake('public');
    View::addLocation(resource_path('views'));
});

it('generates a pdf if one does not exist', function () {
    $user = User::factory()->create();
    Post::factory()->for($user)->create();
    Comment::factory()->for($user)->create();

    $safeName = Str::slug($user->name);
    $pdfPath = "pdfs/historial_{$safeName}.pdf";

    // Fake PDF facade
    Pdf::swap(new class {
        public function loadView($view, $data = []) {
            return $this;
        }
        public function output() {
            return 'fake-pdf-binary';
        }
    });

    expect(Storage::disk('public')->exists($pdfPath))->toBeFalse();

    dispatch_sync(new GenerateUserHistoryPdfJob($user->id));

    Storage::disk('public')->assertExists($pdfPath);
    Storage::disk('public')->assertMissing("other.pdf");
});

it('deletes existing pdf before regenerating', function () {
    $user = User::factory()->create();
    Post::factory()->for($user)->create();
    Comment::factory()->for($user)->create();

    $safeName = Str::slug($user->name);
    $pdfPath = "pdfs/historial_{$safeName}.pdf";

    Storage::disk('public')->put($pdfPath, 'old pdf');

    Pdf::swap(new class {
        public function loadView($view, $data = []) {
            return $this;
        }
        public function output() {
            return 'new fake-pdf-binary';
        }
    });

    dispatch_sync(new GenerateUserHistoryPdfJob($user->id));

    Storage::disk('public')->assertExists($pdfPath);
    expect(Storage::disk('public')->get($pdfPath))->toBe('new fake-pdf-binary');
});
