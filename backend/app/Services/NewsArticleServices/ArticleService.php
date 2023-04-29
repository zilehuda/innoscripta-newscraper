<?php

namespace App\Services\NewsArticleServices;
use App\Models\Article;


class ArticleService {

    protected $nyTimesAPIService;
    protected $guardianAPIService;
    protected $newsAPIService;

    public function __construct(NYTimeAPIService $nyTimesAPIService, GuardianAPIService $guardianAPIService, NewsAPIService $newsAPIService)
    {
        $this->nyTimesAPIService = $nyTimesAPIService;
        $this->guardianAPIService = $guardianAPIService;
        $this->newsAPIService = $newsAPIService;
    }

    public function saveArticles() 
    {
        $this->saveNYTimesArticles();
        $this->saveGuardianArticles();
        $this->saveNewsAPIArticles();
    }

    /**
     * Save articles from NY Times API to database
     */
    public function saveNYTimesArticles()
    {
        $articles = $this->nyTimesAPIService->getArticles();
        foreach ($articles as $article) {
            $newArticle = new Article;
            $newArticle->title = $article->headline->main;
            $newArticle->url = $article->web_url;
            $newArticle->description = $article->snippet;
            $newArticle->author = $article->byline->original;
            $newArticle->source = 'NY Times';
            $newArticle->image = isset($article->multimedia[0]) ? $this->nyTimesAPIService->getNYTUrl()."/".$article->multimedia[0]->url : null;
            $newArticle->category = $article->section_name ?? null;
            $newArticle->published_at = $article->pub_date ?? null;
            $newArticle->save();
        }
    }

    /**
     * Save articles from Guardian API to database
     */
    public function saveGuardianArticles()
    {
        $articles = $this->guardianAPIService->getArticles();

        foreach ($articles as $article) {
            $newArticle = new Article;
            $newArticle->title = $article->webTitle;
            $newArticle->url = $article->webUrl;
            $newArticle->description = $article->fields->headline;
            $newArticle->author = implode(', ', array_column($article->tags, 'webTitle'));
            $newArticle->source = 'The Guardian';
            $newArticle->image = $article->fields->thumbnail ?? null;
            $newArticle->category = $article->sectionId ?? null;
            $newArticle->published_at = $article->webPublicationDate ?? null;
            $newArticle->save();
        }
    }

    /**
     * Save articles from News API to database
     */
    public function saveNewsAPIArticles()
    {
        $articles = $this->newsAPIService->getArticles();

        foreach ($articles as $article) {
            $newArticle = new Article;
            $newArticle->title = $article->title;
            $newArticle->url = $article->url;
            $newArticle->description = $article->description;
            $newArticle->author = $article->author ?? null;
            $newArticle->source = $article->source->name ?? null;
            $newArticle->image = $article->urlToImage ?? null;
            $newArticle->published_at = $article->publishedAt ?? null;
            $newArticle->save();
        }
    }
}