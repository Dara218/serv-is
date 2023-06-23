@props(['type', 'numberType', 'userType', 'user'])

<div data-modal-target="{{ $type }}-${{ $user->username }}-modal" data-modal-toggle="{{ $type }}-${{ $user->username }}-modal" class="p-4 h-auto grid-cols-span-1 border cursor-pointer border-slate-300 rounded-xl text-center flex justify-between hover:border-slate-600">
    <div class="flex flex-col text-left ">
        <span class="font-bold text-2xl text-slate-600">{{ ucwords($type) }}</span>
        <span class="font-semibold text-xltext-slate-500">No. of {{ $type }}: {{ $numberType }}</span>
    </div>
    <div class="flex flex-col justify-center">
        @if ($type == 'review')
            <span class="material-symbols-outlined">
                star
            </span>
        @elseif ($type === 'transaction')
            <span class="material-symbols-outlined">
                account_balance_wallet
            </span>
        @elseif ($type === 'agenda')
            <span class="material-symbols-outlined">
                view_agenda
            </span>
        @endif
    </div>
</div>

<x-home-admin.user-2nd-modal :user="$user" type="{{ $type }}" numberType="{{ $numberType }}" userType="{{ $userType }}"/>
