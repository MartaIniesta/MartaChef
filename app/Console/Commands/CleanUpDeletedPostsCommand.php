<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class CleanUpDeletedPostsCommand extends Command
{
    protected $signature = 'posts:cleanup-deleted';
    protected $description = 'Eliminar permanentemente las recetas que están eliminadas';

    public function handle()
    {
        $posts = Post::onlyTrashed()->get();

        $count = $posts->count();

        if ($count === 0) {
            $this->info("No se encontraron recetas eliminadas para eliminarlas permanentemente.");
            return 0;
        }

        foreach ($posts as $post) {
            $post->forceDelete();
            $this->info("Receta con ID {$post->id} eliminada permanentemente.");
        }

        $this->info("Se han eliminado permanentemente {$count} recetas.");
        return 0;
    }
}
