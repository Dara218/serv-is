@if (Auth::check())
    <div class="chat-modal md:grid grid-cols-3 z-10 bg-slate-100 w-11/12 md:w-1/2 h-96 fixed bottom-12 right-4 rounded-md overflow-hidden shadow flex flex-col gap-2" style="display:none;">
        <div class="flex flex-col gap-1 col-span-1 bg-slate-200 p-3 shadow-md w-full overflow-hidden h-32 md:h-full">
            <span class="font-semibold">Chats</span>
            <div class="overflow-x-auto overflow-y-hidden md:overflow-x-hidden">
                <ol data-simplebar data-simplebar-auto-hide="false" class="flex md:flex-col gap-2 md:h-80" id="agent-list">
                    @foreach ($agents as $agent)
                        @foreach ( Auth::user()->user_type == 1 ? $agent->chat : $agent->user->chat as $chat)
                            <li class="flex items-center gap-1 p-1 receiver-el cursor-pointer shadow-md" data-chat-id="{{ $chat->id }}" data-sender="{{ $chat->sender_id }}" data-receiver="{{ $chat->receiver_id }}" {{ Auth::user()->user_type == 1 ? 'data-id=' .$agent->id  : 'data-id=' .$agent->user->id }} data-username="{{ Auth::user()->user_type == 1 ? $agent->username : (Auth::user()->user_type == 3 ? $agent->user->username : (Auth::user()->user_type == 2 ? $agent->availedBy->username : '')) }}">
                                <img
                                    src="https://images.pexels.com/photos/7841717/pexels-photo-7841717.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                                    alt="user id photo"
                                    class="h-8 w-8 receiver-chat-head-click"
                                    style="border-radius: 50%"
                                    data-chat-id="{{ $chat->id }}"
                                    data-sender="{{ $chat->sender_id }}"
                                    data-receiver="{{ $chat->receiver_id }}" {{ Auth::user()->user_type == 1 ? 'data-id=' .$agent->id  : 'data-id=' .$agent->user->id }}
                                    data-username="{{ Auth::user()->user_type == 1 ? $agent->username : (Auth::user()->user_type == 3 ? $agent->user->username : (Auth::user()->user_type == 2 ? $agent->availedBy->username : '')) }}"
                                >
                                <span class="md:block hidden receiver-chat-heads">
                                    {{
                                    Auth::user()->user_type == 3
                                        ? $agent->user->username
                                        : (Auth::user()->user_type == 2
                                        ? $agent->availedBy->username
                                        : (Auth::user()->user_type == 1
                                            ? $agent->username
                                            : '')
                                        )
                                    }}
                                </span>
                            </li>
                        @endforeach
                    @endforeach

                    <form class="form-chat-head">
                        @csrf
                        <input type="hidden" name="user_id" class="user-id-hidden">
                        <input type="hidden" name="username" id="username-hidden" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="chatId" class="chat-id">
                        <input type="hidden" name="receiver_hidden" id="receiver-chat-head">
                        <button type="submit" class="hidden">submit</button>
                    </form>
                </ol>
            </div>
        </div>

        <div data-simplebar data-simplebar-auto-hide="false" class="chat-container col-span-2 pb-12 overflow-y-auto overflow-x-hidden relative h-5/6 md:h-full p-2">
            <span class="font-semibold mb-2 sticky top-0 bg-slate-100 w-full shadow-md flex justify-center items-center current-chat-name py-2" style="display: none;">Name of current chat</span>
            <span class="font-semibold mb-2 sticky top-0 w-full flex justify-center items-center gap-1 cursor-pointer load-more" style="display: none;">
                <span>Load More</span>
                <span class="material-symbols-outlined">
                    arrow_upward
                </span>
            </span>
            <div class="mt-6">
                <div class="flex flex-col">
                    <div class="flex flex-col message-container">
                        <span class="username-el"></span>
                        <span class="w-auto col-span-4 message-el text-gray-500">Choose a conversation.
                        </span>
                        {{-- <small class="font-semibold text-slate-400">3/21/2000, 2 mins ago</small> --}}
                    </div>
                </div>
            </div>

            <form class="w-full mt-6 sticky -bottom-10 form-chat">
                @csrf
                <div class="flex">
                    <input type="hidden" name="username" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="receiver_hidden" id="receiver-hidden">

                    <input type="text" name="message" id="message" class="input-message w-full border border-slate-300 rounded" style="display: none;">
                    <button type="submit" class="input-message" style="display: none;">
                        <span class="material-symbols-outlined text-3xl">
                            send
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif
