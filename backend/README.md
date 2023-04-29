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

*`POST /api/register`: Registers a new user.

*`POST /api/login`: Logs in a user.

#### Articles

*`GET /api/authors`: Returns a list of unique authors for the articles.

*`GET /api/categories`: Returns a list of unique categories for the articles.

*`GET /api/sources`: Returns a list of unique sources for the articles.

*`GET /api/articles`: Returns a list of articles.

#### User Preferences

*`GET /api/preferences`: Returns the user's preferences.

*`POST /api/preferences`: Adds or updates the user's preferences.

## Usage

### Running the command

To retrieve and save articles, use the following command:

`php artisan articles:save`

### Running the scheduler

To automatically retrieve and save articles on a daily basis, add the following command to your Laravel scheduler:

`$schedule->command('articles:save')->daily();`

### Passing bearer token in header

To pass a bearer token in the header of the API requests, add the following to the `.env` file:

`BEARER_TOKEN=YOUR_BEARER_TOKEN_HERE`

### ArticleService file

The `ArticleService` file is responsible for retrieving and saving articles from the various sources. It uses the `NYTimeAPIService`, `GuardianAPIService`, and `NewsAPIService` classes to retrieve the articles and save them to the database. The `saveNYTimesArticles()`, `saveGuardianArticles()`, and `saveNewsAPIArticles()` methods are responsible for saving the articles from their respective sources.

## Built With

* Laravel - The PHP framework used
* Guzzle - A PHP HTTP client used for making requests to external APIs
* PHPUnit - A PHP unit testing framework used for testi
