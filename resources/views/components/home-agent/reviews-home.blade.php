@if ($reviews->count() == 0)
    <span class="font-semibold text-slate-400 flex justify-center items-center">No reviews.</span>

    @else
        <div class="user-review-el flex flex-col gap-6 mt-6">
            @foreach ($reviews as $review)
                <x-home.reviews :review="$review"/>
            @endforeach
        </div>
@endif
