<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Full Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Username
                </th>
                <th scope="col" class="px-6 py-3">
                    Contacy No.
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
        </thead>

        <tbody class="user-table-body"></tbody>

        @foreach ($users as $user)
            <div data-simplebar data-simplebar-auto-hide="false" id="manage-admin-btn-{{ $user->username }}" class="-translate-x-1/2 -translate-y-1/2 fixed h-[calc(100%-1rem)] hidden left-1/2 manage-admin-btn-dara218 max-h-full overflow-x-hidden overflow-y-auto top-1/2 transform w-full z-50">
                @include('components.home-admin.edit-user-modal', ['users' => $users])
            </div>
        @endforeach
    </table>
    
    <p class="no-user-search w-full font-semibold isolate-nightmode my-5 text-center hidden">No user found.</p>
    <div class="isolate-nightmode my-5 text-center ">
        @include('partials.spinner')
    </div>
</div>