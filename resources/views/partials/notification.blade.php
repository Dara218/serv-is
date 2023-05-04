<div class="flex gap-1">
    <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="flex items-center justify-between w-full py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">{{ ucwords(Auth::user()->fullname) }}<svg class="w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>

    <span id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="material-symbols-outlined focus:ring-4 focus:outline-none font-medium rounded-lg px-4 py-2.5 text-center inline-flex items-center cursor-pointer" type="button">
        notifications
    </span>

    <!-- Dropdown menu -->
    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-1/2 md:w-80 dark:bg-gray-700">
        <ul class="w-full p-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
            <li class="flex justify-between bg-slate-100 p-1">

                <div class="flex gap-2">
                    <img style="width:50px; heigth:auto;" src="{{ $admin->photo_id }}" alt="admin photo" class="hidden md:block rounded">
                    <div class="flex flex-col gap-1 justify-center w-full">
                        <span class="font-bold">Welcome!</span>
                        <span>Welcome to Serv-Is, {{ Auth::user()->username }}</span>
                    </div>
                </div>

                <small>{{ Auth::user()->created_at->diffForHumans() }}</small>

            </li>
        </ul>
    </div>
</div>
