@extends('backend.layout.app')

@section('title', 'Submitted Enquiries')

@section('content')

<div class="crud-page">

    <div class="crud-container">

        {{-- Page Header --}}
        <div class="crud-page-header">

            <div class="crud-page-header-content">

                <div class="crud-page-heading">

                    <div class="crud-page-icon">
                        <i class="fas fa-envelope"></i>
                    </div>

                    <div>
                        <h1 class="crud-page-title">
                            Submitted Enquiries
                        </h1>

                        <p class="crud-page-description">
                            View and manage student contact forms submitted through "Begin the Journey".
                        </p>
                    </div>

                </div>

            </div>

        </div>


        {{-- Content Card --}}
        <div class="crud-card">

            <div class="crud-card-header">

                <div>
                    <h2 class="crud-card-title">
                        <i class="fas fa-list"></i>
                        All Contact Enquiries
                    </h2>

                    <p class="crud-card-description">
                        List of all submitted contact forms ordered by newest first.
                    </p>
                </div>

                <span class="crud-count">
                    <strong>{{ $contacts->total() }}</strong>

                    {{ Str::plural(
                        'Enquiry',
                        $contacts->total()
                    ) }}
                </span>

            </div>


            @if ($contacts->count())

                <div class="crud-table-responsive">

                    <table class="crud-table">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Submitted Date</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($contacts as $contact)

                                <tr>

                                    {{-- ID --}}
                                    <td data-label="ID">
                                        <span class="crud-number">
                                            #{{ $contact->id }}
                                        </span>
                                    </td>


                                    {{-- Name --}}
                                    <td data-label="Name">
                                        <strong>{{ $contact->name }}</strong>
                                    </td>


                                    {{-- Mobile --}}
                                    <td data-label="Mobile">
                                        <a href="tel:{{ $contact->mobile }}" style="color: inherit; text-decoration: none;">
                                            {{ $contact->mobile }}
                                        </a>
                                    </td>


                                    {{-- Email --}}
                                    <td data-label="Email">
                                        <a href="mailto:{{ $contact->email }}" class="crud-help-text" style="color: #4A7B49; text-decoration: none; font-weight: 500;">
                                            {{ $contact->email }}
                                        </a>
                                    </td>


                                    {{-- Message --}}
                                    <td data-label="Message" style="max-width: 250px; word-wrap: break-word; white-space: normal;">
                                        @if ($contact->message)
                                            {{ $contact->message }}
                                        @else
                                            <span style="font-style: italic; color: #94a3b8;">No message</span>
                                        @endif
                                    </td>


                                    {{-- Submitted Date --}}
                                    <td data-label="Submitted Date">
                                        <div class="crud-table-heading" style="padding: 0;">
                                            <span>{{ $contact->created_at->format('Y-m-d H:i:s') }}</span>
                                            <small>{{ $contact->created_at->diffForHumans() }}</small>
                                        </div>
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                @if ($contacts->hasPages())

                    <div class="crud-pagination">

                        <div class="crud-pagination-info">
                            Showing
                            <strong>{{ $contacts->firstItem() }}</strong>
                            to
                            <strong>{{ $contacts->lastItem() }}</strong>
                            of
                            <strong>{{ $contacts->total() }}</strong>
                            results
                        </div>

                        <div class="crud-pagination-links">
                            {{ $contacts->links() }}
                        </div>

                    </div>

                @endif

            @else

                {{-- Empty State --}}
                <div class="crud-empty-state">

                    <div class="crud-empty-icon">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>

                    <h3>No enquiries found</h3>

                    <p>
                        Any contacts submitted through the front-end form will appear here.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection
