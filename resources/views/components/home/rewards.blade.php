<x-layout>
    @include('partials.navbar')
    <div class="px-8 md:px-16 my-24">
        {{ Breadcrumbs::render('awards') }}
        <div class="mt-12 flex flex-col items-start gap-2 md:gap-8">
            <div class="flex flex-col gap-1 md:gap-4 w-full">
                <span class="font-semibold text-xl">Your Balance</span>
                <div class="flex flex-col justify-center items-center gap-1 border border-slate-200 rounded-md py-6 mb-6">
                    <span class="font-semibold">0</span>
                    <span class="text-slate-600">Current Balance Points</span>
                </div>

                <span class="font-semibold">Redeem Rewards</span>
                <span class="border border-spacing-1 border-slate-600 w-full mb-4"></span>

                @foreach ($rewards as $reward)
                    <div class="flex flex-col gap-4">
                        <div class="grid grid-cols-3 border rounded border-slate-200 px-2 py-4 md:p-8 gap-3">
                            <div class="col-span-2 flex flex-col gap-2 w-full">
                                <span class="font-semibold text-xl">{{ $reward->title }}</span>
                                <small>{{ $reward->description }}</small>
                            </div>
                            <div class="flex justify-center items-center">
                                <button type="button" class="col-span-1 shadow-lg bg-[#2FA5D8] rounded md:py-3 px-1 md:px-6 text-white hover:bg-[#2b8cb6] w-auto md:w-56 text-xs md:text-md h-12">{{ $reward->points <= 0 ? 'Use Voucher' : $reward->points }}</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
</x-layout>
