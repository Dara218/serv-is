<x-layout>
    <div class="flex flex-col items-center justify-center min-h-screen">
        <div class="md:w-1/2 w-11/12 flex flex-col justify-center items-center">
            <img src="{{ asset('images/servis_logo.png') }}" class="block h-8 mr-3" alt="Servis Logo" style="height: auto; width: 120px;">

            <p class="text-center my-8 font-medium text-slate-800">Welcome Back, We’ve got You Serviced Booked.</p>

            <form action="{{ route('session.store') }}" method="post" class="form-login w-full">
                @csrf

                {{-- <x-inputs.user_type/> --}}

                <div class="mb-6">
                    <input type="text" id="username" class="bg-gray-100 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border-none" placeholder="Username" name="username" value="{{ old('username') }}">
                    @error('username')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                    @enderror
                </div>
                <div class="mb-6">
                    <input type="password" id="password" class="bg-gray-100 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border-none" placeholder="Password" name="password">
                    @error('password')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                    @enderror
                </div>

                <a href="#" class="text-slate-500 font-bold italic">Forgot Password?</a>

                <button type="submit" class="w-full my-8 text-white bg-slate-500 hover:bg-slate-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-slate-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Login</button>

                <p class="text-center font-medium text-slate-800">Don't have an account? <a href="{{ route('register.create') }}" class="text-slate-500 font-bold italic underline">Sign Up</a></p>
            </form>
        </div>
    </div>

    @include('sweetalert::alert');

</x-layout>
