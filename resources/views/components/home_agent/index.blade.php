<x-layout>
    @include('partials.navbar')

    {{-- <div class="flex flex-col items-center justify-center min-h-screen my-10"> --}}
        {{-- <div class="md:w-1/2 w-11/12 flex flex-col justify-center items-center"> --}}
        <div class="md:px-16 px-4 mt-16 md:mt-24 flex flex-col gap-8">
            <div class="flex flex-col gap-1">
                <span class="text-xl font-semibold">Hello, {{ Auth::user()->username }}</span>
                <span class="font-bold text-slate-600">Welcome back!</span>
            </div>

            <div class="flex flex-col gap-2">
                <span class="font-bold">Dashboard</span>
            </div>

             {{-- <x-home_agent.wallet-agent-transaction :balance="$balance" :transaction="$transaction"/> --}}

           {{-- <div class="flex justify-center mt-12">
                <x-home.services-search/>
            </div>

            <x-home.services :services="$services"/> --}}
        </div>

        {{-- </div> --}}
    {{-- </div> --}}

    @include('sweetalert::alert')
</x-layout>
