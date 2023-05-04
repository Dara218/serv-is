<div>
    <span class="text-2xl font-bold text-slate-400">Categories</span>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
        @foreach ($services as $service)
            <div class="p-4 h-auto grid-cols-span-1 border border-slate-300 rounded-xl text-center">
                <span>{{ ucwords($service->type) }}</span>
            </div>
        @endforeach
    </div>
</div>
