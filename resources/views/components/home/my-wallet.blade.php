<x-layout>
    @include('partials.navbar')

        <div class="px-8 md:px-16 my-24">
            {{ Breadcrumbs::render('my-wallet') }}

            <div class="mt-12 flex flex-col items-center gap-8">
                <div class="w-full md:w-1/2 flex flex-col gap-4">
                    <div class="flex gap-2 flex-col">
                        <span class="font-semibold">Current Balance</span>

                        @include('partials.cash-in', ['checkInPrices' => $checkInPrices])

                        <div class="p-4 rounded flex justify-between items-center border border-slate-300">
                            <div class="flex flex-col">
                                <span class="font-semibold">P{{ $userBalance }}.00</span>
                                <small>Current Balance Wallet</small>
                            </div>
                            <div>
                                <span class="material-symbols-outlined">
                                    image
                                </span>
                            </div>
                        </div>
                    </div>

                    <span class="-mb-2">Wallet History</span>
                    <span class="w-full border-b-2 border-slate-700"></span>

                    @foreach ($walletHistories as $walletHistory)
                        <div class="p-4 rounded flex justify-between items-center border border-slate-300">
                            <div class="flex flex-col">
                                <span class="font-semibold">Cash-In</span>
                                <small>{{ $walletHistory->created_at->format('d M, Y') }}</small>
                            </div>
                            <div>
                                + {{ $walletHistory->amount }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        @include('sweetalert::alert')

</x-layout>
