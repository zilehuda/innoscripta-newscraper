<?php

namespace App\Services\NewsArticleServices;
use Carbon\Carbon;

class NYTimeAPIService extends ArticleAPIService {
    public function getArticles() {
        $apiKey = env('NY_TIMES_API_KEY');
        $yesterdayDate = Carbon::yesterday()->toDateString();
        $url = "https://api.nytimes.com/svc/search/v2/articlesearch.json?begin_date={$yesterdayDate}&api-key={$apiKey}";
        $response = $this->makeRequest($url);
        $articles = [];
        if($response != null) {
            $articles = $response->response->docs;
        }
        return $articles;
    }

    public function getNYTUrl() {
        return "https://www.nytimes.com";
    }
}
