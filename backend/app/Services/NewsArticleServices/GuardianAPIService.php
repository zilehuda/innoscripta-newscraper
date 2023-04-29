<?php

namespace App\Services\NewsArticleServices;


class GuardianAPIService extends ArticleAPIService {
    public function getArticles() {
        $yesterday = date('Y-m-d', strtotime('yesterday'));
        $apiKey = env('GUARDIAN_API_KEY');
        $url = "https://content.guardianapis.com/search?format=json&from-date=$yesterday&show-tags=contributor&show-fields=headline,thumbnail,short-url&&order-by=relevance&api-key=$apiKey";
        $response = $this->makeRequest($url);
        $articles = [];
        if($response != null) {
            $articles = $response->response->results;
        }
        return $articles;
    }
}