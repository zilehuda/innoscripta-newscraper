<?php
namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test the "getUniqueAuthors" method of the ArticleController.
     *
     * @return void
     */
    public function testGetUniqueAuthors()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        // Create some articles with different authors
        $articles = Article::factory()->count(3)->create([
            'author' => 'John Doe',
        ]);
        Article::factory()->count(2)->create([
            'author' => 'Jane Doe',
        ]);

        // Make a request to the endpoint
        $response = $this->getJson('/api/authors');

        // Assert that the response has a "success" status
        $response->assertStatus(200)->assertJson([
            'status' => true,
        ]);

        // Assert that the response has the expected authors
        $response->assertJsonFragment([
            'authors' => [
                'John Doe',
                'Jane Doe',
            ],
        ]);
    }

    /**
     * Test the "getUniqueCategories" method of the ArticleController.
     *
     * @return void
     */
    public function testGetUniqueCategories()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        // Create some articles with different categories
        $articles = Article::factory()->count(3)->create([
            'category' => 'Technology',
        ]);
        Article::factory()->count(2)->create([
            'category' => 'Sports',
        ]);

        // Make a request to the endpoint
        $response = $this->getJson('/api/categories');

        // Assert that the response has a "success" status
        $response->assertStatus(200)->assertJson([
            'status' => true,
        ]);

        // Assert that the response has the expected categories
        $response->assertJsonFragment([
            'categories' => [
                'Technology',
                'Sports',
            ],
        ]);
    }

    /**
     * Test the "getArticles" method of the ArticleController.
     *
     * @return void
     */
    public function testGetArticles()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create some articles
        $articles = Article::factory()->count(3)->create();

        // Make a request to the endpoint
        $response = $this->getJson('/api/articles');

        // Assert that the response has a "success" status
        $response->assertStatus(200)->assertJson([
            'status' => true,
        ]);

        // Assert that the response has the expected data
        $response->assertJsonFragment([
            'data' => $articles->toArray(),
        ]);
    }
}