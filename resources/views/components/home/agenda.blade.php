<x-layout>
    @include('partials.navbar')

    <div class="px-8 md:px-16 my-24">
        {{ Breadcrumbs::render('agenda') }}

        <div class="mt-12 flex flex-col items-center gap-8">
            <div class="w-full md:w-1/2 flex flex-col gap-4 items-end">
                <form action="{{route('home.storeAgenda')}}" method="post" class="w-full">

                    @csrf

                    <div class="mb-6">
                        <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your message here..." name="message">{{ old('message') }}</textarea>
                        @error('message')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="service" class="block mb-2 text-sm font-medium text-slate-500 dark:text-white">Service</label>

                        <select id="service" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="service" value="{{ old('service') }}" required>
                            @foreach ($services as $service)
                                <option value="{{ $service->type }}" {{ old('service') ===  $service->type  ? 'selected' : ''}}>{{ ucwords($service->type) }}</option>
                            @endforeach
                        </select>

                        @error('service')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="budget" class="block mb-2 text-sm font-medium text-slate-500 dark:text-white">Budget</label>
                        <input class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="budget" type="number" name="budget" value="{{ old(('budget')) }}">
                        @error('budget')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="deadline" class="block mb-2 text-sm font-medium text-slate-500 dark:text-white">Deadline</label>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input datepicker datepicker-autohide type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date" name="deadline" value="{{ old(('deadline')) }}">
                        </div>

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
