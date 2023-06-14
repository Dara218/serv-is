<x-layout>
    @include('partials.navbar')

        <div class="md:px-16 px-4 mt-16 md:mt-24 flex flex-col gap-8">
            {{ Breadcrumbs::render('confirm-agents') }}
            <div class="notification-parent flex flex-col gap-10 justify-center items-center">
                @if ($otherDocuments->count() == 0)
                    <div class="h-[80vh] flex justify-center items-center">
                        <span class="font-semibold text-slate-500">No pending agents</span>
                    </div>

                    @else
                    @foreach ($otherDocuments as $otherDocument)
                        <div class="border-t-2 border-slate-400 text-center pt-4">
                            <span class="text-slate-500 font-semibold">{{ $otherDocument->validDocument->notification->username }} joined Serv-is! Accept verification status?
                            </span>

                            <div class="flex gap-4 justify-center py-10 items-center">
                                <button type="button" class="accepted-rejected-btn hidden ext-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 cursor-default">Accepted</button>

                                <div class="flex gap-4 justify-center items-center confirm-reject-parent">
                                    <button type="button" class="bnt-accept-notif accept-agent focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" data-id="{{ $otherDocument->validDocument->notification->id }}" data-username="{{ $otherDocument->validDocument->notification->username }}" data-message="{{ $otherDocument->validDocument->notification->message }}" data-from-user-id="{{ $otherDocument->validDocument->notification->from_user_id }}" data-to-user-id="{{ $otherDocument->validDocument->notification->user_id }}" data-type="{{ $otherDocument->validDocument->notification->type }}">Confirm</button>

                                    <button type="button" class="btn-reject-notif reject-agent ext-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" data-id="{{ $otherDocument->validDocument->notification->id }}" data-username="{{ $otherDocument->validDocument->notification->username }}" data-message="{{ $otherDocument->validDocument->notification->message }}" data-from-user-id="{{ $otherDocument->validDocument->notification->from_user_id }}" data-to-user-id="{{ $otherDocument->validDocument->notification->user_id }}" data-type="{{ $otherDocument->validDocument->notification->type }}">Reject</button>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <x-home_admin.valid-documents title="NBI Clearance"
                                src="{{ $otherDocument->validDocument->nbi_clearance }}" fancybox="valid-photos-gallery"/>

                                <x-home_admin.valid-documents title="Police Clearance"
                                src="{{ $otherDocument->validDocument->police_clearance }}" fancybox="valid-photos-gallery"/>

                                <x-home_admin.valid-documents title="Birth Certificate"
                                src="{{ $otherDocument->validDocument->birth_certificate }}" fancybox="valid-photos-gallery"/>

                                <x-home_admin.valid-documents title="Certificate of Employment"
                                src="{{ $otherDocument->validDocument->cert_of_employment }}" fancybox="valid-photos-gallery"/>

                                <x-home_admin.valid-documents title="Other valid ID"
                                src="{{ $otherDocument->validDocument->other_valid_id }}" fancybox="valid-photos-gallery"/>
                            </div>
                        </div>
                    @endforeach

                {{ $otherDocuments->links('pagination::tailwind') }}
                @endif
            </div>
        </div>

    @include('sweetalert::alert')
</x-layout>
