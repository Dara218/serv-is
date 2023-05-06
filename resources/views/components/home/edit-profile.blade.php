<x-layout>
    @include('partials.navbar')

        <div class="px-16 my-24">
            {{ Breadcrumbs::render('edit-profile') }}

            <div class="mt-12 flex flex-col items-center gap-8">
                <form action="{{ route('home.editProfile') }}" method="post" class="w-full md:w-1/2">
                    @csrf

                    @method('put')
                    <x-register.register-inputs/>

                    <button type="submit" class="w-full text-white bg-slate-500 hover:bg-slate-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-slate-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Update Profile</button>
                </form>
            </div>
        </div>

        @include('sweetalert::alert')

</x-layout>
