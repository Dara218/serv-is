<x-layout>
    @include('partials.navbar')

        <div class="md:px-16 px-4 mt-16 md:mt-24 flex flex-col gap-8">
            <div class="flex flex-col gap-1">
                <div class="flex items-center gap-2">
                    <span class="text-xl font-semibold">Hello, {{ Auth::user()->username }}</span>
                    @if ($accepted)
                        <div class="text-red-500 text-sm flex items-center">
                            <span>Not verified</span>
                            <span class="material-symbols-outlined cursor-default" data-popover-target="popover-right" data-popover-placement="right">
                            error
                            </span>

                            <div data-popover id="popover-right" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                <div class="px-3 py-2">
                                    <p>Admin has not verified your account. You wont be able to get services until you get verified. You'll receive a notification later on.</p>
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                        </div>

                        @else
                            <div class="text-green-500 text-sm">
                                <span>Verified</span>
                            </div>
                    @endif
                </div>
                <span class="font-bold text-slate-600">Welcome back!</span>
            </div>

            <div class="flex flex-col gap-2">
                <span class="font-bold">Dashboard</span>
            </div>

            <x-home-agent.wallet-agent-transaction
            :balance="$balance"
            :services="$services"
            :totalservices="$totalservices"
            :finishedservice="$finishedservice"
            />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="grid-cols-span-1 flex flex-col gap-2 justify-center items-center">
                    <span class="text-xl font-semibold">Schedule</span>
                    <div inline-datepicker data-date="{{ date('m/d/y') }}"></div>
                </div>
                <div class="grid-cols-span-1 overflow-hidden border border-slate-300 rounded-md p-4">
                    <div class="overflow-auto h-[400px] flex flex-col gap-5">
                        <span class="text-xl font-semibold mb-4">Reviews</span>
                        <x-home-agent.reviews-home :reviews="$reviews"/>
                    </div>
                </div>
            </div>

            @if (! $accepted)
                <x-home-agent.agenda-home :agendas="$agendas"/>
            @endif
        </div>

    @include('sweetalert::alert')
</x-layout>
