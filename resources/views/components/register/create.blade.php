<x-layout>
    <div class="flex flex-col items-center justify-center min-h-screen my-10">
        <div class="md:w-1/2 w-11/12 flex flex-col justify-center items-center">
            <img src="{{ asset('images/servis logo uncropted.png') }}" alt="serv-is logo" style="height: auto; width: 120px;">

            <p class="text-center my-8 font-medium text-slate-800">Create your account for better experience</p>

            <form action="#" method="post" class="w-full">
                @csrf
                <div class="mb-6">
                    <input type="text" id="fullname" class="bg-gray-100 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border-none" placeholder="Full name">
                </div>
                <div class="mb-6">
                    <input type="text" id="username" class="bg-gray-100 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border-none" placeholder="Username">
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="email" name="floating_email" id="floating_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email address</label>
                </div>
                <div class="mb-6">
                    <input type="number" id="contact-no" class="bg-gray-100 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border-none" placeholder="Contact number">
                </div>
                <div class="mb-6">
                    <input type="text" id="password" class="bg-gray-100 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border-none" placeholder="Password">
                </div>
                <div class="mb-6">
                    <input type="text" id="address" class="bg-gray-100 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border-none" placeholder="address">
                </div>

                <a href="#" class="text-slate-500 font-bold italic">Forgot Password?</a>

                <button type="submit" class="w-full my-8 text-white bg-slate-500 hover:bg-slate-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-slate-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Login</button>

                <p class="text-center font-medium text-slate-800">Already have an account? <a href="/" class="text-slate-500 font-bold italic underline">Sign In</a></p>
            </form>
        </div>
    </div>
</x-layout>
