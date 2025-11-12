@extends('backline::layout.main')

@section('title', $resource->getTitle())

@section('buttons-title-page')

@endsection

@section('content')
	<div class="space-y-4">
		@if(session()->has('message'))
			<x-blix::ui.alert type="success">{{ session('message') }}</x-blix::ui.alert>
		@endif

		@yield('index')
	</div>
@endsection
