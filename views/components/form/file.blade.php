<div class="flex items-stretch justify-end  ">
	<div class="flex-1 ">
		<input
			name="{{ $input->getFieldName() }}"
			type="file"
			accept="{{ $input->getAcceptableFileTypes() }}"
			title="{{ $input->getTitle() }}"  />
		<span class="text-[10px] pt-1">
			Tamanho máximo: {{ $input->getMaxFileSize() }}
			@if($max_dimensions = $input->getMaxDimensions())
				e {{ $max_dimensions }}
			@endif
		</span>
	</div>
	<div class="min-w-16 px-6 flex items-center justify-center b">
		@if($file = $attributes['content'])
			@php
				$disk = $input->getDisk();

				$exp = explode('.', $file);
				$type_file = end($exp);
			@endphp

			@if(in_array(strtolower($type_file), ['png', 'jpg', 'jpeg', 'gif']))
				<img src="{{ Storage::disk($disk)->url($file) }}" alt="{{ $input->getTitle() }}" class="h-12">
			@else
				<div class="h-8 items-center flex">
					<a context="muted" size="mini" href="{{ Storage::disk($disk)->url($file) }}" target="_blank">Visualizar {{ strtoupper($type_file) }}</a>
				</div>
			@endif
		@endif
	</div>
</div>
