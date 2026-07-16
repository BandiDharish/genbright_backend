@extends('backend.layout.app')

@section('title', 'Create Video Section')

@section('content')

<div class="crud-page">

    <div class="crud-form-container">

        {{-- Page header --}}
        <div class="crud-page-header">

            <div class="crud-page-header-content">

                <div class="crud-page-heading">

                    <div class="crud-page-icon">
                        <i class="fas fa-video"></i>
                    </div>

                    <div>
                        <h1 class="crud-page-title">
                            Create Video Section
                        </h1>

                        <p class="crud-page-description">
                            Add a heading, cover image and YouTube video link.
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


        {{-- Validation errors --}}
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
                        <i class="fas fa-circle-plus"></i>
                        Video Section Details
                    </h2>

                    <p class="crud-card-description">
                        Fields marked with
                        <span class="crud-required">*</span>
                        are required.
                    </p>
                </div>

            </div>


            <div class="crud-card-body">

                <form
                    action="{{ route('admin.video-sections.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="crud-form"
                    data-crud-form
                >

                    @csrf


                    {{-- Heading --}}
                    <div class="crud-form-group">

                        <label for="heading" class="crud-label">
                            Heading
                            <span class="crud-required">*</span>
                        </label>

                        <input
                            type="text"
                            id="heading"
                            name="heading"
                            value="{{ old('heading') }}"
                            class="crud-input
                                @error('heading')
                                    crud-invalid
                                @enderror"
                            placeholder="Enter the video section heading"
                            maxlength="255"
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
                                <span id="headingCount">0</span>/255
                            </span>

                        </div>

                    </div>


                    {{-- Image --}}
                    <div class="crud-form-group">

                        <label for="image" class="crud-label">
                            Cover Image
                            <span class="crud-required">*</span>
                        </label>

                        <div
                            class="crud-file-upload
                                @error('image')
                                    crud-invalid
                                @enderror"
                            id="imageUploadArea"
                        >

                            <input
                                type="file"
                                id="image"
                                name="image"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="crud-file-input"
                                required
                            >

                            <label
                                for="image"
                                class="crud-file-upload-label"
                            >

                                <span class="crud-file-upload-icon">
                                    <i class="fas fa-cloud-arrow-up"></i>
                                </span>

                                <span class="crud-file-upload-title">
                                    Select an image
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
                            hidden
                        >

                            <div class="crud-image-preview-header">

                                <span>Image preview</span>

                                <button
                                    type="button"
                                    class="crud-remove-image"
                                    id="removeImage"
                                >
                                    <i class="fas fa-times"></i>
                                    Remove
                                </button>

                            </div>

                            <img
                                src=""
                                alt="Selected image preview"
                                id="imagePreview"
                            >

                        </div>


                        @error('image')
                            <span class="crud-error">
                                <i class="fas fa-circle-exclamation"></i>
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- YouTube URL --}}
                    <div class="crud-form-group">

                        <label for="youtube_url" class="crud-label">
                            YouTube Video URL
                            <span class="crud-required">*</span>
                        </label>

                        <input
                            type="url"
                            id="youtube_url"
                            name="youtube_url"
                            value="{{ old('youtube_url') }}"
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

                        <small class="crud-help-text">
                            Paste the full YouTube video link.
                        </small>

                    </div>


                    {{-- Status --}}
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
                                @selected(old('status', '1') === '1')
                            >
                                Active
                            </option>

                            <option
                                value="0"
                                @selected(old('status') === '0')
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


                    {{-- Actions --}}
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
                            data-submit-button
                            data-loading-text="Saving..."
                        >
                            <i class="fas fa-floppy-disk"></i>
                            <span>Save Video Section</span>
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')
    <script src="{{ asset('backend/assets/js/crud-form.js') }}"></script>
@endpush