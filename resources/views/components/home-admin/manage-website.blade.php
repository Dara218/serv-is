<x-layout>
    @include('partials.navbar')
        <div class="md:px-16 px-4 mt-16 md:mt-24 flex flex-col gap-8">
            {{ Breadcrumbs::render('manage-website') }}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="services-table-parent">
                    <div class="see-all-service-btn-parent"></div>
                    <x-home-admin.tables.contents-table type="service" column1="Type" column2="Action"/>
                </div>

                {{-- <div class="categories-table-parent">
                    <div class="see-all-category-btn-parent"></div>
                    <x-home-admin.tables.contents-table type="categories" column1="Type" column2="Action"/>
                </div> --}}

                <div class="pricing-plan-table-parent">
                    <div class="see-all-pricing-plan-btn-parent"></div>
                    <x-home-admin.tables.contents-table type="pricing-plan" column1="Type" column2="Action"/>
                </div>
            </div>

            <div class="rewards-table-parent">
                <div class="see-all-rewards-btn-parent"></div>
                <x-home-admin.tables.contents-table type="rewards" column1="Type" column2="Action"/>
            </div>
        </div>
    @include('sweetalert::alert')
</x-layout>
