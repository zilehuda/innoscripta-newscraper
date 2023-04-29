<?php

namespace App\Services\NewsArticleServices;

class NewsAPIService extends ArticleAPIService {
    public function getArticles() {
        $apiKey = env('NEWS_API_KEY');
        $fromDate = date('Y-m-d', strtotime("-1 day"));
        $url = "https://newsapi.org/v2/everything?q=apple&from={$fromDate}&to={$fromDate}&sortBy=popularity&apiKey={$apiKey}";
        $response = $this->makeRequest($url);
        $articles = [];
        if($response != null) {
            $articles = $response->articles;
        }
        return $articles;
    }
}