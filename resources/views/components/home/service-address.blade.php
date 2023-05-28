<x-layout>
    @include('partials.navbar')

        <div class="px-8 md:px-16 my-24">
            {{ Breadcrumbs::render('service-address') }}

            <div class="mt-12 flex flex-col items-center gap-8">
                <div class="w-full md:w-1/2 flex flex-col gap-4 items-end">
                    <span class="material-symbols-outlined cursor-pointer add-address">
                        add
                    </span>

                    <div class="w-full mb-6 bg-slate-100 rounded-md py-6 px-4">

                        <div class="flex items-center justify-between mb-2">
                            <span class="font-semibold text-lg primary-address" data-id="{{ $primaryAddress->id }}">{{ $primaryAddress->address }}</span>
                            <label class="relative inline-flex items-center mr-5 cursor-pointer">

                                <form class="form-primary-address-checkbox">
                                    @csrf
                                    <input type="hidden" name="logged_user" id="logged-user" value="{{ Auth::user()->id }}">
                                </form>

                                <input type="checkbox" value="" class="sr-only peer" id="checkbox-primary" name="checkBox" {{ $primaryAddress->is_primary == 1 ? 'checked' : '' }}>

                                <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-slate-700 peer-focus:ring-4 peer-focus:ring-teal-300 dark:peer-focus:ring-teal-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-teal-600"></div>
                              </label>
                        </div>
                        <div>
                            <span>
                                <a href="#" class="mr-2 hover:text-slate-500 edit-primary-address">Edit</a>
                                <a href="#" class="hover:text-slate-500 delete-address" data-type="primary" data-id="{{ $primaryAddress->id }}">Delete</a>
                            </span>
                        </div>
                    </div>

                    @foreach ($secondaryAddresses as $secondaryAddress)

                        <div class="w-full mb-6 bg-slate-100 rounded-md py-6 px-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-semibold text-lg secondary-address">{{ $secondaryAddress->address }}</span>

                                <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                    <form class="form-secondary-address-checkbox">
                                        @csrf
                                    </form>

                                    <input type="checkbox" value="" class="sr-only peer checkbox-secondary" data-id="{{ $secondaryAddress->id }}">
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-slate-700 peer-focus:ring-4 peer-focus:ring-teal-300 dark:peer-focus:ring-teal-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-teal-600"></div>
                                </label>

                            </div>
                            <div>
                                <span>
                                    <a href="#" class="mr-2 hover:text-slate-500 edit-secondary-address" data-id="{{ $secondaryAddress->id }}" data-address="{{ $secondaryAddress->address }}">Edit</a>

                                    <a href="#" class="hover:text-slate-500 delete-address"
                                    data-type="secondary"
                                    data-id="{{ $secondaryAddress->id }}">
                                    Delete</a>
                                </span>
                            </div>
                        </div>
                    @endforeach

                    <form action="{{ route('home.storeAddress') }}" method="post" class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 flex flex-col gap-4 address-modal w-11/12 md:w-1/2 add-address-form bg-white border border-slate-200 rounded-xl shadow-lg" style="display:none;">
                        @csrf

                        <div class="flex justify-between bg-slate-500 text-white p-4 rounded-t-xl">
                            <span>Add Service Address</span>
                            <span class="material-symbols-outlined cursor-pointer close-address-modal">
                                close
                            </span>
                        </div>

                        <div class="px-4">
                            <div class="mb-4">
                                <input type="text" id="address" class="bg-gray-100 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border-none" placeholder="Enter address" name="address" value="{{ old('address') }}">
                                @error('address')
                                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full text-white bg-slate-500 hover:bg-slate-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-slate-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('sweetalert::alert')

</x-layout>
