@extends('backline.layout.html')

@section('body')
	<div class="w-full ">
		<div class="w-full flex items-center justify-between">
			<div class="px-6 flex justify-start items-center gap-6 ">
				<h1 class="text-white text-lg "><a href="{{ route('admin.dashboard') }}"><strong>{{ config('app.name') }}</strong></a></h1>

				<div class="inline-flex ">
					<div x-data="{dropdown : false, toggleDropdown() {this.dropdown = !this.dropdown}}">
						<button x-bind:class="dropdown ? 'bg-white/10' : '' " x-on:click="toggleDropdown()" class=" h-10 px-6 gap-2 items-center cursor-pointer py-0 text-sm inline-flex text-white">
							<span class="text-nowrap">Ferramentas</span>
							<span class="text-xs">&#x25BC;</span>
						</button>

						<div
							x-on:click.outside="dropdown = false"
							class="bg-white z-50 absolute shadow max-w-[240px] text-black w-full left-auto" x-cloak x-transition x-show="dropdown">
							
							<div class="flex-col w-full text-gray-800 text-sm ">
								<a href="{{ route('admin.tools.file-rfb') }}" class="w-full truncate py-2 block px-6 hover:bg-gray-50">Geração de arquivo para RFB</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div>
				<form action="{{ route('admin.logout') }}" method="POST">
					@csrf

					<button type="submit" class="bg-red-700 px-6 py-2  text-white cursor-pointer transition-colors hover:bg-red-600 ">
						<span class="text-sm  font-semibold">Sair</span>
					</button>
				</form>
			</div>
		</div>
	</div>

	<div class="w-full ">
		<div class="w-full px-6 py-4">
			<div class="flex justify-between items-center mb-3 border-b border-gray-300 pb-3">
				<h2 class="text-lg font-semibold">@yield('title')</h2>
				<div class="flex gap-2">
					@yield('actions')
				</div>
			</div>

			<div class="mb-3">
				{{-- <x-element::message.flash /> --}}
				{{-- <x-element::message.error /> --}}
			</div>

			<main>
				@yield('content')
			</main>
		</div>
	</div>
@endsection
