<x-layout>
    @include('partials.navbar')
        <div class="md:px-16 px-4 mt-16 md:mt-24 flex flex-col gap-8">
            <div class="flex justify-center px-4">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Full Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Subject
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Message
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Action</span>
                                </th>
                            </tr>
                        </thead>
                
                        <tbody class="user-table-contact-us"></tbody>
                
                    </table>
                    <p class="no-conncern-search w-full font-semibold isolate-nightmode my-5 text-center hidden">No concerns found.</p>
                    <div class="isolate-nightmode my-5 text-center">
                        @include('partials.spinner')
                    </div>
                </div>
            </div>
        </div>
    @include('sweetalert::alert')
</x-layout>
