<x-blix::form.input
    {{ $attributes->merge($input->getAttributes())->class('border-gray-300') }}
    name="{{ $input->getFieldName() }}"
    value="{{ $value }}"
    required="{{ $input->isRequired() }}" />
