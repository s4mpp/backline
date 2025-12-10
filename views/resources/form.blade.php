@extends('backline::layout.main')

@section('title', $title)

@section('buttons-title-page')
	{{-- <x-element::link context="muted" href="{{ route($resource->getRouteName('action', 'index')) }}">
		<x-element::icon name="chevron-left" class="w-5" mini /> Voltar
	</x-element::link>	 --}}
@endsection

@section('content')

	<div class="space-y-4">
		{{-- <x-element::message.error /> --}}

		{{-- <x-admin::form.resource
			action="{{ route($resource->getRouteName('action', 'create', 'save')) }}"
			method="POST"
			actionLabel="Cadastrar"
			:resource=$resource
			:repeaters=$repeaters
			:repeatersAlpineModals=$repeaters_alpine_modals
			:repeatersAlpineData=$repeaters_alpine_data
			:groups=$groups /> --}}

		<form action="{{ $action }}" method="POST" x-data="{loading: false}" enctype="multipart/form-data" x-on:submit="loading = true">
			@csrf
			@method($method)

			<div class="mb-4 space-y-5">
				@foreach($groups as $title => $group)
					{{-- <x-backline::card class="p-6" title="{{ $title == 'main' ? null : $title }}" > --}}

						<div class="space-y-5">
							@foreach($group as $input)

							{{-- @continue($input->isHidden()) --}}

								@php
									$value = old($input->getFieldName()) ?? (isset($register) ? $input->prepareForForm($register->getRawOriginal($input->getFieldName())) : $input->getDefaultValue() );
								@endphp

                                <x-dynamic-component title="{{ $input->getTitle() }}" component="{{ $input->getComponentName() }}" :value=$value :input=$input />

								{{-- <x-blix::form.input class="border-gray-300  rounded-md"
									title="{{ $input->getTitle() }}"
									name="{{ $input->getFieldName() }}"
									value="{{ $value }}"
									type="{{ $input->getType() }}"
									required="{{ $input->isRequired() }}" /> --}}

								{{-- <x-dynamic-component
									component="{{ $input->getComponentName() }}"
									:input=$input
									:required="$input->isRequired()"
									name="{{ $input->getFieldName() }}" :content=$value>
									@if(is_string($value) || is_numeric($value))
										{{ $value }}
									@endif
								</x-dynamic-component> --}}
							@endforeach
						</div>

						{{-- @dump($data) --}}
					{{-- </x-backline::card> --}}
				@endforeach

				{{-- @foreach($repeaters as $repeater)
					<x-admin::card :padding=false title="{{ $repeater->getTitle() }}">
						<x-slot:header>

							<x-element::button size="mini" context="info" type="button" x-on:click="resetFormRepeater('{{ $repeater->getRelationship() }}'); modalRepeater{{ $repeater->getRelationship() }} = true">Adicionar</x-element::button>

						</x-slot:header>

						@php
							$form_fields = $repeater->getFormFields();
						@endphp

						<x-admin::table>
							<x-slot:header>
								@foreach($form_fields as $input)
									<x-element::table.th class="text-left px-2 py-1">
										{{ $input->getTitle() }}
									</x-element::table.th>
								@endforeach
								<x-element::table.th />
								</x-slot:header>
							<x-slot:body>
								<template x-for="(value, index) in repeatersData['{{ $repeater->getRelationship() }}']">
									<x-element::table.tr class="divide-x divide-base-200 dark:divide-base-700">
										<input type="hidden"  x-model="value.id" x-bind:name="'repeaters[{{ $repeater->getRelationship() }}]['+index+'][id]'">
										@foreach($form_fields as $input)
											<x-element::table.td>
												<input type="hidden" x-model="value.{{ $input->getFieldName() }}"
												x-bind:name="'repeaters[{{ $repeater->getRelationship() }}]['+index+'][{{ $input->getFieldName() }}]'">
												<span x-text="value.{{ $input->getFieldName() }}"></span>
											</x-element::table.td>
										@endforeach
										<x-element::table.td>
											<x-element::button size="mini" type="button" context="danger" x-on:click="deleteItemRepeater('{{ $repeater->getRelationship() }}', index)">
												<x-element::icon name="trash" class="w-3" mini />
											</x-element::button>
											<x-element::link size="mini" type="button" context="info" x-on:click="modalRepeater{{ $repeater->getRelationship() }} = true; resetFormRepeater('{{ $repeater->getRelationship() }}'); editItemRepeater('{{ $repeater->getRelationship() }}', index)">
												<x-element::icon name="pencil-square" class="w-3" mini />
											</x-element::link>
										</x-element::table.td>
									</x-element::table.tr>
								</template>
							</x-slot:body>
						</x-admin::table>
					</x-admin::card>
				@endforeach --}}
			</div>

			<x-blix::ui.button hasLoading class="bg-gray-300 ring-gray-700  text-gray-800 border-transparent" type="submit">Salvar</x-blix::ui.button>
		</form>
	</div>

@endsection
