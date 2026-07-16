@extends('backend.layout.app')

@section('title', 'Video Sections')

@section('content')

<div class="crud-page">

    <div class="crud-container">

        {{-- Page Header --}}
        <div class="crud-page-header">

            <div class="crud-page-header-content">

                <div class="crud-page-heading">

                    <div class="crud-page-icon">
                        <i class="fas fa-video"></i>
                    </div>

                    <div>
                        <h1 class="crud-page-title">
                            Video Sections
                        </h1>

                        <p class="crud-page-description">
                            Manage video section content displayed on your website.
                        </p>
                    </div>

                </div>

                <a
                    href="{{ route('admin.video-sections.create') }}"
                    class="crud-btn crud-btn-primary"
                >
                    <i class="fas fa-plus"></i>
                    Add Video Section
                </a>

            </div>

        </div>


        {{-- Content Card --}}
        <div class="crud-card">

            <div class="crud-card-header">

                <div>
                    <h2 class="crud-card-title">
                        <i class="fas fa-list"></i>
                        All Video Sections
                    </h2>

                    <p class="crud-card-description">
                        View, edit or delete existing video sections.
                    </p>
                </div>

                <span class="crud-count">
                    <strong>{{ $videoSections->total() }}</strong>

                    {{ Str::plural(
                        'Section',
                        $videoSections->total()
                    ) }}
                </span>

            </div>


            @if ($videoSections->count())

                <div class="crud-table-responsive">

                    <table class="crud-table">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Heading</th>
                                <th>Video</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($videoSections as $videoSection)

                                <tr id="video-row-{{ $videoSection->id }}">

                                    {{-- Serial Number --}}
                                    <td data-label="#">

                                        <span class="crud-number">
                                            {{ $videoSections->firstItem()
                                                + $loop->index }}
                                        </span>

                                    </td>


                                    {{-- Image --}}
                                    <td data-label="Image">

                                        @if ($videoSection->image)

                                            <img
                                                src="{{ asset(
                                                    'storage/' .
                                                    $videoSection->image
                                                ) }}"
                                                alt="{{ $videoSection->heading }}"
                                                class="crud-table-image"
                                                loading="lazy"
                                            >

                                        @else

                                            <span class="crud-help-text">
                                                No image
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Heading --}}
                                    <td data-label="Heading">

                                        <div class="crud-table-heading">

                                            <strong>
                                                {{ Str::limit(
                                                    $videoSection->heading,
                                                    55
                                                ) }}
                                            </strong>

                                            <small>
                                                Created
                                                {{ $videoSection
                                                    ->created_at
                                                    ->diffForHumans() }}
                                            </small>

                                        </div>

                                    </td>


                                    {{-- Video --}}
                                    <td data-label="Video">

                                        @if ($videoSection->youtube_url)

                                            <a
                                                href="{{ $videoSection->youtube_url }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="crud-btn crud-btn-youtube crud-btn-sm"
                                            >
                                                <i class="fab fa-youtube"></i>
                                                Watch
                                            </a>

                                        @else

                                            <span class="crud-help-text">
                                                No video
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Status --}}
                                    <td data-label="Status">

                                        <span
                                            class="crud-status
                                            {{ $videoSection->status
                                                ? 'crud-status-active'
                                                : 'crud-status-inactive' }}"
                                        >
                                            {{ $videoSection->status
                                                ? 'Active'
                                                : 'Inactive' }}
                                        </span>

                                    </td>


                                    {{-- Actions --}}
                                    <td data-label="Actions">

                                        <div class="crud-table-actions">

                                            <a
                                                href="{{ route(
                                                    'admin.video-sections.edit',
                                                    $videoSection
                                                ) }}"
                                                class="crud-btn crud-btn-edit crud-btn-sm"
                                            >
                                                <i class="fas fa-pen"></i>
                                                Edit
                                            </a>


                                            <button
                                                type="button"
                                                class="crud-btn crud-btn-danger crud-btn-sm"

                                                data-crud-delete

                                                data-delete-url="{{ route(
                                                    'admin.video-sections.destroy',
                                                    $videoSection
                                                ) }}"

                                                data-delete-row="video-row-{{ $videoSection->id }}"

                                                data-delete-title="{{ $videoSection->heading }}"
                                            >
                                                <i class="fas fa-trash-alt"></i>
                                                Delete
                                            </button>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                @if ($videoSections->hasPages())

                    <div class="crud-pagination">

                        <div class="crud-pagination-info">
                            Showing
                            <strong>{{ $videoSections->firstItem() }}</strong>
                            to
                            <strong>{{ $videoSections->lastItem() }}</strong>
                            of
                            <strong>{{ $videoSections->total() }}</strong>
                            results
                        </div>

                        <div class="crud-pagination-links">
                            {{ $videoSections->links() }}
                        </div>

                    </div>

                @endif

            @else

                {{-- Empty State --}}
                <div class="crud-empty-state">

                    <div class="crud-empty-icon">
                        <i class="fas fa-video-slash"></i>
                    </div>

                    <h3>No video sections found</h3>

                    <p>
                        Create your first video section to display
                        video content on your website.
                    </p>

                    <a
                        href="{{ route(
                            'admin.video-sections.create'
                        ) }}"
                        class="crud-btn crud-btn-primary"
                    >
                        <i class="fas fa-plus"></i>
                        Add Video Section
                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection