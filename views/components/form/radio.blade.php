{{-- <x-element::form.radio :required="$attributes->get('required')" inline="{{ $input->isInline() }}" title="{{ $input->getTitle() }}"> --}}
	@php
		$content_value = old($attributes->get('name'), $attributes['content']);
	@endphp

	@foreach($input->getOptions() as $id => $value)
		@php
			$checked = ($content_value == strval($id));
		@endphp
		<input type ="radio"
			name="{{ $attributes->get('name') }}"
			:isChecked=$checked
			:required="$attributes->get('required')"
			value="{{ $id }}">{{ $value }}</input>
	@endforeach
{{-- </x-element::form.radio> --}}

