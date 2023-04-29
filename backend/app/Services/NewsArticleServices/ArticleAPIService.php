<?php

namespace App\Services\NewsArticleServices;

use GuzzleHttp\Client;

abstract class ArticleAPIService {
    protected $client;

    public function __construct() {
        $this->client = new Client();
    }

    protected function makeRequest($url) {
        $response = $this->client->get($url);
        $articles = null;
        if ($response->getStatusCode() == 200) {
            $response = json_decode($response->getBody());
            $articles = $response;
        }
        return $articles;
    }

    abstract public function getArticles();
}