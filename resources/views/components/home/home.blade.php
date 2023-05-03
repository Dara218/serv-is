<x-layout>
    @include('partials.navbar')

    {{-- <div class="flex flex-col items-center justify-center min-h-screen my-10"> --}}
        {{-- <div class="md:w-1/2 w-11/12 flex flex-col justify-center items-center"> --}}
        <div class="px-16 mt-20">
            <x-home.categories :services="$services"/>

            <x-home.wallet-transaction/>
        </div>

        {{-- </div> --}}
    {{-- </div> --}}
</x-layout>
