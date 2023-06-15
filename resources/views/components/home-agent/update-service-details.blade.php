<x-layout>
    @include('partials.navbar')

        <div class="md:px-16 px-4 mt-16 md:mt-24">
            {{ Breadcrumbs::render('update-service-details') }}
            <div class="flex flex-col items-center justify-center gap-8 h-[80vh]">
                <form action="{{ route('updateServiceDetails', ['agentservices' => $agentservices->id ]) }}" method="post" class="w-full md:w-1/2">
                    @csrf
                    @method('put')

                    <div class="mb-6">
                        <input type="text" id="service_title" class="bg-gray-100 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border-none" placeholder="Enter new service title" name="service_title" value="{{ old('service_title') }}">
                        @error('service_title')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="service" class="block mb-2 text-sm font-medium text-slate-500 dark:text-white">Select your type of service</label>
                        <select id="service" class="service-options bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="service" required>

                            @foreach ($services as $service)
                                <option selected value="{{ $service->type }}">{{ $service->type }}</option>
                            @endforeach

                        </select>
                    </div>

                    <button type="submit" class="w-full text-white bg-slate-500 hover:bg-slate-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-slate-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Update Service Details</button>
                </form>
            </div>
        </div>

    @include('sweetalert::alert')
</x-layout>
