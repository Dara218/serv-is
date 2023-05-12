<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

        @vite('resources/css/app.css')

        <title>Serv &#9679; is</title>

    </head>

    <body>
        {{ $slot }}

        <div class="btn-chat-open fixed bottom-4 right-4 flex items-center gap-1 cursor-pointer">
            <span>Chat</span>
            <span class="material-symbols-outlined">
                chat
            </span>
        </div>

        <div class="chat-modal md:grid grid-cols-3 bg-slate-100 w-11/12 md:w-1/2 h-96 fixed bottom-12 right-4 rounded shadow flex flex-col gap-2" style="display:none;">
            <div class="flex flex-col gap-1 col-span-1 bg-slate-200 p-3">
                <span class="font-semibold">Chats</span>
                <ol class="flex md:flex-col gap-2">
                    {{-- Foreach here --}}
                    <li class="flex gap-1"><img src="https://images.pexels.com/photos/7841717/pexels-photo-7841717.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="user id photo" class="h-8 w-8 mb-2" style="border-radius: 50%"><span class="md:block hidden">Sydney</span></li>
                    <li class="flex gap-1"><img src="https://images.pexels.com/photos/7841717/pexels-photo-7841717.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="user id photo" class="h-8 w-8 mb-2" style="border-radius: 50%"><span class="md:block hidden">Ralph</span></li>
                </ol>
            </div>

            <div class="col-span-2 md:py-3 overflow-y-auto overflow-x-hidden relative h-5/6 md:h-full">
                <span class="font-semibold mb-2">Name of current chat</span>
                <div class="mt-6">
                    <div class="flex flex-col">
                        <div class="flex flex-col gap-2">
                            {{-- <img src="https://images.pexels.com/photos/7841717/pexels-photo-7841717.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="user id photo" class="h-10 w-64 mb-2" style="border-radius: 50%;"> --}}
                            <span class="w-auto col-span-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestiae quidem ipsam qui earum, aspernatur et laboriosam nisi ut natus perspiciatis minus sint nostrum exercitationem labore maiores est animi magni quasi?
                            </span>
                            <small class="font-semibold text-slate-400">3/21/2000, 2 mins ago</small>
                        </div>

                    </div>
                </div>

                <form action="#" method="post" class="w-full mt-6 absolute bottom-1 ">
                    @csrf
                    <div class="flex">
                        <input type="text" name="chat" id="chat" class="w-full border border-slate-300 rounded">
                        <button type="submit">
                            <span class="material-symbols-outlined text-3xl">
                                send
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{ asset('js/servis.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

    </body>
</html>
