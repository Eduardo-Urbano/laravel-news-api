<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;

class UpdatePostsTitle extends Command
{
    protected $signature = 'posts:update-title {title}';

    protected $description = 'Update title of all posts';

    public function handle(): int
    {
        $newTitle = $this->argument('title');

        Post::query()->update([
            'title' => $newTitle
        ]);

        $this->info('All posts titles updated successfully.');

        return Command::SUCCESS;
    }
}