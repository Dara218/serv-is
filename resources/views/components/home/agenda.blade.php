<x-layout>
    @include('partials.navbar')

    <div class="px-8 md:px-16 my-24">
        {{ Breadcrumbs::render('agenda') }}

        <div class="mt-12 flex flex-col items-center gap-8">
            <div class="w-full md:w-1/2 flex flex-col gap-4">
                <div class="w-full relative">
                    <button class="bg-slate-400 text-white p-2 rounded-md cursor-pointer flex items-center btn-add-agenda">
                        Add Agenda
                        <span class="material-symbols-outlined cursor-pointer">
                            add
                        </span>
                    </button>

                    <div class="border border-slate-300 mt-8"></div>

                    @if ($agendas->count() == 0)
                        <span class="text-slate-500">No recent agenda.</span>

                        @else
                            @foreach ($agendas as $agenda)
                                <div class="mt-4">
                                    <div class="bg-slate-100 rounded-lg p-4 relative">

                                        <div class="flex justify-between gap-2">
                                            <img src="{{ $agenda->userPhoto->profile_picture }}" alt="user id photo" class="h-1/2 w-16 rounded-full">
                                            <div class="flex flex-col w-full items-start gap-2">
                                                <span class="font-semibold">{{ ucwords($agenda->user->fullname) }}</span>
                                                <span class="flex items-center gap-2">
                                                    <span class="material-symbols-outlined">
                                                        mail
                                                    </span>
                                                    {{ $agenda->user->email_address }}
                                                </span>
                                                <span class="flex items-center gap-2">
                                                    <span>Message: </span>
                                                    {{ $agenda->message }}
                                                </span>
                                                <span class="flex items-center gap-2">
                                                    <span>Service: </span>
                                                    {{ $agenda->service }}
                                                </span>
                                                <span class="flex items-center gap-2">
                                                    <span>Budget: </span>
                                                    {{ $agenda->budget }}
                                                </span>
                                                <span class="flex items-center gap-2">
                                                    <span>Deadline: </span>
                                                    {{ $agenda->deadline }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="flex justify-evenly mt-6">
                                            <button type="button" class="bg-slate-600 text-white rounded cursor-pointer py-2 px-4 hover:bg-slate-800 btn-edit-agenda"
                                            data-id="{{ $agenda->id }}"
                                            data-message="{{ $agenda->message }}"
                                            data-service="{{ $agenda->service }}"
                                            data-budget="{{ $agenda->budget }}"
                                            data-deadline="{{ $agenda->deadline }}">Edit Agenda</button>

                                            <button type="button" class="bg-white rounded cursor-pointer py-2 px-4 hover:bg-gray-200 btn-delete-agenda" data-id="{{ $agenda->id }}">Delete Agenda</button>
                                        </div>
                                    </div>
                                </div>

                                @if ($errors->any())
                                    <script>
                                        $(document).ready(function() {
                                            $(`#edit-agenda-modal-${$agenda->id}`).slideDown()
                                        });
                                    </script>
                                @endif

                                <form action="{{route('home.updateAgenda', ['agenda' => $agenda->id])}}" method="post" id="edit-agenda-modal-{{ $agenda->id }}" class="z-10 w-11/12 md:w-1/2 fixed left-1/2 top-1/2 trasform -translate-x-1/2 -translate-y-1/2 bg-slate-200 rounded shadow-md p-4 mt-12 " style="display:none;">

                                    @csrf

                                    @method('put')

                                    <div class="w-full text-end">
                                        <span class="material-symbols-outlined cursor-pointer btn-close-agenda">
                                            close
                                        </span>
                                    </div>

                                    <div class="mb-6">
                                        <textarea rows="4" class="edit-agenda-message block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your message here..." name="message"></textarea>
                                        @error('message')
                                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                                        @enderror
                                    </div>

                                    <div class="mb-6">
                                        <label for="service" class="block mb-2 text-sm font-medium text-slate-500 dark:text-white">Service</label>

                                        <select class="edit-agenda-service bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="service" required>
                                            @foreach ($services as $service)
                                                <option value="" class="edit-agenda-service-option">{{ ucwords($service->type) }}</option>
                                            @endforeach
                                        </select>

                                        @error('service')
                                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                                        @enderror
                                    </div>

                                    <div class="mb-6">
                                        <label for="budget" class="block mb-2 text-sm font-medium text-slate-500 dark:text-white">Budget</label>
                                        <input class="edit-agenda-budget block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="number" name="budget" value="">
                                        @error('budget')
                                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                                        @enderror
                                    </div>

                                    <div class="mb-6">
                                        <label for="deadline" class="block mb-2 text-sm font-medium text-slate-500 dark:text-white">Deadline</label>

                                        {{-- <div class="relative">
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                            </div>
                                            <input datepicker datepicker-autohide type="text" class="edit-agenda-deadline bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date" name="deadline" value="">
                                        </div> --}}
                                        
                                        <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input type="date" name="deadline" id="date" class="edit-agenda-deadline focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md">
                                        </div>
                
                                        @error('deadline')
                                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                                        @enderror
                                    </div>

                                    <div class="flex">
                                        <button type="submit" class="w-1/2 ml-auto text-white bg-slate-500 hover:bg-slate-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-slate-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 update-agenda">Update</button>
                                    </div>
                                </form>
                            @endforeach
                    @endif

                    <form action="{{route('home.storeAgenda')}}" method="post" class="w-11/12 md:w-1/2 fixed left-1/2 top-1/2 trasform -translate-x-1/2 -translate-y-1/2 bg-slate-200 rounded shadow-md p-4 form-agenda-modal mt-12 " style="display:none;">

                        <div class="w-full text-end">
                            <span class="material-symbols-outlined cursor-pointer btn-close-agenda">
                                close
                            </span>
                        </div>

                        @csrf

                        <div class="mb-6">
                            <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your message here..." name="message">{{ old('message') }}</textarea>
                            @error('message')
                                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="service" class="block mb-2 text-sm font-medium text-slate-500 dark:text-white">Service</label>

                            <select id="service" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="service" value="{{ old('service') }}" required>
                                @foreach ($services as $service)
                                    <option value="{{ $service->type }}" {{ old('service') ===  $service->type  ? 'selected' : ''}}>{{ ucwords($service->type) }}</option>
                                @endforeach
                            </select>

                            @error('service')
                                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="budget" class="block mb-2 text-sm font-medium text-slate-500 dark:text-white">Budget</label>
                            <input class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="budget" type="number" name="budget" value="{{ old(('budget')) }}">
                            @error('budget')
                                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="deadline" class="block mb-2 text-sm font-medium text-slate-500 dark:text-white">Deadline</label>

                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input datepicker datepicker-autohide type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date" name="deadline" value="{{ old(('deadline')) }}">
                            </div>

                            @error('deadline')
                                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>

                        <div class="flex">
                            <button type="submit" class="w-1/2 ml-auto text-white bg-slate-500 hover:bg-slate-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-slate-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('sweetalert::alert')
</x-layout>
