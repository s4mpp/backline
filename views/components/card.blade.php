<div class="bg-white border border-gray-200 flex-1">
	@if(isset($title) && $title)
		<p class="text-sm mb-3 font-semibold">{{ $title }}</p>
	@endif

    <div>
        {{ $slot }}
    </div>
</div>
