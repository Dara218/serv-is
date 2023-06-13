<div class="flex gap-1">

        <span id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="notification-bell relative material-symbols-outlined focus:ring-4 focus:outline-none font-medium rounded-lg px-4 py-2.5 text-center inline-flex items-center cursor-pointer" type="button">
            notifications
            @if ($notificationCount >= 1)
                <span class="notif-count absolute top-0 right-1 bg-red-600 text-white p-1 rounded-full" style="font-size:0.5rem;">{{ $notificationCount }}</span>
            @endif

            <span class="notif-count-hidden hidden absolute top-0 right-1 bg-red-600 text-white p-1 rounded-full" style="font-size:0.5rem;">{{ $notificationCount }}</span>
        </span>

    <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="flex items-center justify-between w-full py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">{{ ucwords(Auth::user()->fullname) }}<svg class="w-5 h-5 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>

    <!-- Dropdown menu -->
    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-1/2 md:w-80 dark:bg-gray-700 h-[50vh] overflow-y-auto">
        <ul class="flex flex-col gap-2 w-full p-2 text-sm text-gray-700 dark:text-gray-200 notification-parent h-auto" aria-labelledby="dropdownDefaultButton">

            @foreach ($notifications as $notification)
            {{-- <span>{{ $notification->from_user_id }}</span> --}}

                @if ($notification->status == 1 && ($notification->type == 1 || $notification->type == 4))
                    <li class="notif-item flex justify-between py-4 px-2 {{ $notification->is_unread == true ? 'bg-slate-100' : 'bg-slate-200' }}">
                        <div class="flex gap-2">
                            <div class="flex flex-col gap-1 justify-center w-full">
                                <span class="font-semibold text-green-500">Accepted</span>
                                <span class="font-bold">{{ $notification->username }}</span>
                                <span>{{ $notification->message }}</span>
                            </div>
                        </div>
                    </li>

                @elseif($notification->status == 0 && ($notification->type == 1 || $notification->type == 4))
                    <li class="notif-item flex flex-col py-4 px-2 bg-slate-200 relative">

                        @if ($notification->type == 4)
                            <a href="{{ route('showConfirmAgent') }}" class="text-slate-500 absolute top-2 right-3">See details</a>
                        @endif

                        <div class="flex gap-2">
                            <div class="flex flex-col gap-1 justify-center w-full">
                                <span class="font-bold">{{ $notification->username }}</span>
                                <span>{{ $notification->message }}</span>
                            </div>
                        </div>
                        <div class="flex gap-4 justify-center">
                            <a href="#" data-id="{{ $notification->id }}" data-username="{{ $notification->username }}" data-message="{{ $notification->message }}" data-from-user-id="{{ $notification->from_user_id }}" data-to-user-id="{{ $notification->user_id }}" data-type="{{ $notification->type }}" class="material-symbols-outlined cursor-pointer bnt-accept-notif">
                                check_circle
                            </a>
                            <a href="#" data-id="{{ $notification->id }}" data-username="{{ $notification->username }}" data-message="{{ $notification->message }}" data-from-user-id="{{ $notification->from_user_id }}" data-to-user-id="{{ $notification->user_id }}" data-type="{{ $notification->type }}" class="material-symbols-outlined cursor-pointer bnt-reject-notif">
                                cancel
                            </a>
                        </div>
                    </li>

                @elseif ($notification->status == 2 && ($notification->type == 1 || $notification->type == 4))
                    <li class="notif-item flex justify-between py-4 px-2 {{ $notification->is_unread == true ? 'bg-slate-100' : 'bg-slate-200' }}">
                        <div class="flex gap-2">
                            <div class="flex flex-col gap-1 justify-center w-full">
                                <span class="font-semibold text-red-400">Rejected</span>
                                <span class="font-bold">{{ $notification->username }}</span>
                                <span>{{ $notification->message }}</span>
                            </div>
                        </div>
                    </li>

                @elseif (($notification->status == 3 || $notification->status == 1) && ($notification->type == 2 || $notification->type == 3))
                    <li class="notif-item flex justify-between py-4 px-2 {{ $notification->is_unread == true ? 'bg-slate-100' : 'bg-slate-200' }}">
                        <div class="flex gap-2">
                            <div class="flex flex-col gap-1 justify-center w-full">
                                <span class="font-bold">{{ $notification->username }}</span>
                                <span>{{ $notification->message }}</span>
                            </div>
                        </div>
                    </li>
                @endif

            @endforeach

            <li class="flex justify-between bg-slate-100 p-1">
                <div class="flex gap-2">
                    <img style="width:60px; heigth:auto;" src="{{ $admin->profile_picture }}" alt="admin photo" class="hidden md:block rounded">
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
