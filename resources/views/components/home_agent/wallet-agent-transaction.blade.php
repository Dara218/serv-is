<div class="grid grid-cols-2 gap-4">
    <a href="{{ route('showWallet') }}" class="p-10 h-auto grid-cols-span-1 border border-slate-300 rounded-xl text-center flex justify-between hover:border-slate-600">
        <div class="flex flex-col text-left ">
            <span class="font-bold text-2xl text-slate-600">P {{ $balance }}</span>
            <span class="font-semibold text-xltext-slate-500">Employee's Wallet</span>
        </div>
        <div class="flex flex-col justify-center">
            <span class="material-symbols-outlined">
                account_balance_wallet
            </span>
        </div>
    </a>

    <a href="{{ route('showTransactionHistory') }}" class="p-10 h-auto grid-cols-span-1 border border-slate-300 rounded-xl text-center flex justify-between hover:border-slate-600"">
        <div class="flex flex-col text-left">
            <span class="font-bold text-2xl text-slate-600">{{ $services }}</span>
            <span class="font-semibold text-xltext-slate-500">Total service</span>
        </div>
        <div class="flex flex-col justify-center">
            <span class="material-symbols-outlined">
                receipt_long
            </span>
        </div>
    </a>

    <a href="#" class="p-10 h-auto grid-cols-span-1 border border-slate-300 rounded-xl text-center flex justify-between hover:border-slate-600">
        <div class="flex flex-col text-left ">
            <span class="font-bold text-2xl text-slate-600">15</span>
            <span class="font-semibold text-xltext-slate-500">Upcoming service</span>
        </div>
        <div class="flex flex-col justify-center">
            <span class="material-symbols-outlined">
                account_balance_wallet
            </span>
        </div>
    </a>

    <a href="#" class="p-10 h-auto grid-cols-span-1 border border-slate-300 rounded-xl text-center flex justify-between hover:border-slate-600">
        <div class="flex flex-col text-left">
            <span class="font-bold text-2xl text-slate-600">5</span>
            <span class="font-semibold text-xltext-slate-500">Today's service</span>
        </div>
        <div class="flex flex-col justify-center">
            <span class="material-symbols-outlined">
                receipt_long
            </span>
        </div>
    </a>
</div>