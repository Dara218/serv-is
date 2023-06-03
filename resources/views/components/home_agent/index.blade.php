<x-layout>
    @include('partials.navbar')

        <div class="md:px-16 px-4 mt-16 md:mt-24 flex flex-col gap-8">
            <div class="flex flex-col gap-1">
                <span class="text-xl font-semibold">Hello, {{ Auth::user()->username }}</span>
                <span class="font-bold text-slate-600">Welcome back!</span>
            </div>

            <div class="flex flex-col gap-2">
                <span class="font-bold">Dashboard</span>
            </div>

             <x-home_agent.wallet-agent-transaction :balance="$balance" :services="$services"/>

            <div class="grid grid-cols-2">
                <div class="flex flex-col gap-2 justify-center items-center">
                    <span class="text-xl font-semibold">Schedule</span>
                    <div class="grid-cols-span-1" inline-datepicker data-date="{{ date('m/d/y') }}"></div>
                </div>
                <div class="grid-cols-span-1 overflow-hidden">
                    <div class="overflow-auto h-[400px] flex flex-col gap-5">
                        <span class="text-xl font-semibold mb-4">Reviews</span>
                        {{-- foreach here --}}
                        <x-home_agent.reviews-home/>
                    </div>
                </div>
            </div>

            <x-home_agent.agenda-home :agendas="$agendas"/>
        </div>

    @include('sweetalert::alert')
</x-layout>
