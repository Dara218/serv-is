<x-layout>
    @include('partials.navbar')

        <div class="px-16 my-24">
            {{ Breadcrumbs::render('service-provider') }}

            <div class="mt-12 flex flex-col items-center text-center gap-8">
                <div class="w-full md:w-1/2 flex flex-col gap-6">
                    <p>Add your favorite service provider now.</p>

                    <div class="flex flex-col gap-2 items-start">
                        <span class="font-semibold">Recommendations</span>
                        <span class="w-full border-b-2 border-slate-700"></span>
                    </div>

                    @foreach ($employees as $employee)

                    {{-- @dd($employee) --}}

                    <div class="bg-slate-100 rounded-lg p-4 relative">

                        <span class="dots material-symbols-outlined absolute top-2 right-2 cursor-pointer ">
                            more_horiz
                        </span>

                        <a href="{{ route('home.showEmployeeProfile', ['user' => $employee->username]) }}" class="view-profile hidden bg-white rounded w-1/2 h-auto p-2 absolute top-8 right-2 cursor-pointer shadow-md hover:bg-gray-50">
                            <span>View Profile</span>
                        </a>

                        <div class="flex justify-between gap-2">
                            <img src="{{ $employee->userPhoto->profile_picture }}" alt="user id photo" class="h-1/2 w-16 rounded-full">
                            <div class="flex flex-col w-full items-start gap-2">
                                <span class="font-semibold">{{ ucwords($employee->fullname) }}</span>
                                <span class="flex items-center gap-2">
                                    <span class="material-symbols-outlined">
                                        mail
                                    </span>
                                    {{ $employee->email_address }}
                                </span>
                                <span class="flex items-center gap-2">
                                    <span class="material-symbols-outlined">
                                        location_on
                                    </span>
                                    {{ $employee->address }}
                                </span>
                                <span class="flex items-center gap-2">
                                    <span class="material-symbols-outlined">
                                        phone_in_talk
                                    </span>
                                    {{ $employee->contact_no }}
                                </span>
                            </div>
                        </div>

                        <div class="flex justify-evenly mt-6">
                            <button type="button" class="bg-slate-600 text-white rounded cursor-pointer py-2 px-4 hover:bg-slate-800">Add Provider</button>
                            <button type="button" class="bg-white rounded cursor-pointer py-2 px-4 hover:bg-gray-200">Not Interested</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        @include('sweetalert::alert')

</x-layout>
