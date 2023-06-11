<x-layout>
    @include('partials.navbar')

        <div class="px-8 md:px-16 my-24">
            {{ Breadcrumbs::render('transaction-history') }}

            <div class="mt-12 flex flex-col items-center gap-8">
                <div class="w-full flex flex-col gap-4">

                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-6">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Service
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Amount Paid
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Date of transaction
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($transactions->count() == 0)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td class="px-6 py-4">
                                                <span>No recent transaction.</span>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($transactions as $transaction)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                <td class="px-6 py-4">
                                                    {{ $transaction->service }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    P {{ $transaction->amount_paid }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $transaction->created_at->format('F j, Y g:i A') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $transactions->links('pagination::tailwind') }}
                        </div>
                </div>
            </div>
        </div>

        @include('sweetalert::alert')

</x-layout>
