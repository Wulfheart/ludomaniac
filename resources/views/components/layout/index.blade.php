@props(['title' => null, 'header_title' => null,])

<x-layout.base :title="$title">
    <div class="py-10">
        @isset($header_title)
        <header>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight tracking-tight text-gray-900">{{ $header_title }}</h1>
            </div>
        </header>
        @endisset
        <main>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="px-4 py-8 sm:px-0">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
    </div>

</x-layout.base>
