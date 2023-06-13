<x-layout>

    @include('partials.navbar')

        <div class="px-8 md:px-16 my-24">
            @foreach ($users as $user)
            {{ Breadcrumbs::render('employee-profile', $user) }}

            <div class="mt-12 flex flex-col items-center text-center gap-8">
                <div class="w-full md:w-1/2 flex flex-col gap-6">

                    {{-- @dd($service) --}}
                    <form method="post" action="{{ route('storeChat', ['user' => $user->id]) }}" class="flex flex-col items-center gap-2 rounded-md bg-slate-100 p-8">
                        @csrf
                        <div class="flex flex-col gap-6 items-start">

                            <div class="flex gap-4">
                                <img src="{{ $user->userPhoto->profile_picture }}" alt="user id photo" class="h-1/2 w-16 rounded-full">
                                <div class="flex flex-col gap-2">
                                    <span class="font-semibold">{{ ucwords($user->fullname) }}</span>
                                    <span class="text-slate-700">{{ ucwords($service->service->type) }} Expert</span>
                                    <div class="flex items-center">
                                        <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>First star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Second star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Third star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Fourth star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-300 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Fifth star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col items-start gap-2">
                                <span class="flex items-center gap-2 text-slate-700">
                                    <span class="material-symbols-outlined">
                                        mail
                                    </span>
                                    {{ $user->email_address }}
                                </span>
                                <span class="flex items-center gap-2 text-slate-700">
                                    <span class="material-symbols-outlined">
                                        location_on
                                    </span>
                                    {{ $user->serviceAddress->address }}
                                </span>
                                <span class="flex items-center gap-2 text-slate-700">
                                    <span class="material-symbols-outlined">
                                        phone_in_talk
                                    </span>
                                    {{ $user->contact_no }}
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-6 bg-slate-500 text-white rounded cursor-pointer py-2 px-4 hover:bg-slate-800">Book Provider</button>
                    </form>
                </div>

                {{-- Todo:: add migrations yung review tables and add expertise table, check figma baka may ma add pakong table.--}}

                <div class="flex flex-col gap-4 items-start">
                    <span class="font-semibold text-xl">Customer Review</span>

                    <div class="flex gap-4 relative">

                        @if ($service->review->count() == 0)
                            <span class="items-center justify-center text-slate-500 font-semibold">No user review</span>
                            
                            @else
                                @foreach ($service->review as $review)  
                                    <span class="absolute top-0 right-0 text-slate-700">27 Mar</span>
                                    <img src="http://127.0.0.1:8000/storage/uploads/1683171440_1x1.jpg" alt="customer profile picture" class="h-1/2 w-16 rounded-full">

                                    <div>
                                        <div class="flex flex-col gap-1 mb-4">
                                            <span class="text-left">{{ $review->user->username }}</span>

                                            <div class="flex">
                                                @for ($i = 0; $i < $review->level; $i++)
                                                <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>First star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            @endfor

                                            @for ($i = $review->level; $i < 5; $i++)
                                                <svg aria-hidden="true" class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>First star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            @endfor
                                            </div>
                                        </div>

                                        <p>The experience was great! Thank you for helping me to paint my apartment!</p>
                                    </div>
                                @endforeach
                        @endif
                    </div>
                </div>
        </div>
        @endforeach
    </div>

    @include('sweetalert::alert')
</x-layout>
