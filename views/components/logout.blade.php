<form action="{{ route('backline.logout') }}" method="POST">
	@csrf

	{{ $slot }}
</form>