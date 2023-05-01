<x-layout>
    <div class="flex flex-col items-center justify-center min-h-screen my-10">
        <div class="md:w-1/2 w-11/12 flex flex-col justify-center items-center">
            <img src="{{ asset('images/servis logo uncropted.png') }}" alt="serv-is logo" style="height: auto; width: 120px;">

            <p class="text-center my-8 font-medium text-slate-800">Create your account for better experience</p>

            <form action="{{ route('register.store') }}" method="post" class="register w-full" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label for="user_type" class="block mb-2 text-sm font-medium text-slate-500 dark:text-white">Login as</label>
                    <select id="user_type" class="user_type-options bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="user_type" required>
                        <option value="" selected disabled class="user_type-options">Customer/Client</option>
                        <option value="Customer" {{ old('user_type') === 'Customer' ? 'selected' : '' }}>Customer</option>
                        <option value="Client" {{ old('user_type') === 'Client' ? 'selected' : '' }}>Client</option>
                    </select>
                </div>

                <div class="mb-6">
                    <input type="text" id="fullname" class="bg-gray-100 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border-none" placeholder="Full name" name="fullname" value="{{ old('fullname') }}">
                    @error('fullname')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                    @enderror
                </div>
                <div class="mb-6">
                    <input type="text" id="username" class="bg-gray-100 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border-none" placeholder="Username" name="username" value="{{ old('username') }}">
                     @error('username')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                    @enderror
                </div>
                <div class="mb-6">
                    <div class="relative">
                        <input type="email" id="outlined_success" aria-describedby="outlined_success_help" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-slate-300 appearance-none dark:text-white dark:border-slate-300 dark:focus:border-slate-500 focus:outline-none focus:ring-0 focus:border-slate-300 peer" placeholder="Email Address" name="email_address" value="{{ old('email_address') }}"/>
                        <label for="outlined_success" class="absolute text-sm text-green-600 dark:text-green-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email Address</label>
                    </div>
                    @error('email')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                    @enderror
                </div>
                <div class="mb-6">
                    <input type="number" id="contact-no" class="bg-gray-100 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border-none" placeholder="Contact number" name="contact_no" value="{{ old('contact_no') }}">
                    @error('contact_no')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                    @enderror
                </div>
                <div class="mb-6">
                    <input type="password" id="password" class="bg-gray-100 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border-none" placeholder="Password" name="password">
                    @error('password')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                    @enderror
                </div>
                <div class="mb-6">
                    <input type="text" id="address" class="bg-gray-100 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border-none" placeholder="Address" name="address" value="{{ old('address') }}">
                    @error('address')
                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="years" class="block mb-2 text-sm font-medium text-slate-500 dark:text-white">Select your region</label>
                    <select id="region" class="region-options bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="region" required>
                        <option class="loading">Loading...</option>
                    </select>
                </div>

                <div class="id-imgs">
                    <div class="mb-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="photo_id">Photo ID</label>
                        <input class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="photo_id" type="file" name="photo_id">

                        @error('photo_id')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="nbi_clearance">NBI Clearance</label>
                        <input class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="nbi_clearance" type="file" name="nbi_clearance">

                        @error('nbi_clearance')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="police_clearance">Police Clearance</label>
                        <input class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="police_clearance" type="file" name="police_clearance">

                        @error('police_clearance')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="birth_certificate">Birth Certificate</label>
                        <input class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="birth_certificate" type="file" name="birth_certificate">

                        @error('birth_certificate')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="cert_of_employment">Certificate of Employment</label>
                        <input class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="cert_of_employment" type="file" name="cert_of_employment">

                        @error('cert_of_employment')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="other_valid_id">Other Valid ID</label>
                        <input class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="other_valid_id relative" type="file" name="other_valid_id">

                        @error('other_valid_id')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="w-full my-8 text-white bg-slate-500 hover:bg-slate-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-slate-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Register</button>

                <p class="text-center font-medium text-slate-800">Already have an account? <a href="/" class="text-slate-500 font-bold italic underline">Sign In</a></p>
            </form>
        </div>
    </div>
</x-layout>
