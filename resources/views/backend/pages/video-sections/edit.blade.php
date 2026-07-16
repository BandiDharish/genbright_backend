@extends('backend.layout.app')

@section('title', 'Edit Video Section')

@section('content')

<div class="crud-page">

    <div class="crud-form-container">

        <div class="crud-page-header">

            <div class="crud-page-header-content">

                <div class="crud-page-heading">

                    <div class="crud-page-icon">
                        <i class="fas fa-pen"></i>
                    </div>

                    <div>
                        <h1 class="crud-page-title">
                            Edit Video Section
                        </h1>

                        <p class="crud-page-description">
                            Update the video section information.
                        </p>
                    </div>

                </div>

                <a
                    href="{{ route('admin.video-sections.index') }}"
                    class="crud-btn crud-btn-light"
                >
                    <i class="fas fa-arrow-left"></i>
                    Back to List
                </a>

            </div>

        </div>


        @if ($errors->any())

            <div class="crud-alert crud-alert-danger">

                <div class="crud-alert-icon">
                    <i class="fas fa-circle-exclamation"></i>
                </div>

                <div class="crud-alert-content">

                    <strong>Please correct the errors below.</strong>

                    <ul class="crud-alert-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

                <button
                    type="button"
                    class="crud-alert-close"
                    aria-label="Close"
                >
                    <i class="fas fa-times"></i>
                </button>

            </div>

        @endif


        <div class="crud-card">

            <div class="crud-card-header">

                <div>
                    <h2 class="crud-card-title">
                        <i class="fas fa-video"></i>
                        Update Video Section
                    </h2>

                    <p class="crud-card-description">
                        Leave the image field empty to keep the current image.
                    </p>
                </div>

            </div>


            <div class="crud-card-body">

                <form
                    action="{{ route(
                        'admin.video-sections.update',
                        $videoSection
                    ) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="crud-form"
                    data-crud-form
                >

                    @csrf
                    @method('PUT')


                    <div class="crud-form-group">

                        <label for="heading" class="crud-label">
                            Heading
                            <span class="crud-required">*</span>
                        </label>

                        <input
                            type="text"
                            id="heading"
                            name="heading"
                            value="{{ old(
                                'heading',
                                $videoSection->heading
                            ) }}"
                            class="crud-input
                                @error('heading')
                                    crud-invalid
                                @enderror"
                            placeholder="Enter the video section heading"
                            maxlength="255"
                            data-crud-counter-input
                            required
                        >

                        <div class="crud-field-footer">

                            @error('heading')
                                <span class="crud-error">
                                    <i class="fas fa-circle-exclamation"></i>
                                    {{ $message }}
                                </span>
                            @enderror

                            <span class="crud-character-count">
                                <span id="headingCount" data-crud-counter>
                                    {{ strlen(old(
                                        'heading',
                                        $videoSection->heading
                                    )) }}
                                </span>/255
                            </span>

                        </div>

                    </div>


                    @if ($videoSection->image)

                        <div class="crud-current-image">

                            <span class="crud-current-image-label">
                                Current Image
                            </span>

                            <img
                                src="{{ asset(
                                    'storage/' . $videoSection->image
                                ) }}"
                                alt="{{ $videoSection->heading }}"
                            >

                        </div>

                    @endif


                    <div class="crud-form-group">

                        <label for="image" class="crud-label">
                            Replace Image
                        </label>

                        <div
                            class="crud-file-upload
                                @error('image')
                                    crud-invalid
                                @enderror"
                            id="imageUploadArea"
                            data-crud-upload-area
                        >

                            <input
                                type="file"
                                id="image"
                                name="image"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="crud-file-input"
                                data-crud-image-input
                            >

                            <label
                                for="image"
                                class="crud-file-upload-label"
                            >

                                <span class="crud-file-upload-icon">
                                    <i class="fas fa-cloud-arrow-up"></i>
                                </span>

                                <span class="crud-file-upload-title">
                                    Select a replacement image
                                </span>

                                <span class="crud-file-upload-text">
                                    or drag and drop here
                                </span>

                                <span class="crud-file-upload-info">
                                    JPG, JPEG, PNG or WEBP — maximum 5 MB
                                </span>

                            </label>

                        </div>


                        <div
                            class="crud-image-preview-box"
                            id="imagePreviewBox"
                            data-crud-preview-box
                            hidden
                        >

                            <div class="crud-image-preview-header">

                                <span>New image preview</span>

                                <button
                                    type="button"
                                    class="crud-remove-image"
                                    id="removeImage"
                                    data-crud-remove-image
                                >
                                    <i class="fas fa-times"></i>
                                    Remove
                                </button>

                            </div>

                            <img
                                src=""
                                alt="Selected image preview"
                                id="imagePreview"
                                data-crud-preview-image
                            >

                        </div>


                        @error('image')
                            <span class="crud-error">
                                <i class="fas fa-circle-exclamation"></i>
                                {{ $message }}
                            </span>
                        @enderror

                        <small class="crud-help-text">
                            Leave empty to keep the existing image.
                        </small>

                    </div>


                    <div class="crud-form-group">

                        <label for="youtube_url" class="crud-label">
                            YouTube Video URL
                            <span class="crud-required">*</span>
                        </label>

                        <input
                            type="url"
                            id="youtube_url"
                            name="youtube_url"
                            value="{{ old(
                                'youtube_url',
                                $videoSection->youtube_url
                            ) }}"
                            class="crud-input
                                @error('youtube_url')
                                    crud-invalid
                                @enderror"
                            placeholder="https://www.youtube.com/watch?v=..."
                            maxlength="500"
                            required
                        >

                        @error('youtube_url')
                            <span class="crud-error">
                                <i class="fas fa-circle-exclamation"></i>
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <div class="crud-form-group">

                        <label for="status" class="crud-label">
                            Status
                            <span class="crud-required">*</span>
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="crud-select
                                @error('status')
                                    crud-invalid
                                @enderror"
                            required
                        >

                            <option
                                value="1"
                                @selected(
                                    old(
                                        'status',
                                        $videoSection->status
                                    ) == 1
                                )
                            >
                                Active
                            </option>

                            <option
                                value="0"
                                @selected(
                                    old(
                                        'status',
                                        $videoSection->status
                                    ) == 0
                                )
                            >
                                Inactive
                            </option>

                        </select>

                        @error('status')
                            <span class="crud-error">
                                <i class="fas fa-circle-exclamation"></i>
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <div class="crud-form-actions">

                        <a
                            href="{{ route('admin.video-sections.index') }}"
                            class="crud-btn crud-btn-light"
                        >
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="crud-btn crud-btn-primary"
                            data-crud-submit
                            data-loading-text="Updating..."
                        >
                            <i class="fas fa-floppy-disk"></i>
                            <span>Update Video Section</span>
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection

