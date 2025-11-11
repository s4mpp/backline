@extends('backline::layout.restricted-area')

@section('content')
	<div class="flex justify-start min-h-full bg-gray-50 max-w-screen w-screen"  x-data="{mobileMenuOpen: false}">
 		<div
		x-bind:class="mobileMenuOpen ? 'ml-0' : '-ml-[220px]'"
		class="-ml-[220px]  lg:ml-0 transition-all lg:transition-none w-[220px] border-r border-gray-200  bg-white">
            <nav class=" sticky top-0 divide-y">
                @foreach ($menu as $section)
                    <div class="py-3 px-2">
                        <div class="text-xs mb-2 px-4 font-semibold uppercase text-gray-400">{{ $section['title'] }}</div>
                        <div class="w-full">
                            @foreach ($section['items'] as $item)
                                <ul class="px-0">
                                    <li>
                                        <a title="{{ $item['title'] }}"
                                        @class([
                                            'group flex justify-between items-center rounded-md p-2 text-sm font-semibold transition-ease-in transition-colors ',
                                            'hover:bg-gray-200 text-gray-700' => !$item['active'],
                                            'text-gray-700 bg-gray-200' => $item['active'],
                                        ])
                                        href="{{ $item['url'] }}">
                                            <div class="flex gap-x-2 items-center justify-start truncate">

                                                <div class="w-4 -mt-0.5">
                                                    <i class="fa fa-{{ $item['icon'] }} transition-colors text-xs"></i>
                                                </div>

                                                <span class="truncate">{{ $item['title'] }}</span>
                                            </div>

                                            @if(!is_null($item['badge']))
                                                <div class="leading-none pr-4">
                                                    <div
                                                    @class([
                                                        "block rounded-full px-2 py-1 text-[10px]",
                                                        'bg-gray-600 text-white' => $item['active'],
                                                        'bg-gray-200 text-gray-700' => !$item['active'],
                                                    ])><span>{{ $item['badge'] }}</span></div>
                                                </div>
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </nav>
		</div>

		<div x-bind:class="mobileMenuOpen ? '-mr-[220px] lg:mr-0 ml-0 ' : ''"
			class="flex-1  py-5 space-y-4 transition-all lg:transition-none w-full overflow-x-hidden">
			<div class="px-6 flex gap-3 flex-nowrap items-center justify-between">
				<h2 class="flex-1 text-2xl font-bold truncate text-base-900 sm:text-3xl">@yield('title')</h2>

				<div class="flex justify-end gap-4">
					@yield('buttons-title-page')
				</div>
			</div>

			<div class="lg:px-6">
				@yield('main')
			</div>
		</div>
	</div>
@endsection
