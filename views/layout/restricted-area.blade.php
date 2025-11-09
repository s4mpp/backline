@extends('backline::layout.html')

@section('body')
	<div class="scrollbar-track-gray-200 h-full">
		<header class="flex justify-between items-center bg-gray-800">
			<div class="inline-flex items-center gap-4 px-6">
				<a href="{{ route('backline.home.index') }}" class="h-12 flex items-center">
					<h1 class="text-white truncate">{{ config('app.name')  }}</h1>
				</a>
			</div>

			<div class="relative flex items-center">
				<div>
					<form action="{{ route('backline.logout') }}" method="POST">
						@csrf
	
						<x-blix::ui.button type="submit" class="h-12 border-transparent focus:ring-0 text-white bg-red-500 hover:bg-red-600">
							<span class="text-sm  font-semibold">Sair</span>
						</x-blix::ui.button>
					</form>
				</div>
				{{-- <x-element::dropdown position="right">
					<x-slot:button class="">
						<button	x-on:click="toggleDropdown()" type="button" class="transition-colors hover:bg-black/10 focus:bg-black/10 pl-3 h-[50px]  pr-3 flex items-center px-1.5" id="user-menu-button" aria-expanded="false" aria-haspopup="true">

							<div class="h-7 w-7 flex items-center justify-center  rounded-full bg-white/10">
								<i class="fa fa-user-circle text-gray-200"></i>
							</div>

							<span class="hidden lg:flex lg:items-center gap-1">
								<div class="flex mx-2 flex-col items-start leading-tight text-white">
									<span class="text-[12px] font-semibold ">{{ auth()->guard(AdminPanel::getGuardName())->user()->name }}</span>
									<span class="text-[10px] ">{{ auth()->guard(AdminPanel::getGuardName())->user()->email }}</span>
								</div>

								<i class="fa fa-chevron-down text-white/60 text-xs"></i>
							</span>
						</button>
					</x-slot:button>

					<x-slot:body class="min-w-[230px]">
						<div class="divide-y divide-gray-200 dark:divide-gray-500/80">
							<div class="px-4 py-3 " role="none">
								<p class="text-sm " role="none">{{ auth()->guard(config('admin.guard', 'web'))->user()->name }}</p>
								<p class="truncate text-sm font-medium text-gray-900 dark:text-gray-100" role="none">{{ auth()->guard(config('admin.guard', 'web'))->user()->email }}</p>
							</div>
							<div>
								@can('AdminConfig.x.config.permissions')
									<x-element::dropdown.link href="{{ route('admin.roles-and-permissions') }}">
										<i class="fa fa-user-shield text-gray-500"></i>
										<span>Permissões</span>
									</x-element::dropdown.link>
								@endcan

								@can('AdminConfig.x.config.users')
									<x-element::dropdown.link href="{{ route('admin.users') }}">
										<i class="fa fa-users text-gray-500"></i>
										<span>Usuários</span>
									</x-element::dropdown.link>
								@endcan

								@if(AdminPanel::saveLogsInDatabase())
									@can('AdminConfig.x.config.logs')
										<x-element::dropdown.link href="{{ route('admin.logs') }}">
											<i class="fa fa-clock-rotate-left text-gray-500"></i>
											<span>Logs de atividade</span>
										</x-element::dropdown.link>
									@endcan
								@endif
							</div>

							<x-element::dropdown.link :danger=true href="{{ route('admin.logout') }}" class="justify-between">
								<span>Sair</span>
								<i class="fa fa-sign-out"></i>
							</x-element::dropdown.link>
						</div>
					</x-slot:body>
				</x-element::dropdown> --}}
			</div>
		</header>

		<div class="bg-white px-6 py-2 border-b border-gray-300 flex items-center justify-start gap-3">
			{{-- @if($current_module)
				<button class="lg:hidden inline-flex items-center justify-center w-6 h-6 rounded-full border border-gray-400" x-on:click="mobileMenuOpen = !mobileMenuOpen">
					<i class="fa fa-bars text-gray-500 text-xs"></i>
				</button>
			@endif --}}

			<div class="inline-flex max-w-full items-center md:gap-2">
				<a href="{{ route('backline.home.index') }}" class="text-gray-400 hover:text-gray-500 inline-flex">
					<i class="fa fa-home text-gray-500 text-xs"></i>
				</a>

				{{-- @isset($breadcrumbs)
					@foreach($breadcrumbs as $breadcrumb)
						<i class="fa fa-chevron-right text-gray-500 text-xs"></i>
						<span class="text-sm font-medium truncate text-gray-600">{{ $breadcrumb }}</span>
					@endforeach
				@endisset --}}

				<i class="fa fa-chevron-right text-gray-500 text-xs"></i>
				<span class="text-sm font-medium truncate text-gray-600">@yield('title')</span>
			</div>
		</div>

		<main class="h-[calc(100vh-94px)]">
			@yield('content')
		</main>
	</div>
@endsection
