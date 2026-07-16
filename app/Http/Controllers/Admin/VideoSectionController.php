<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class VideoSectionController extends Controller
{
    /**
     * Display all video sections.
     */
    public function index(): View
    {
        $videoSections = VideoSection::query()
            ->latest()
            ->paginate(10);

        return view(
            'backend.pages.video-sections.index',
            compact('videoSections')
        );
    }

    /**
     * Show create form.
     */
    public function create(): View
    {
        return view('backend.pages.video-sections.create');
    }

    /**
     * Store a new video section.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'heading' => [
                'required',
                'string',
                'max:255',
            ],

            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'youtube_url' => [
                'required',
                'url',
                'max:500',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);

        $imagePath = $request
            ->file('image')
            ->store('video-sections', 'public');

        try {
            VideoSection::create([
                'heading' => $validated['heading'],
                'image' => $imagePath,
                'youtube_url' => $validated['youtube_url'],
                'status' => (bool) $validated['status'],
            ]);
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($imagePath);

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Failed to create the video section. Please try again.'
                );
        }

        return redirect()
            ->route('admin.video-sections.index')
            ->with(
                'success',
                'Video section created successfully.'
            );
    }

    /**
     * Show edit form.
     */
    public function edit(VideoSection $videoSection): View
    {
        return view(
            'backend.pages.video-sections.edit',
            compact('videoSection')
        );
    }

    /**
     * Update a video section.
     */
    public function update(
        Request $request,
        VideoSection $videoSection
    ): RedirectResponse {
        $validated = $request->validate([
            'heading' => [
                'required',
                'string',
                'max:255',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'youtube_url' => [
                'required',
                'url',
                'max:500',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);

        $oldImagePath = $videoSection->image;
        $newImagePath = null;

        if ($request->hasFile('image')) {
            $newImagePath = $request
                ->file('image')
                ->store('video-sections', 'public');
        }

        try {
            $videoSection->update([
                'heading' => $validated['heading'],
                'image' => $newImagePath ?? $oldImagePath,
                'youtube_url' => $validated['youtube_url'],
                'status' => (bool) $validated['status'],
            ]);
        } catch (Throwable $exception) {
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Failed to update the video section. Please try again.'
                );
        }

        if (
            $newImagePath &&
            $oldImagePath &&
            Storage::disk('public')->exists($oldImagePath)
        ) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return redirect()
            ->route('admin.video-sections.index')
            ->with(
                'success',
                'Video section updated successfully.'
            );
    }

    /**
     * Delete a video section.
     */
    public function destroy(
        Request $request,
        VideoSection $videoSection
    ): JsonResponse|RedirectResponse {
        try {
            $imagePath = $videoSection->image;

            $videoSection->delete();

            if (
                $imagePath &&
                Storage::disk('public')->exists($imagePath)
            ) {
                Storage::disk('public')->delete($imagePath);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Video section deleted successfully.',
                ]);
            }

            return redirect()
                ->route('admin.video-sections.index')
                ->with(
                    'success',
                    'Video section deleted successfully.'
                );
        } catch (Throwable $exception) {
            report($exception);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete the video section. Please try again.',
                ], 500);
            }

            return redirect()
                ->route('admin.video-sections.index')
                ->with(
                    'error',
                    'Failed to delete the video section. Please try again.'
                );
        }
    }
}