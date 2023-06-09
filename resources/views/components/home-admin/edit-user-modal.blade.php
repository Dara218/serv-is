
<div class="bg-white rounded-lg shadow-lg p-8 mx-auto w-full sm:w-11/12 xl:w-1/2">
    <div class="relative w-full max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $user->fullname }}
                </h3>
                <button type="button" id="close-admin-modal-{{ $user->username }}" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="grid-cols-span-1 flex flex-col gap-4">
                    <x-home-admin.user-modal-info :user="$user" userType="{{ $user->user_type }}" type="transaction" numberType="{{ $user->transaction->count() }}"/>

                    @if($user->user_type != 2)
                        <x-home-admin.user-modal-info :user="$user" userType="{{ $user->user_type }}" type="review" numberType="{{ $user->review->count() }}"/>
                        <x-home-admin.user-modal-info :user="$user" userType="{{ $user->user_type }}" type="agenda" numberType="{{ $user->agenda->count() }}"/>
                    @else
                        <div data-modal-target="service-${{ $user->username }}-modal" data-modal-toggle="service-${{ $user->username }}-modal"  class="p-4 h-auto grid-cols-span-1 border cursor-pointer border-slate-300 rounded-xl text-center flex justify-between hover:border-slate-600">
                            <div class="flex flex-col text-left ">
                                <span class="font-bold text-2xl text-slate-600">{{ ucwords($user->agentService->title) }}</span>
                                <span class="font-semibold text-xltext-slate-500">Service name</span>
                            </div>
                            <span class="material-symbols-outlined">
                                engineering
                            </span>
                        </div>
                        <x-home-admin.user-2nd-modal :user="$user" type="service" numberType="1" userType="{{ $user->user_type }}"/>
                    @endif
                </div>
                <div class="grid-cols-span-1">
                    <x-register.register-inputs fromAdmin="{{ true }}" useraddress="{{ $user->serviceAddress->address }}" fullname="{{ $user->fullname }}" username="{{ $user->username }}" email_address="{{ $user->email_address }}" contact_no="{{ $user->contact_no }}" region="{{ $user->region }}"/>
                </div>
            </div>
        </div>
    </div>
</div>

