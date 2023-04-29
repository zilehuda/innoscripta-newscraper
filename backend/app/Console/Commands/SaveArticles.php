<?php
namespace App\Console\Commands;

use App\Services\NewsArticleServices\ArticleService;
use App\Services\NewsArticleServices\GuardianAPIService;
use App\Services\NewsArticleServices\NewsAPIService;
use App\Services\NewsArticleServices\NYTimeAPIService;
use Illuminate\Console\Command;

class SaveArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:save';


    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Save articles from various sources';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $articleService = new ArticleService(new NYTimeAPIService(), new GuardianAPIService(), new NewsAPIService());
        $articleService->saveArticles();
    }
}
