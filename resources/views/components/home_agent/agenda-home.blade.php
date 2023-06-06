<span class="text-xl font-semibold mb-1">Agendas</span>
<div class="grid grid-cols-2 md:grid-cols-3 gap-3">
    @foreach ($agendas as $agenda)
        <div class="grid-cols-span-1">
            <div class="bg-slate-100 rounded-lg p-4 relative">
                <div class="flex justify-between gap-2">

                    <img src="{{ (empty($agenda->userPhoto) ? asset('images/servis_logo.png') : $agenda->userPhoto->profile_picture) }}" alt="user id photo" class="h-1/2 w-16 rounded-full">

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

                {{-- @dd($request) --}}

                <div class="flex justify-evenly mt-6">
                    <button type="button" class="bg-slate-600 text-white rounded cursor-pointer py-2 px-4 hover:bg-slate-800 btn-negotiate-agenda"
                    data-id="{{ $agenda->id }}"
                    data-message="{{ $agenda->message }}"
                    data-service="{{ $agenda->service }}"
                    data-budget="{{ $agenda->budget }}"
                    data-username="{{ $agenda->user->username }}"
                    data-userid="{{ $agenda->user->id }}">Make Offer</button>

                    <button type="button" class="bg-white rounded cursor-pointer py-2 px-4 hover:bg-gray-200 btn-task-me-agenda" data-id="{{ $agenda->id }}"
                    data-message="{{ $agenda->message }}"
                    data-service="{{ $agenda->service }}"
                    data-budget="{{ $agenda->budget }}"
                    data-username="{{ $agenda->user->username }}"
                    data-userid="{{ $agenda->user->id }}">Task Me</button>
                </div>
            </div>
        </div>
    @endforeach
</div>
