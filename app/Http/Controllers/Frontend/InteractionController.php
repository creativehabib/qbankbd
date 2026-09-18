<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Services\AiService;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function toggleBookmark(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $toggled = $question->bookmarks()->toggle(auth()->id());

        if (count($toggled['attached']) > 0) {
            $question->increment('bookmarks_count');
            $status = 'attached';
        } else {
            $question->decrement('bookmarks_count');
            $status = 'detached';
        }

        return response()->json([
            'success' => true,
            'status' => $status,
            'count' => $question->bookmarks_count
        ]);
    }

    public function toggleLike(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $toggled = $question->likes()->toggle(auth()->id());

        if (count($toggled['attached']) > 0) {
            $question->increment('likes_count');
            $status = 'attached';
        } else {
            $question->decrement('likes_count');
            $status = 'detached';
        }

        return response()->json([
            'success' => true,
            'status' => $status,
            'count' => $question->likes_count
        ]);
    }

    public function generateAiExplanation(Request $request, $id)
    {
        try {
            $question = Question::findOrFail($id);
            $geminiService = new AiService;
            $geminiService->generateAndSaveExplanation($question);
            
            // Refresh to get the description
            $question->refresh();

            return response()->json([
                'success' => true,
                'description' => $question->description
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
