<x-layout>
    @include('partials.navbar')

        <div class="md:px-16 px-4 mt-16 md:mt-24 flex flex-col gap-8">
            <x-home.categories/>

            <x-home.wallet-transaction :balance="$balance" :transaction="$transaction"/>

            <div class="flex justify-center mt-12">
                <x-home.services-search :services="$services"/>
            </div>

            {{--
                TODO:
                - Add only services from verified agents
                - Add reject on admin for new agents, when rejected, new li appears on agent name request again
            --}}
            <x-home.services/>
        </div>

    @include('sweetalert::alert')
</x-layout>
