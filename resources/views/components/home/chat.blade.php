<x-layout>
    @include('partials.navbar')

    <div class="px-8 md:px-16 my-24">
        {{ Breadcrumbs::render('agenda') }}

        <div class="mt-12 flex flex-col items-center gap-8">
            <div class="w-full md:w-1/2 flex flex-col gap-4">
                <div class="full">
                    <span>Recommendations</span>
                    <div class="w-full border border-slate-400 mt-2"></div>

                    <div class="flex flex-col gap-2">

                        {{-- @dd($agents) --}}
                        @foreach ($agents as $agent)
                            @if ($agent->adminRequest->is_accepted == true)
                                <div class="mt-4 relative">
                                    <span class="dots material-symbols-outlined absolute top-2 right-2 cursor-pointer ">
                                        more_horiz
                                    </span>

                                    <a href="{{ route('home.showEmployeeProfile', ['user' => $agent->username]) }}" class="view-profile hidden bg-white rounded w-1/2 h-auto p-2 absolute top-8 right-2 cursor-pointer shadow-md hover:bg-gray-50">
                                        <span>View Profile</span>
                                    </a>

                                    <div class="bg-slate-100 p-6 rounded-md">
                                        <div class="flex gap-2">
                                            <img src="{{ $agent->userPhoto->profile_picture }}" alt="user id photo" class="h-1/2 w-16 rounded-full">
                                            <span class="font-semibold">{{ ucwords($agent->fullname) }}</span>
                                        </div>
                                        <form action="{{ route('home.storeChat', ['user' => $agent->id]) }}" method="post" class="grid grid-cols-2 gap-2 mt-3">
                                            @csrf
                                            <button type="submit" class="col-span-1 bg-slate-600 text-white rounded cursor-pointer py-2 px-4 hover:bg-slate-800 shadow-md">Book Provider</button>
                                            <button type="button" class="col-span-1 bg-white rounded cursor-pointer py-2 px-4 hover:bg-gray-200 shadow-md">Close</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
