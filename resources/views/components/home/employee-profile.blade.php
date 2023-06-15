<x-layout>
    @include('partials.navbar')
        <div class="px-8 md:px-16 my-24">
            @foreach ($users as $user)
                {{ Breadcrumbs::render('employee-profile', $user) }}
                <div class="mt-12 flex flex-col items-center text-center gap-8">
                    <div class="w-full md:w-1/2 flex flex-col gap-6">
                        <form method="post" action="{{ route('storeChat', ['user' => $user->id]) }}" class="test-form flex flex-col items-center gap-2 rounded-md bg-slate-100 p-8" data-agent-service-id="{{ $service->id }}">
                            @csrf
                            <div class="flex flex-col gap-6 items-start">

                                <div class="flex gap-4 w-full">
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

                    <div class="flex flex-col w-full md:w-1/2 gap-4 items-start">
                        <x-home.user-form-comment :authuser="$authuser" :user="$user" :service="$service"/>

                        <div class="flex flex-col w-full gap-4 relative">
                            <span class="font-semibold text-xl">Customer Review</span>
                            @if ($service->review->count() == 0)
                                <span class="items-center justify-center text-slate-500 font-semibold">No user review</span>
                                @else
                                    @foreach ($service->review as $review)
                                        <x-home.reviews :review="$review"/>
                                    @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @include('sweetalert::alert')
</x-layout>
