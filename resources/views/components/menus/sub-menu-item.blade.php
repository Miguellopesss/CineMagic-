@if($selectable)
    @if($selected)
        <a class="px-3 py-4 border-b-2 border-b-indigo-400 dark:border-b-indigo-500
                text-sm font-medium leading-5 inline-flex h-auto
                text-neutral-900 dark:text-neutral-100
                hover:text-neutral-700 dark:hover:text-neutral-300
                hover:bg-neutral-100 dark:hover:bg-neutral-800
                focus:outline-none focus:border-indigo-700 dark:focus:border-indigo-300"
            href="{{ $href }}">
            {{ $content }}
        </a>
    @else
        <a class="px-3 py-4 border-b-2 border-transparent
                text-sm font-medium leading-5 inline-flex h-auto
                text-neutral-500 dark:text-neutral-400
                hover:border-neutral-300 dark:hover:border-neutral-700
                hover:text-neutral-700 dark:hover:text-neutral-300
                hover:bg-neutral-100 dark:hover:bg-neutral-800

                focus:outline-none focus:border-neutral-300 dark:focus:border-neutral-700
                focus:text-neutral-700 dark:focus:text-neutral-300"
            href="{{ $href }}">
            {{ $content }}
        </a>
    @endif
@else
    <a class="px-3 py-4 border-b-2 border-transparent
                text-sm font-medium leading-5 inline-flex h-auto
                text-neutral-500 dark:text-neutral-400
                hover:text-neutral-700 dark:hover:text-neutral-300
                hover:bg-neutral-100 dark:hover:bg-neutral-800

                focus:outline-none
                focus:text-neutral-700 dark:focus:text-neutral-300
                focus:bg-neutral-100 dark:focus:bg-neutral-800"
            href="{{ $href }}">
        {{ $content }}
    </a>
@endif
