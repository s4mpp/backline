<select title="{{ $input->getTitle() }}" class="w-full">
	@foreach($input->getOptions() as $key => $value)
		<option value="{{ $key }}" @selected($key == $attributes['content'])>{{ $value }}</option>
	@endforeach
</select>
