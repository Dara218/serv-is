<x-layout>
    @include('partials.navbar')

        <div class="px-16 my-24">
            {{ Breadcrumbs::render('edit-profile') }}

            <div class="mt-12 flex flex-col items-center gap-8">

                <div id="toast-warning" class="unsaved-changes-el z-50 fixed flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-white divide-x divide-gray-200 rounded-lg shadow top-20 right-5 dark:text-gray-400 dark:divide-gray-700 space-x dark:bg-gray-800" role="alert" style="display: none;">
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-orange-500 bg-orange-100 rounded-lg dark:bg-orange-700 dark:text-orange-200">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Warning icon</span>
                    </div>
                    <div class="ml-3 text-sm font-normal">Theres unsaved changes</div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-warning" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>

                <form action="{{ route('home.editProfile') }}" method="post" class="w-full md:w-1/2" enctype="multipart/form-data">
                    @csrf

                    @method('put')

                    {{-- @dd($user) --}}

                    @if ($users->count() == 0)
                        <div class="flex justify-center items-center gap-2 mb-6">
                            <small>Upload a profile picture.</small>

                            <label for="file-input">
                                <span class="material-symbols-outlined">
                                    edit
                                </span>
                            </label>
                            <input id="file-input" type="file" class="hidden profile_picture" name="profile_picture">
                        </div>

                        @else
                            <div class="flex justify-center items-center mb-6">
                                @foreach ($users as $user)
                                    <img src="{{ $user->profile_picture  }}" alt="User profile picture" class="user-profile-el rounded-full border-2 border-slate-500 w-32 h-auto">
                                @endforeach
                                <label for="file-input">
                                    <span class="material-symbols-outlined">
                                        edit
                                    </span>
                                </label>
                                <input id="file-input" type="file" class="hidden profile_picture" name="profile_picture">
                            </div>

                    @endif

                    @foreach ($useraddresses as $useraddress)
                    {{-- @dd($useraddress) --}}
                        <x-register.register-inputs :useraddress="$useraddress"/>
                    @endforeach


                    <button type="submit" class="w-full text-white bg-slate-500 hover:bg-slate-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-slate-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Update Profile</button>
                </form>
            </div>
        </div>

        @include('sweetalert::alert')

</x-layout>
