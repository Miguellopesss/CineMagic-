<div {{ $attributes->merge(['class' => 'flex me-0 z-50 sm:me-1 lg:me-2']) }}>
    @if($selectable)
        @if($selected)
            <a class="grow inline-flex items-center h-16 px-3 sm:px-0.5 md:px-1 lg:px-2 pt-1
                    text-sm font-medium text-neutral-900 dark:text-neutral-50
                    border-b-2 border-red-500 hover:border-red-400"
                href="{{ $href }}">
                {{ $content }}
            </a>
        @else
            <a class="grow inline-flex items-center h-16 px-3 sm:px-0.5 md:px-1 lg:px-2 pt-1
                    text-sm font-medium text-neutral-500 dark:text-neutral-400
                    border-b-2 border-transparent
                    hover:border-neutral-300 dark:hover:border-red-500 hover:text-neutral-700 dark:hover:text-neutral-200
                    focus:outline-none focus:border-red-400 focus:text-neutral-700 dark:focus:text-neutral-300
                    hover:bg-neutral-100 dark:hover:bg-neutral-800 sm:hover:bg-neutral-100 dark:sm:hover:bg-neutral-900"
                href="{{ $href }}">
                {{ $content }}
            </a>
        @endif
    @else
        <a class="grow inline-flex items-center h-16 px-3 sm:px-0.5 md:px-1 lg:px-2 pt-1
                text-sm font-medium text-neutral-500 dark:text-neutral-400
                border-b-2 border-transparent
                hover:text-neutral-700 dark:hover:text-neutral-200
                focus:outline-none  focus:text-neutral-700 dark:focus:text-neutral-300
                hover:bg-neutral-100 dark:hover:bg-neutral-800 sm:hover:bg-neutral-100 dark:sm:hover:bg-neutral-900"
            href="{{ $href }}">
            {{ $content }}
        </a>
    @endif
</div>
