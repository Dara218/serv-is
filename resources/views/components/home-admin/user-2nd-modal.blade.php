@props(['type', 'numberType', 'userType', 'user'])

<div id="{{ $type }}-${{ $user->username }}-modal" tabindex="-1" class="z-50 fixed top-0 left-0 right-0 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-2xl dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                    {{ ucwords($type) }}
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="{{ $type }}-${{ $user->username }}-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="p-6 flex flex-col gap-2 space-y-6">

                @if ($type === 'transaction')
                    @foreach ($user->transaction as $transaction)
                        <div class="grid grid-cols-3 gap-4 mb-4 border border-b p-4">
                            <div>
                                <div class="grid-cols-span-1 text-slate-500 font-semibold">Service</div>
                                <div>{{ $transaction->service }}</div>
                            </div>
                            <div>
                                <div class="grid-cols-span-1 text-slate-500 font-semibold">Amount Paid</div>
                                <div>{{ $transaction->amount_paid }}</div>
                            </div>
                            <div>
                                <div class="grid-cols-span-1 text-slate-500 font-semibold">Transaction Date</div>
                                <div>{{ $transaction->created_at->format('d M, Y') }}</div>
                            </div>
                        </div>
                    @endforeach

                @elseif ($type === 'review')
                    @foreach ($user->review as $review)
                        <div class="grid grid-cols-3 gap-4 mb-4 border border-b p-4">
                            <div>
                                <div class="grid-cols-span-1 text-slate-500 font-semibold">Agent</div>
                                <div>{{ $review->employee_id }}</div>
                            </div>
                            <div>
                                <div class="grid-cols-span-1 text-slate-500 font-semibold">Message</div>
                                <div>{{ $review->message }}</div>
                            </div>
                            <div>
                                <div class="grid-cols-span-1 text-slate-500 font-semibold">Date</div>
                                <div>{{ $review->created_at->format('d M, Y') }}</div>
                            </div>
                        </div>
                    @endforeach

                @elseif ($type === 'agenda')
                    @foreach ($user->agenda as $agenda)
                        <div class="grid grid-cols-3 gap-4 mb-4 border border-b p-4">
                            <div>
                                <div class="grid-cols-span-1 text-slate-500 font-semibold">Message</div>
                                <div>{{ $agenda->message }}</div>
                            </div>
                            <div>
                                <div class="grid-cols-span-1 text-slate-500 font-semibold">Service</div>
                                <div>{{ $agenda->service }}</div>
                            </div>
                            <div>
                                <div class="grid-cols-span-1 text-slate-500 font-semibold">Deadline</div>
                                <div>{{ $agenda->deadline }}</div>
                            </div>
                        </div>
                    @endforeach

                @elseif ($type === 'service')
                    <div class="grid grid-cols-3 gap-4 mb-4 border border-b p-4">
                        <div>
                            <div class="grid-cols-span-1 text-slate-500 font-semibold">Service Title</div>
                            <div>{{ $user->agentService->title }}</div>
                        </div>
                        <div>
                            <div class="grid-cols-span-1 text-slate-500 font-semibold">Pending</div>
                            <div>{{ $user->agentService->is_pending ?  'Yes' : 'No' }}</div>
                        </div>
                        <div>
                            <div class="grid-cols-span-1 text-slate-500 font-semibold">Has Pending Changes</div>
                            <div>{{ $user->agentService->is_pending_changes ? 'Yes' : 'No' }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

