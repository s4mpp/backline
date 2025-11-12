<textarea
	title="{{ $input->getTitle() }}"
	{{ $attributes->merge($input->getAttributes())->class(['uppercase' => $input->getIsUppercase()]) }}>
	{{ $value }}
</textarea>
