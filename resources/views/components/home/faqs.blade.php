<x-layout>
    @include('partials.navbar')

        <div class="px-12 md:px-8 md:px-16 my-24">
            {{ Breadcrumbs::render('faqs') }}

            <div class="mt-12 flex flex-col items-center gap-8 w-full">
                <div class="flex flex-col items-center gap-2 w-full">
                    <span class="text-slate-500 font-semibold text-center">How Can We Help You?</span>
                    <div class="flex flex-col items-center gap-4 w-full">
                        <small class="text-slate-500 text-center">Reach out by submitting a form with us.</small>
                        <small class="text-slate-500 text-center">Leave a message and we’ll respond as soon as we can.</small>

                        <div class="bg-slate-500 h-16 w-full"></div>
                        <button type="button" class="btn-contact-us bg-[#F6F7F9] w-1/2 h-16 -mt-10 rounded-lg shadow-xl font-semibold text-slate-500 cursor-pointer hover:bg-[#eeeeee]">Contact Us</button>

                        <form action="{{ route('storeContactMessage') }}" method="post" class="contact-us-modal border border-slate-400 rounded-md shadow-md absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white overflow-hidden hidden w-11/12 md:w-2/5">
                            @csrf

                            {{-- TODO: STAY ON MIDDLE KAHIT SCROLL YUNG CONTACT US MODAL --}}

                            <div class="flex justify-between items-center bg-slate-500 w-full mb-6 h-10 p-4 text-white">
                                <span class="font-semibold">Contact Us</span>
                                <span class="material-symbols-outlined cursor-pointer close-contact-us-modal">
                                    close
                                </span>
                            </div>

                            <div class="px-4">
                                <div class="mb-6">
                                    <div class="relative">
                                        <input type="email" id="outlined_success" aria-describedby="outlined_success_help" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-slate-300 appearance-none dark:text-white dark:border-slate-300 dark:focus:border-slate-500 focus:outline-none focus:ring-0 focus:border-slate-300 peer" placeholder="Email Address" name="email_address" value="{{ Auth::user()->email_address }}"/>
                                        <label for="outlined_success" class="absolute text-sm text-green-600 dark:text-green-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email Address</label>
                                    </div>
                                    @error('email_address')
                                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <input type="text" id="subject" class="bg-gray-100 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border-none" placeholder="Subject" name="subject" value="{{ old('subject') }}">
                                    @error('subject')
                                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <textarea id="message" rows="4" class="mb-6 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your message here..." name="message"></textarea>
                                    @error('message')
                                        <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                                    @enderror
                                </div>

                                <button type="submit" class="w-full mb-6 text-white bg-slate-500 hover:bg-slate-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 mr-2 dark:bg-slate-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Send</button>
                            </div>
                        </form>

                        <div class="border border-slate-500 w-full my-8"></div>

                        @foreach ($faqs as $faq)
                            <div class="flex flex-col gap-4">
                                <span class="font-bold text-2xl text-slate-500">{{ $faq->ques_title }}</span>

                                <div class="border border-slate rounded-md p-5 flex flex-col gap-3">
                                    <span class="font-semibold text-slate-600">{{ $faq->answer }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @include('sweetalert::alert')
</x-layout>
