<x-layout>
    @include('partials.navbar')

        <div class="md:px-16 px-4 mt-16 md:mt-24 flex flex-col gap-8">
            <div class="flex flex-col gap-1">
                <div class="flex items-center gap-2">
                    <span class="text-xl font-semibold">Hello, {{ Auth::user()->username }}</span>
                </div>
                <span class="font-bold text-slate-600">Welcome back!</span>
            </div>

            <div class="flex flex-col gap-2">
                <span class="font-bold">Dashboard</span>
            </div>

            <x-home-admin.users-editable-contents/>

            <x-home-admin.search-admin :users="$users"/>

            <x-home-admin.users-table :users="$users"/>
        </div>

    @include('sweetalert::alert')
</x-layout>
