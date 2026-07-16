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
                    'id' => $videoSection->id,
                    'heading' => $videoSection->heading,

                    'image' => $videoSection->image
                        ? asset(
                            'storage/' .
                            ltrim($videoSection->image, '/')
                        )
                        : null,

                    'youtube_url' => $videoSection->youtube_url,
                    'status' => $videoSection->status,
                    'created_at' => $videoSection->created_at,
                    'updated_at' => $videoSection->updated_at,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Video sections fetched successfully.',
            'data' => $videoSections,
        ]);
    }

    public function show(VideoSection $videoSection): JsonResponse
    {
        if (!$videoSection->status) {
            return response()->json([
                'success' => false,
                'message' => 'Video section not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Video section fetched successfully.',
            'data' => [
                'id' => $videoSection->id,
                'heading' => $videoSection->heading,

                'image' => $videoSection->image
                    ? asset(
                        'storage/' .
                        ltrim($videoSection->image, '/')
                    )
                    : null,

                'youtube_url' => $videoSection->youtube_url,
                'status' => $videoSection->status,
                'created_at' => $videoSection->created_at,
                'updated_at' => $videoSection->updated_at,
            ],
        ]);
    }
}