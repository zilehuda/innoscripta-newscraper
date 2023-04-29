# innoscripta-newscraper

This is a simple news aggregator app that retrieves news articles from various sources and saves them in a database. The app is built with PHP and Laravel.

## Features

* Retrieves news articles from three different sources: The New York Times, The Guardian, and News API.
* Saves articles in a MySQL database.
* Uses a console command to trigger the process of retrieving and saving articles.
* Automatically retrieves and saves articles on a daily basis.

## Installation

1. Clone this repository to your local machine using `https://github.com/<username>/news-aggregator.git`.
2. CD to the project root and run `composer install` to install the dependencies.
3. Create a `.env` file by running `cp .env.example .env` and set up your environment variables, such as the database credentials and API keys.
4. Run the migrations using `php artisan migrate`.

### Available Routes

The following routes are available in this API:

#### Authentication

* `POST /api/register`: Registers a new user.
* `POST /api/login`: Logs in a user.

#### Articles

* `GET /api/authors`: Returns a list of unique authors for the articles.
* `GET /api/categories`: Returns a list of unique categories for the articles.
* `GET /api/sources`: Returns a list of unique sources for the articles.
* `GET /api/articles`: Returns a list of articles.

#### User Preferences

* `GET /api/preferences`: Returns the user's preferences.
* `POST /api/preferences`: Adds or updates the user's preferences.

## Usage

### Running the command

To retrieve and save articles, use the following command:

<pre><div class="bg-black rounded-md mb-4"><div class="flex items-center relative text-gray-200 bg-gray-800 px-4 py-2 text-xs font-sans justify-between rounded-t-md"><span>bash</span><button class="flex ml-auto gap-2"><svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>Copy code</button></div><div class="p-4 overflow-y-auto"><code class="!whitespace-pre hljs language-bash">php artisan articles:save
</code></div></div></pre>

### Running the scheduler

To automatically retrieve and save articles on a daily basis, add the following command to your Laravel scheduler:

<pre><div class="bg-black rounded-md mb-4"><div class="flex items-center relative text-gray-200 bg-gray-800 px-4 py-2 text-xs font-sans justify-between rounded-t-md"><span>php</span><button class="flex ml-auto gap-2"><svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>Copy code</button></div><div class="p-4 overflow-y-auto"><code class="!whitespace-pre hljs language-php">$schedule->command('articles:save')->daily();
</code></div></div></pre>

### Passing bearer token in header

To pass a bearer token in the header of the API requests, add the following to the `.env` file:

<pre><div class="bg-black rounded-md mb-4"><div class="flex items-center relative text-gray-200 bg-gray-800 px-4 py-2 text-xs font-sans justify-between rounded-t-md"><span>bash</span><button class="flex ml-auto gap-2"><svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>Copy code</button></div><div class="p-4 overflow-y-auto"><code class="!whitespace-pre hljs language-bash">BEARER_TOKEN=YOUR_BEARER_TOKEN_HERE
</code></div></div></pre>

### ArticleService file

The `ArticleService` file is responsible for retrieving and saving articles from the various sources. It uses the `NYTimeAPIService`, `GuardianAPIService`, and `NewsAPIService` classes to retrieve the articles and save them to the database. The `saveNYTimesArticles()`, `saveGuardianArticles()`, and `saveNewsAPIArticles()` methods are responsible for saving the articles from their respective sources.

## Built With

* Laravel - The PHP framework used
* Guzzle - A PHP HTTP client used for making requests to external APIs
* PHPUnit - A PHP unit testing framework used for testi
