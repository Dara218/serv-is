@props(['title', 'src', 'fancybox'])

<div class="mb-6 grid-cols-span-1 flex flex-col gap-2 justify-center items-center border-t-2 border-slate-400">
    <span class="text-slate-500">{{ $title }}</span>
    @if (Str::endsWith($src, ['.pdf', '.PDF']))
        <object data="{{ $src }}" class="flex items-center justify-center flex-col gap-2 valid-id-photo h-[200px]" data-fancybox="{{ $fancybox }}" data-caption="{{ $title }}">
            <p>Oops! Your browser doesn't support PDFs!</p>
            <a href="{{ $src }}" type="button" class=" text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 cursor-default">Download instead</a>
        </object>

        @elseif (Str::endsWith($src, ['.jpg', '.jpeg', '.png', '.JPG', '.JPEG', '.PNG']))
            <img src="{{ $src }}" class="cursor-pointer valid-id-photo h-[200px]" data-fancybox="{{ $fancybox }}" data-caption="{{ $title }}">
        @elseif (Str::endsWith($src , ['.doc', '.docx', '.DOC', '.DOCX']))
            <iframe src="https://docs.google.com/gview?url=http://remote.url.tld/{{ $src }}&embedded=true" class="valid-id-photo h-[200px]" data-fancybox="{{ $fancybox }}" data-caption="{{ $title }}"></iframe>
        @else
            Invalid file format
    @endif
</div>


