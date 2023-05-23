<x-layout>
    @include('partials.navbar')

    <div class="px-8 md:px-16 my-24">
        {{ Breadcrumbs::render('pricing-plan', $clientToBeAvail) }}

        <form action="#" method="post" class="mt-12 flex flex-col md:flex-row justify-center gap-8">
            <label for="basic" class="w-full md:w-1/2 flex flex-col gap-4 items-center border border-slate-200 rounded cursor-pointer">
                <div class="flex flex-col gap-3 w-full p-4">
                    <div class="grid md:grid-cols-6 grid-cols-3 gap-2">
                        <div class="flex items-center gap-2 md:col-span-4 col-span-2">
                            <input type="radio" name="plan" id="basic">
                            <div class="flex flex-col">
                                <span class="font-semibold">Basic</span>
                                <small>Service through chat included only</small>
                            </div>
                        </div>
                        <span class="bg-[#2FA5D8] rounded-md text-white md:col-span-2 col-span-1 w-full text-center leading-10">P 100</span>
                    </div>
                    <div class="bg-slate-100 p-2 rounded-md">
                        <ol>
                            <li class="flex items-center gap-2 mb-2">
                                <span class="material-symbols-outlined">
                                check_circle
                                </span>
                                <span>Chat your provider for consultation</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined">
                                    cancel
                                </span>
                                <span>Can only avail the service for 1 day</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </label>
            <label for="advance" class="w-full md:w-1/2 flex flex-col gap-4 items-center border border-slate-200 rounded cursor-pointer">
                <div class="flex flex-col gap-3 w-full p-4">
                    <div class="grid md:grid-cols-6 grid-cols-3 gap-2">
                        <div class="flex items-center gap-2 md:col-span-4 col-span-2">
                            <input type="radio" name="plan" id="advance">
                            <div class="flex flex-col">
                                <span class="font-semibold">Advance <small class="text-green-500">Save 50%</small></span>
                                <small>Service fee included</small>
                            </div>
                        </div>
                        <span class="bg-[#2FA5D8] rounded-md text-white md:col-span-2 col-span-1 w-full text-center leading-10">P 1500</span>
                    </div>
                    <div class="bg-slate-100 p-2 rounded-md">
                        <ol>
                            <li class="flex items-center gap-2 mb-2">
                                <span class="material-symbols-outlined">
                                check_circle
                                </span>
                                <span>Provider can personally help you</span>
                            </li>
                            <li class="flex items-center gap-2 mb-2">
                                <span class="material-symbols-outlined">
                                check_circle
                                </span>
                                <span>Avail the service for 3 days</span>
                            </li>
                            <li class="flex items-center gap-2 mb-2">
                                <span class="material-symbols-outlined">
                                check_circle
                                </span>
                                <span>Be prioritized anytime, anywhere</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </label>
        </form>
    </div>




</x-layout>
