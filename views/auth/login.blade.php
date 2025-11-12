@extends('backline::auth.main')

@section('title', 'Login')

@section('content')

	<form method="POST" action="{{ route('backline.auth') }}" x-data="{loading: false}" x-on:submit="loading = true">
		@csrf
		<div class="flex flex-col items-center gap-6">
			<x-blix::form.input value="{{ old('username') }}" class="border-gray-300" required type="email" name="username" title="E-mail" />
	
			<x-blix::form.input class="border-gray-300" required type="password" name="password" title="Senha" />
	
			<x-blix::ui.button hasLoading class="bg-gray-300 ring-gray-700  text-gray-800 border-transparent  w-full" type="submit">Entrar</x-blix::ui.button>
		</div>
	</form>
@endsection