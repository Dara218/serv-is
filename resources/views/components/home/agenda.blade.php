<x-layout>
    @include('partials.navbar')

    <div class="px-8 md:px-16 my-24">
        {{ Breadcrumbs::render('agenda') }}

        <div class="mt-12 flex flex-col items-center gap-8">
            <div class="w-full md:w-1/2 flex flex-col gap-4 items-end">
                <form action="#" method="post" class="w-full">

                    @csrf

                    <div>
                        <textarea id="message" rows="4" class="mb-6 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your message here..." name="message"></textarea>
                        @error('message')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="service" class="block mb-2 text-sm font-medium text-slate-500 dark:text-white">Service</label>
                        <select id="service" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="service" required>
                            <option class="loading">Loading...</option>
                        </select>
                        @error('service')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="budget" class="block mb-2 text-sm font-medium text-slate-500 dark:text-white">Budget</label>
                        <select id="budget" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="budget" required>
                            <option class="loading">Loading...</option>
                        </select>
                        @error('budget')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="deadline" class="block mb-2 text-sm font-medium text-slate-500 dark:text-white">Deadline</label>
                        <select id="deadline" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="deadline" required>
                            <option class="loading">Loading...</option>
                        </select>
                        @error('deadline')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>

                    <div class="flex">
                        <button type="submit" class="w-1/2 ml-auto text-white bg-slate-500 hover:bg-slate-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-slate-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Post</button>
                    </div>

                </form>

            </div>

        </div>
    </div>




</x-layout>
