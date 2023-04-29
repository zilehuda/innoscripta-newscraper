<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPreferenceController extends Controller
{
    /**
     * Get the user's preference
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPreference(Request $request)
    {
        $user = Auth::user();

        // Check if user has a preference record
        if (!$user->preference) {
            return response()->json([
                'status' => false,
                'message' => 'User preference not found',
                'data' => [
                    'sources' => [],
                    'categories' => [],
                    'authors' => [],
                ],
            ]);
        }

        // Retrieve user's preferred sources
        $sources = $user->preference->sources();

        // Retrieve user's preferred categories
        $categories = $user->preference->categories();

        // Retrieve user's preferred authors
        $authors = $user->preference->authors();

        return response()->json([
            'status' => true,
            'message' => 'User preference retrieved successfully',
            'data' => [
                'sources' => $sources,
                'categories' => $categories,
                'authors' => $authors,
            ],
        ]);
    }

    /**
     * Add or update the user's preference
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addOrUpdatePreference(Request $request)
    {
        $user = Auth::user();

        // Validate request data
        $validatedData = $request->validate([
            'sources' => 'nullable|array',
            'categories' => 'nullable|array',
            'authors' => 'nullable|array',
        ]);

        // Add or update user's preferred sources
        if (isset($validatedData['sources'])) {
            $sources = collect($validatedData['sources'])
                ->unique()
                ->map(function ($source) {
                    return trim($source);
                })
                ->toArray();

            $user->preference()->updateOrCreate([], [
                'preferred_sources' => $sources,
            ]);
        }

        // Add or update user's preferred categories
        if (isset($validatedData['categories'])) {
            $categories = collect($validatedData['categories'])
                ->unique()
                ->map(function ($category) {
                    return trim($category);
                })
                ->toArray();

            $user->preference()->updateOrCreate([], [
                'preferred_categories' => $categories,
            ]);
        }

        // Add or update user's preferred authors
        if (isset($validatedData['authors'])) {
            $authors = collect($validatedData['authors'])
                ->unique()
                ->map(function ($author) {
                    return trim($author);
                })
                ->toArray();

            $user->preference()->updateOrCreate([], [
                'preferred_authors' => $authors,
            ]);
        }

        $preference = $user->preference()->first();

        return response()->json([
            'status' => true,
            'message' => 'User preference updated successfully',
            'data' => $preference,
        ]);
    }

}
