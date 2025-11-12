<x-blix::form.container title="{{ $input->getTitle() }}">
	@php
		// $search_selected = request()->input('filters.'.$input->getFieldName()); //TODO pegar do content (remover esta linha)

		$value_selected = $attributes->get('value');
	@endphp

    <div class="flex justify-start  items-center py-2" x-data="{
		isMultiple: {{ $input->isMultiple() ? 'true' : 'false' }},
		modalSearch{{ $input->getFieldName() }}: false,
        values: JSON.parse('{{ json_encode($input->getData($value_selected)) }}'),
		removeInput(i) {
			if(this.isMultiple) {this.inputs.splice(i, 1)} else {this.input = {id: null, label: null}}
		},
		addInput(id, label) {
			if(this.isMultiple) { this.inputs.push({id: id, label: label})} else {this.input = {id: id, label: label};}
		},
	}">
		<div class="text-sm text-gray-500 opacity-90 whitespace-nowrap" x-cloak x-show="!values.length">
			<span >(Não selecionado)</span>
		</div>

		<div class="w-full  flex gap-1 flex-wrap  min-h-[36px] items-center ">
            <template x-for="(value, i) in values" >
                <div class="bg-gray-200 rounded-lg inline-flex items-center px-1 py-0.5 gap-0.5" x-show="value.id">
                    <input type="text" name="{{ $input->getFieldName() }}" x-model="value.id" />
                    <span x-text="value.label" class="text-xs max-w-36 truncate" x-bind:title="value.label"></span>

                    <button type="button" x-on:click="removeInput()" class="text-gray-500 hover:text-gray-800 transition-colors h-5 ">
                        <x-element::icon name="x-mark" mini class="w-4 " />
                    </button>
                </div>
            </template>

			<button type="button" class=" text-gray-400 hover:text-gray-500 ml-1 transition-colors cursor-pointer" x-on:click="modalSearch{{ $input->getFieldName() }} = true">
                <i x-show="isMultiple" class="fa fa-plus-circle"></i>
                <i x-show="!isMultiple" class="fa fa-edit"></i>
			</button>
		</div>

		{{-- <x-element::modal idModal="modalSearch{{ $input->getFieldName() }}" title="Pesquisar">
			<div x-data="{searching: false, searchValue: null}">
				<x-element::form.input name="searchInputModal"
					autocomplete="off"
					x-on:keyup.debounce="if($event.key=='Escape' || $event.key == 'Enter') {return;} $dispatch('search:{{ $input->getFieldName() }}', [searchValue]), searching = true"
					x-on:search-complete.window="searching = false"
					x-on:keydown.escape="searchValue = null; $dispatch('search:{{ $input->getFieldName() }}', []), searching = true"
					type="search" x-model="searchValue">
					<x-slot:start class="w-[25px] pl-2 text-gray-500">
						<div x-show="searching" x-cloak>
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class=" animate-spin w-5 h-5">
								<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
							</svg>
						</div>
						<div x-show="!searching" x-cloak>
							<x-element::icon name="magnifying-glass" class=" w-5 h-5" />
						</div>
					</x-slot:start>

					<x-slot:end class="w-[25px] pr-2 text-gray-500" x-cloak x-show="searchValue" title="Limpar pesquisa (ESC)">
						<button type="button" class="cursor-pointer" x-model="searchValue" x-on:click="searchValue = null; $dispatch('search:{{ $input->getFieldName() }}', []), searching = true">
							<x-element::icon name="x-mark" class=" w-5 h-5" />
						</button>
					</x-slot:end>
				</x-element::form.input>
			</div>

			@livewire('modal-search', [
				'label' => $input->getLabel(),
				'subtitle' => $input->getSubTitle(),
				'fields_to_search' => $input->getSearchIn(),
				'model' => $input->getModel(),
				'input_name' => $input->getFieldName()
			], key($input->getFieldName()))
		</x-element::modal> --}}
	</div>
</x-blix::form.container>
