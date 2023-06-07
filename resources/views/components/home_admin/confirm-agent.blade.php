<x-layout>
    @include('partials.navbar')

        <div class="md:px-16 px-4 mt-16 md:mt-24 flex flex-col gap-8">
            <div class="notification-parent flex flex-col gap-10 justify-center items-center">

                @foreach ($otherDocuments as $otherDocument)
                    <div class="border-t-2 border-slate-400 text-center pt-4">
                        <span class="text-slate-500 font-semibold">{{ $otherDocument->validDocument->notification->username }} joined Serv-is! Accept verification status?
                        </span>
                        <div class="flex gap-4 justify-center py-10 items-center">
                            <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 bnt-accept-notif" data-id="{{ $otherDocument->validDocument->notification->id }}" data-username="{{ $otherDocument->validDocument->notification->username }}" data-message="{{ $otherDocument->validDocument->notification->message }}" data-from-user-id="{{ $otherDocument->validDocument->notification->from_user_id }}" data-to-user-id="{{ $otherDocument->validDocument->notification->user_id }}" data-type="{{ $otherDocument->validDocument->notification->type }}">Confirm</button>

                            <button type="button" class="tbnt-reject-notif ext-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" data-id="{{ $otherDocument->validDocument->notification->id }}" data-username="{{ $otherDocument->validDocument->notification->username }}" data-message="{{ $otherDocument->validDocument->notification->message }}" data-from-user-id="{{ $otherDocument->validDocument->notification->from_user_id }}" data-to-user-id="{{ $otherDocument->validDocument->notification->user_id }}" data-type="{{ $otherDocument->validDocument->notification->type }}">Reject</button>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div class="mb-6 grid-cols-span-1 flex flex-col gap-2 justify-center items-center border-t-2 border-slate-400">
                                <span class="text-slate-500">NBI Clearance</span>
                                <img src="{{ $otherDocument->validDocument->nbi_clearance }}" alt="{{ $otherDocument->validDocument->nbi_clearance }}" class="valid-id-photo h-[200px] cursor-pointer transition duration-300 transform hover:scale-125" data-fancybox="valid-photos-gallery" data-caption="NBI Clearance">
                            </div>
                            <div class="mb-6 grid-cols-span-1 flex flex-col gap-2 justify-center items-center border-t-2 border-slate-400">
                                <span class="text-slate-500">Police Clearance</span>
                                <img src="{{ $otherDocument->validDocument->police_clearance }}" alt="{{ $otherDocument->validDocument->police_clearance }}" class="valid-id-photo h-[200px] cursor-pointer transition duration-300 transform hover:scale-125" data-fancybox="valid-photos-gallery" data-caption="Police Clearance">
                            </div>
                            <div class="mb-6 grid-cols-span-1 flex flex-col gap-2 justify-center items-center border-t-2 border-slate-400">
                                <span class="text-slate-500">Birth Certificate</span>
                                <img src="{{ $otherDocument->validDocument->birth_certificate }}" alt="{{ $otherDocument->validDocument->birth_certificate }}" class="valid-id-photo h-[200px] cursor-pointer transition duration-300 transform hover:scale-125" data-fancybox="valid-photos-gallery" data-caption="Birth Certificate">
                            </div>
                            <div class="mb-6 grid-cols-span-1 flex flex-col gap-2 justify-center items-center border-t-2 border-slate-400">
                                <span class="text-slate-500">Certificate of Employment</span>
                                <img src="{{ $otherDocument->validDocument->cert_of_employment }}" alt="{{ $otherDocument->validDocument->cert_of_employment }}" class="valid-id-photo h-[200px] cursor-pointer transition duration-300 transform hover:scale-125" data-fancybox="valid-photos-gallery" data-caption="Certificate of Employment">
                            </div>
                            <div class="mb-6 grid-cols-span-1 flex flex-col gap-2 justify-center items-center border-t-2 border-slate-400">
                                <span class="text-slate-500">Other valid ID</span>
                                <img src="{{ $otherDocument->validDocument->other_valid_id }}" alt="{{ $otherDocument->validDocument->other_valid_id }}" class="valid-id-photo h-[200px] cursor-pointer transition duration-300 transform hover:scale-125" data-fancybox="valid-photos-gallery" data-caption="Other valid ID">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    @include('sweetalert::alert')
</x-layout>
