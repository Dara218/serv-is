
<nav class="bg-slate-300 dark:bg-gray-900 fixed w-full z-20 top-0 left-0 border-b border-gray-200 dark:border-gray-600">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto md:p-2 p4">
        <a href="{{
            Auth::user()->user_type == 3 ? route('home.index') :
            (Auth::user()->user_type == 2 ? route('home.indexAgent') :
            (Auth::user()->user_type == 1 ? route('home.indexAdmin') : ''))}}"
            class="flex items-center">

            <img src="{{ asset('images/servis_logo.png') }}" class="h-8 mr-3" alt="Flowbite Logo">
            <span class="hidden md:block self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Serv &#9679; is</span>
        </a>
        <div class="flex md:order-2">
            <div>
                @include('partials.notification')

                <input type="hidden" id="current-user-id" value="{{ Auth::user()->id }}">

                <div id="dropdownNavbar" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                        <li>
                        <a href="{{ route('home.showEditProfile') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit Profile</a>
                    </li>
                    <li>
                        <a href="{{ route('home.showWallet') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">My Wallet</a>
                    </li>
                    <li>
                        <a href="{{ route('home.showServiceProvider') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Service Provider</a>
                    </li>
                    <li>
                        <a href="{{ route('home.showServiceAddress') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Service Address</a>
                    </li>
                    <li>
                        <a href="{{route('home.showRewards')}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Rewards & Discounts</a>
                    </li>
                    <li>
                        <a href="{{ route('home.showTransactionHistory') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Transaction History</a>
                    </li>
                    <li>
                        <a href="{{ route('home.showFaqs') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Customer Support</a>
                    </li>
                    <li>
                        <a href="{{ route('home.showAgenda') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Agenda</a>
                    </li>
                    <li>
                        <a href="{{ route('home.showChat') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Chat</a>
                    </li>
                    </ul>
                    <form class="py-1 w-full" action="{{ route('session.logout') }}" method="post">
                        @csrf
                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">Sign out</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</nav>
