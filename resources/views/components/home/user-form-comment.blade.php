<div class="flex gap-1 w-full">
    <img src="{{ $authuser->userPhoto->profile_picture }}" alt="customer profile picture" class="h-1/2 w-16 rounded-full">
    <form action="{{ route('storeUserComment') }}" method="post" class="form-comment w-full flex flex-col gap-2 text-start" data-agent-id="{{ $user->id }}" data-agent-service-id="{{ $service->id }}">
        @csrf
        <div class="rating">
            <input type="radio" name="star_rating" value="1" class="star-rating mask mask-star-2 bg-orange-400" />
            <input type="radio" name="star_rating" value="2" class="star-rating mask mask-star-2 bg-orange-400" checked />
            <input type="radio" name="star_rating" value="3" class="star-rating mask mask-star-2 bg-orange-400" />
            <input type="radio" name="star_rating" value="4" class="star-rating mask mask-star-2 bg-orange-400" />
            <input type="radio" name="star_rating" value="5" class="star-rating mask mask-star-2 bg-orange-400" />
          </div>
        <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
            <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                <label for="comment" class="sr-only">Your comment</label>
                <textarea id="comment" name="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="Write a comment..." required></textarea>
                <input type="hidden" name="agent_id" value="{{ $user->id }}">
                <input type="hidden" name="agent_service_id" value="{{ $service->id }}">
            </div>
            <div class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
                <button type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-slate-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                    Post comment
                </button>
            </div>
        </div>
    </form>
</div>
