<x-layout>
    @include('partials.navbar')

        <div class="px-16 my-24">
            {{ Breadcrumbs::render('edit-profile') }}

            <div class="mt-12 flex flex-col items-center gap-8">
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
                            <input id="file-input" type="file" class="hidden" name="profile_picture">
                        </div>

                        @else
                            <div class="flex justify-center items-center mb-6">
                                @foreach ($users as $user)
                                    <img src="{{ $user->profile_picture  }}" alt="User profile picture" class="rounded-full border-2 border-slate-500 w-32 h-auto">
                                @endforeach
                                <label for="file-input">
                                    <span class="material-symbols-outlined">
                                        edit
                                    </span>
                                </label>
                                <input id="file-input" type="file" class="hidden" name="profile_picture">
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
