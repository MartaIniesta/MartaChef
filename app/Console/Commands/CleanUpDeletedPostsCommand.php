<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class CleanUpDeletedPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:cleanup-deleted';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Eliminar permanentemente las recetas que están eliminadas';

    /**
     * Execute the console command.
     */
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
