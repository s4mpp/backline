@extends('backline::layout.body')

@section('main')
    <div class="px-6 inline-flex max-w-full items-center md:gap-1 mb-1">
        <div class="inline-flex max-w-full items-center md:gap-2">
            <a href="{{ route('backline.home.index') }}" class="text-gray-400 hover:text-gray-500 inline-flex">
                <i class="fa fa-home text-gray-500 text-[10px]"></i>
            </a>

            @isset($breadcrumbs)
                @foreach($breadcrumbs as $breadcrumb)
                    <i class="fa fa-chevron-right text-gray-500 text-[10px]"></i>
                    <span class="text-xs font-medium truncate text-gray-600">{{ $breadcrumb }}</span>
                @endforeach
            @endisset

            <i class="fa fa-chevron-right text-gray-500 text-[10px]"></i>
            <span class="text-xs font-medium truncate text-gray-600">@yield('title')</span>
        </div>
    </div>


    <div class="px-6 flex gap-3 flex-nowrap items-center justify-between">
        <h2 class="flex-1 text-2xl font-bold truncate text-base-900 sm:text-3xl">@yield('title')</h2>

        <div class="flex justify-end gap-4">
            @yield('buttons-title-page')
        </div>
    </div>

    <div class="lg:px-6 mt-4">
        @yield('content')
    </div>
@endsection
