
<footer class="bg-white rounded-lg shadow dark:bg-gray-900 mt-20 mx-4">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="flex justify-center md:justify-between">

            @if (Auth::check())
                <a href="{{
                    Auth::user()->user_type == 3 ? route('index') :
                    (Auth::user()->user_type == 2 ? route('indexAgent') :
                    (Auth::user()->user_type == 1 ? route('indexAdmin') : ''))}}"
                    class="flex items-center">

                    {{-- <img src="{{ asset('images/servis_logo.png') }}" class="block md:hidden h-8 mr-3" alt="Servis Logo"> --}}
                    <span class="hidden md:block self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Serv &#9679; is</span>
                </a>

                @else
                    <div class="flex gap-2">
                        <img src="{{ asset('images/servis_logo.png') }}" class="hidden md:block h-8 mr-3" alt="Servis Logo">
                        <span class="hidden md:block self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Serv &#9679; is</span>
                    </div>
            @endif

            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                <li>
                    <a href="#" class="mr-4 hover:underline md:mr-6 ">About</a>
                </li>
                <li>
                    <a href="#" class="mr-4 hover:underline md:mr-6">Privacy Policy</a>
                </li>
                <li>
                    <a href="#" class="mr-4 hover:underline md:mr-6 ">Licensing</a>
                </li>
                <li>
                    <a href="#" class="hover:underline">Contact</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ date('Y') }} <a href="https://flowbite.com/" class="hover:underline">Serv &#9679; is™</a>. All Rights Reserved.</span>
    </div>
</footer>

