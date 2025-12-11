<div {{ $attributes->class('bg-white flex-1 border border-gray-200')->merge() }}>
	@if(isset($title) && $title)
		<p class="text-sm mb-3 font-semibold">{{ $title }}</p>
	@endif

    <div>
        {{ $slot }}
    </div>
</div>
