@extends('backline::layout.html')

@section('body')
	<div x-data="{mobileMenuOpen: false}" class="overflow-x-hidden">
		<header class="flex justify-between items-center bg-gray-800">
			<div class="inline-flex items-center px-6">
				<button x-on:click="mobileMenuOpen = !mobileMenuOpen"	type="button" class="text-gray-200 lg:hidden pr-2 cursor-pointer">
					<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
					</svg>
				</button>
				
				<a href="{{ route('backline.home.index') }}" class="flex items-center">
					<h1 class="text-white truncate">{{ config('app.name') }}</h1>
				</a>
			</div>

			<div class="relative flex items-center p-2 bf-3">
				<form action="{{ route('backline.logout') }}" method="POST">
					@csrf
				
					<button type="submit" class="cursor-pointer text-white bg-red-800 hover:bg-red-900 transition-colors py-1 px-3">
						<span class="text-sm font-semibold">Sair</span>
					</button>
				</form>
			</div>
		</header>

		<div class="flex justify-start max-w-screen w-screen" >
			<div
			x-bind:class="mobileMenuOpen ? 'ml-0' : '-ml-[220px]'"
			class="-ml-[220px]  lg:ml-0 transition-all lg:transition-none w-[220px]">
			    <nav class="  pt-4 divide-y">
				   @foreach ($menu as $section)
					   <div class="py-3 px-2">
						   <div class="text-xs mb-1 px-4 font-semibold uppercase text-gray-900">{{ $section['title'] }}</div>
						   <div class="w-full">
							   @foreach ($section['items'] as $item)
								   <ul class="px-0">
									   <li>
										   <a title="{{ $item['title'] }}"
										   @class([
											   'group flex justify-between font-medium items-center p-2 text-sm transition-ease-in transition-colors ',
											   'hover:text-gray-900 text-gray-600' => !$item['active'],
											   'text-gray-900' => $item['active'],
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
														   "block px-2 py-1 text-[10px]",
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
   
		   <div x-bind:class="mobileMenuOpen ? '-mr-[220px] lg:mr-0 ml-0 ' : ''" class=" flex-1 py-5 transition-all lg:transition-none w-full overflow-x-hidden">
			   <main>
				    @yield('main')
			   </main>
		   </div>
	   </div>
	</div>
@endsection
