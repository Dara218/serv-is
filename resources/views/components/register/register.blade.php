<x-layout>
    <div class="flex flex-col items-center justify-center min-h-screen my-10">
        <div class="md:w-1/2 w-11/12 flex flex-col justify-center items-center">
            <img src="{{ asset('images/servis logo uncropted.png') }}" alt="serv-is logo" style="height: auto; width: 120px;">

            <p class="text-center my-8 font-medium text-slate-800">Create your account for better experience</p>

            <form action="{{ route('register.store') }}" method="post" class="register w-full" enctype="multipart/form-data">
                @csrf

                <x-inputs.user_type/>

                <x-register.register-inputs/>

                <div class="id-imgs">
                    <div class="mb-5">
                        <label for="service" class="block mb-2 text-sm font-medium text-slate-500 dark:text-white">Select your type of service</label>
                        <select id="service" class="service-options bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="service" required>

                            @foreach ($services as $service)
                                <option selected value="{{ $service->type }}">{{ $service->type }}</option>
                            @endforeach

                        </select>
                    </div>
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
