@extends('backline::layout.main')

@section('title', 'Visualizar')

@section('buttons-title-page')
	{{-- <x-blix::ui.button x-on:click="window.history.back()" context="muted">
		<i class="la la-chevron-left"></i> Voltar
	</x-blix::ui.button> --}}

	{{-- @if($can_update)
		<x-element::link context="info" class="m-0" href="{{ route($resource->getRouteName('update'), ['id' => $register->id]) }}">
			<x-element::icon name="pencil-square" class="h-5 w-5" mini />
			
			<span class="hidden md:block">Editar</span>
		</x-element::link>
	@endif

	@if($custom_actions)
		<div x-data="{ {{ join(', ', $custom_action_alpine_data) }} }">
			@foreach ($custom_actions as $custom_action)
				@continue(!$custom_action->isValid())
				@continue(!$custom_action->hasConfirmation())
				
				<x-element::modal
					:danger="$custom_action->isDangerous()"
					title="{{ $custom_action->getTitle() }}"
					subtitle="{{ $custom_action->getMessageConfirmation() }}"
					idModal="modalConfirm{{ $custom_action->getSlug(true) }}">

					<form class="m-0" method="POST" action="{{ route($resource->getRouteName('custom-action'), ['slug' => $custom_action->getSlug(), 'id' => $register->id]) }}">
						@csrf
						@method('PUT')

						<input type="hidden" name="confirmed" value="1">

						@if($prompt = $custom_action->getPrompt())
							<x-element::form.textarea rows="4" name="prompt"  required title="{{ $prompt }}"></x-element::form.textarea>
						@endif
	
						<x-element::modal.footer>
							<x-element::button :loading=false type="button" context="muted"
								x-on:click="modalConfirm{{ $custom_action->getSlug(true) }} = false"
								className="ring-inset ring-1 ring-gray-200 btn-muted">
								<span>Voltar</span>
							</x-element::button>


							<x-element::button type="submit" context="{{ $custom_action->isDangerous() ? 'danger' : 'primary' }}">
								<span>Continuar</span>
							</x-element::button>
								
						</x-element::modal.footer>
					</form>
				</x-element::modal>
			@endforeach
			
			<x-element::dropdown position="right">
				
				<x-slot:button>
					<x-element::button x-on:click="toggleDropdown()"> <span>Ações</span>
						<x-element::icon class=" w-5 h-5 mt-0.5" name="chevron-down" solid mini />
					</x-element::button>
				</x-slot:button>
				
				<x-slot:body class="py-1 min-w-56">
					@foreach ($custom_actions as $custom_action)
						@if(!$custom_action->isValid())
							<x-element::dropdown.button type="button" disabled title="{{ $custom_action->getInvalidMessage() }}">
								<span class="py-1 block">{{ $custom_action->getTitle() }}</span>
							</x-element::dropdown.button>
						@elseif($custom_action->hasConfirmation())
							<x-element::dropdown.button type="button" :danger="$custom_action->isDangerous()"
								x-on:click="toggleDropdown(), modalConfirm{{ $custom_action->getSlug(true) }} = true">
								<span class="py-1 block">{{ $custom_action->getTitle() }}</span>
							</x-element::dropdown.button>
						@else
							<form class="m-0" method="POST" action="{{ route($resource->getRouteName('custom-action'), ['slug' => $custom_action->getSlug(), 'id' => $register->id]) }}">
								@csrf
								@method('PUT')
							
								<x-element::dropdown.button type="submit">
									<span class="py-1 block">{{ $custom_action->getTitle() }}</span>
								</x-element::dropdown.button>
							</form>
						@endif
					@endforeach
				</x-slot:body>
			</x-admin::dropdown>
		</div>
	@endif --}}
@endsection

@section('main')

	{{-- <x-element::message.flash type="success" />
	<x-element::message.error /> --}}

	<div class="flex flex-col lg:flex-row justify-start gap-y-1 gap-x-5 my-5">
		<span class="text-xs text-gray-500"><span class="font-semibold text-gray-600 ">ID</span> #{{ Str::padLeft($register->id, 5, '0') }}</span>
		
		@isset($register->created_at)
			<span class="text-xs text-gray-500 "><span class="font-semibold text-gray-600 ">Cadastrado em</span> {{ $register->created_at?->format('d/m/Y H:i') }} ({{ $register->created_at?->diffForHumans(['short' => true]) }})</span>
		@endisset

		@isset($register->updated_at)
			<span class="text-xs text-gray-500 "><span class="font-semibold text-gray-600 ">Última alteração em</span> {{ $register->updated_at?->format('d/m/Y H:i') }} ({{ $register->updated_at?->diffForHumans(['short' => true]) }})</span>
		@endisset
	</div>

	<div class="space-y-4 mb-4">
		@foreach($groups as $title => $group)
			
			<x-backline::card title="{{ $title == 'main' ? null : $title }}">
				<div class="divide-y divide-gray-200 ">
					@foreach($group as $field)
						<div class="p-4 xl:grid xl:grid-cols-12">
							<div class="text-sm font-medium text-gray-900 xl:col-span-2">{{ $field->getTitle() }}:</div>
							<div class="text-sm font-normal text-gray-700 xl:col-span-10">
								@php
									$field->setRegister($register);

									$field->setContentFromRegister();

									$field->runCallbacks();
								@endphp

								<span>
									{{ $field->getContentFormatted() }}
								</span>

								@if($details = $field->getDetails())
									<p class="text-base-500 text-xs">{{ $details }}</p>
								@endif
							</div>
						</div>
					@endforeach
				</div>
			</x-backline::card>
		@endforeach
	</div>

		{{-- @foreach($panels as $panel)
			<x-admin::card  title="{{ $panel->getTitle() }}" id="{{ Str::slug($panel->getTitle()) }}">
				@if($panel->isLivewire())
					@livewire($panel->getSource(), compact('register'))
				@else
					@include($panel->getSource())
				@endif
			 </x-admin::card>
		@endforeach

		@foreach($repeaters as $repeater)
			<x-admin::card  title="{{ $repeater->getTitle() }}" :padding=false>

				 @php
			 		$repeater_registers = $repeater->getRegisters($register);

				 	$columns = $repeater->getColumns($repeater_registers->first());
				 @endphp

				 <x-admin::table :columns=$columns>
					<x-slot:header>
						@foreach($columns as $column)
							<x-element::table.th class="uppercase">
								<span @class(['w-full',
									'text-left' => ($column->getAlignment() == 'left'),
									'text-center' => ($column->getAlignment() == 'center'),
									'text-right' => ($column->getAlignment() == 'right'),
								])>
									{{ $column->getTitle() }}
								</span>
 							</x-element::table.th>
						@endforeach
					</x-slot:header>

					@if($repeater_registers->isNotEmpty())
						<x-slot:body>
							@foreach($repeater_registers as $repeater_register)
								<x-element::table.tr class="divide-x divide-base-200 dark:divide-base-700">
									@foreach ($columns as $column)
										<x-element::table.td
											@class([
												'text-left' => ($column->getAlignment() == 'left'),
												'text-center' => ($column->getAlignment() == 'center'),
												'text-right' => ($column->getAlignment() == 'right'),
											])>

											@php
												$column->setRegister($repeater_register);
												
												$column->setValueFromRegister();
												
												$id = $repeater_register['id'] ?? null;
											@endphp
											
											<x-admin::render-label :register=$repeater_register :label=$column :id=$id  />
										</x-element::table.td>
									@endforeach
								</x-element::table.tr>
							@endforeach
						</x-slot:body>
					@endif
				</x-admin::table>
			</x-admin::card>
		@endforeach
	</div> --}}
@endsection
