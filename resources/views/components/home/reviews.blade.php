<div class="flex justify-between px-4">
    <div class="flex gap-2">
        @if (empty($review->user->userPhoto))
            <img src="{{ asset('images/servis_logo.png') }}" alt="" class="h-[50px]">

            @else
            <img src="{{ $review->user->userPhoto->profile_picture }}" alt="" class="h-[50px] rounded-full">
        @endif

        <div class="flex flex-col gap-2 mx-2">
            <div class="flex flex-col gap-1 text-left">
                <span>{{ $review->user->fullname }}</span>

                <div class="flex">
                    @for ($i = 0; $i < $review->level; $i++)
                        <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>First star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    @endfor

                    @for ($i = $review->level; $i < 5; $i++)
                        <svg aria-hidden="true" class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>First star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    @endfor
                </div>
            </div>

            <p>{{ $review->message }}</p>
        </div>
    </div>

    <span>{{ $review->created_at->format('d M') }}</span>
</div>
