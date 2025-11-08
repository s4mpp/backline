@extends('backline::layout.html')

@section('body')
	<div class="flex h-full min-h-full bg-gray-100 flex-col items-center justify-center ">
		<div class="pb-12">
			<h1 class="font-bold text-lg mb-6 text-center">{{ config('app.name')  }}</h1>

			<h2 class="text-center">@yield('title')</h2>
		</div>

		<div class="max-w-md w-full border-t border-b lg:border p-6 bg-white border-gray-200 lg:rounded-lg space-y-6">
			<div>
				@foreach($errors->all() as $error)
					<x-blix::ui.alert type="error" class="rounded-md">{{ $error }}</x-blix::ui.alert>
				@endforeach
			</div>

			@yield('content')
		</div>
	</div>
@endsection