<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VideoSection;
use Illuminate\Http\JsonResponse;

class VideoSectionController extends Controller
{
    public function index(): JsonResponse
    {
        $videoSections = VideoSection::query()
            ->where('status', true)
            ->latest()
            ->get()
            ->map(function (VideoSection $videoSection) {
                return [
                    'heading' => $videoSection->heading,
                    'image' => $videoSection->image
                        ? asset(
                            'storage/' .
                            ltrim($videoSection->image, '/')
                        )
                        : null,
                    'youtube_url' => $videoSection->youtube_url,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Video sections fetched successfully.',
            'data' => $videoSections,
        ]);
    }
}