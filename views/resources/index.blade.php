@extends('backline::layout.main')

@section('title', $resource->getTitle())

@section('buttons-title-page')
	@if($actions['create'])
		<x-blix::ui.link href="{{ route($resource::getRouteName('action', 'create')) }}" class="bg-green-500 hover:bg-green-600 transition-colors text-white">
			<i class="fa fa-plus-circle"></i> Cadastrar
		</x-blix::ui.link>
	@endif
@endsection

@section('content')
	<div class="space-y-4">
		@if(session()->has('message'))
			<x-blix::ui.alert type="success">{{ session('message') }}</x-blix::ui.alert>
		@endif

		@yield('index')
	</div>
@endsection
