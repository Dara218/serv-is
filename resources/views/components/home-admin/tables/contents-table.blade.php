@props(['type', 'column1', 'column2'])
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    @if ($type !== 'rewards')
                        {{ $column1 }}
                    @else
                        {{ $type }} title
                    @endif
                </th>
                @if ($type === 'rewards')
                    <th scope="col" class="px-6 py-3">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Points
                    </th>
                @endif
                <th scope="col" class="px-6 py-3">
                    {{ $column2 }}
                </th>
            </tr>
        </thead>

        <tbody class="{{ $type }}-table-body"></tbody>
    </table>

    <div class="isolate-nightmode my-5 text-center ">
        @include('partials.spinner')
    </div>
</div>
