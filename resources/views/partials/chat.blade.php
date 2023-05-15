<div class="chat-modal md:grid grid-cols-3 bg-slate-100 w-11/12 md:w-1/2 h-96 fixed bottom-12 right-4 rounded shadow flex flex-col gap-2" style="display:none;">
    <div class="flex flex-col gap-1 col-span-1 bg-slate-200 p-3">
        <span class="font-semibold">Chats</span>
        <ol class="flex md:flex-col gap-2">

            @foreach ($agents as $agent)

                <li class="flex gap-1 receiver-el cursor-pointer" data-id="{{ $agent->id }}"><img src="https://images.pexels.com/photos/7841717/pexels-photo-7841717.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="user id photo" class="h-8 w-8 mb-2" style="border-radius: 50%"><span class="md:block hidden receiver-chat-heads">{{ $agent->username }}</span></li>

                <form class="form-chat-head">
                    @csrf
                    <input type="text" name="user_id" class="user-id-hidden">
                    {{-- <input type="hidden" name="username" id="username-hidden"> --}}
                    <input type="hidden" name="receiver_hidden" id="receiver-chat-head">
                    <button type="submit" class="hidden">submit</button>
                </form>
            @endforeach
        </ol>
    </div>

    <div class="chat-container col-span-2 md:py-3 pb-12 overflow-y-auto overflow-x-hidden relative h-5/6 md:h-full">
        <span class="font-semibold mb-2 sticky top-0 bg-slate-100 w-full current-chat-name">Name of current chat</span>
        <div class="mt-6">
            <div class="flex flex-col">
                <div class="flex flex-col message-container">
                    <span class="username-el"></span>
                    <span class="w-auto col-span-4 message-el">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestiae quidem ipsam qui earum, aspernatur et laboriosam nisi ut natus perspiciatis minus sint nostrum exercitationem labore maiores est animi magni quasi?
                    </span>
                    <small class="font-semibold text-slate-400">3/21/2000, 2 mins ago</small>
                </div>

            </div>
        </div>

        <form class="w-full mt-6 sticky bottom-0 form-chat">
            @csrf
            <div class="flex">
                <input type="hidden" name="username">
                <input type="hidden" name="receiver_hidden" id="receiver-hidden">

                <input type="text" name="message" id="message" class="w-full border border-slate-300 rounded">
                <button type="submit">
                    <span class="material-symbols-outlined text-3xl">
                        send
                    </span>
                </button>
            </div>
        </form>
    </div>

</div>
