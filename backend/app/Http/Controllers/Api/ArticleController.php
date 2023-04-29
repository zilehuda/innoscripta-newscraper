<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    /**
     * Get a list of unique authors
     */
    public function getUniqueAuthors()
    {
        $authors = Cache::remember('unique_authors', 60 * 12, function () {
            return Article::distinct()
                ->whereNotNull('author')
                ->orderBy('author', 'asc')
                ->pluck('author');
        });

        return response()->json([
            'status' => true,
            'message' => 'List of unique authors',
            'authors' => $authors,
        ], 200);
    }

    /**
     * Get a list of unique sources
     */
    public function getUniqueSources()
    {
        $sources = Cache::remember('unique_sources', 60 * 12, function () {
            return Article::distinct()
                ->whereNotNull('source')
                ->orderBy('source', 'asc')
                ->pluck('source');
        });

        return response()->json([
            'status' => true,
            'message' => 'List of unique sources',
            'sources' => $sources,
        ], 200);
    }

    /**
     * Get a list of unique categories
     */
    public function getUniqueCategories()
    {
        $categories = Cache::remember('unique_categories', 60 * 12, function () {
            return Article::distinct()
                ->whereNotNull('category')
                ->orderBy('category', 'asc')
                ->pluck('category');
        });

        return response()->json([
            'status' => true,
            'message' => 'List of unique categories',
            'categories' => $categories,
        ], 200);
    }

    public function getArticles(Request $request)
    {
        // Get search keyword from request
        $keyword = $request->input('q');

        // Get filters from request
        $filters = [
            'date' => $request->input('date'),
            'category' => $request->input('category'),
            'source' => $request->input('source'),
        ];

        // Get the user's preferences
        $userPreferences = Auth::user()->preference ?? null;
        $preferredSources = $userPreferences ? $userPreferences->sources() : [];
        $preferredCategories = $userPreferences ? $userPreferences->categories() : [];
        $preferredAuthors = $userPreferences ? $userPreferences->authors() : [];

        // Build query
        $query = Article::query();

        // Apply search keyword
        if ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%$keyword%")
                    ->orWhere('description', 'like', "%$keyword%")
                    ->orWhere('author', 'like', "%$keyword%")
                    ->orWhere('category', 'like', "%$keyword%")
                    ->orWhere('source', 'like', "%$keyword%");
            });
        }

        // Apply filters
        if (!$filters['date'] && !$filters['category'] && !$filters['source'])  {
            // Apply user's preferences if no filters are given
            if ($userPreferences) {
                if (!empty($preferredSources)) {
                    $query->whereIn('source', $preferredSources);
                }
                if (!empty($preferredCategories)) {
                    $query->whereIn('category', $preferredCategories);
                }
                if (!empty($preferredAuthors)) {
                    $query->whereIn('author', $preferredAuthors);
                }
            }
        } else {
            // Apply filters from request
            foreach ($filters as $filter => $value) {
                if ($value) {
                    switch ($filter) {
                        case 'date':
                            // Filter by published date
                            $query->whereDate('published_at', $value);
                            break;
                        case 'category':
                            // Filter by category
                            $query->where('category', $value);
                            break;
                        case 'source':
                            // Filter by source
                            $query->where('source', $value);
                            break;
                    }
                }
            }
        }

        // Get paginated results
        $articles = $query->orderBy('published_at', 'desc')->paginate(10);

        // Return response
        return response()->json([
            'status' => true,
            'message' => 'List of articles',
            'data' => $articles,
        ]);
    }
}