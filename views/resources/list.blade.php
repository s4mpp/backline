@extends('backline::resources.index')

@section('index')
	<x-backline::card class="bg-white">
		<div class="overflow-x-auto">
			<table class="w-full">
				<thead class="text-left bg-gray-100">
					<tr class="">
						@foreach($columns as $column)
							<th class="px-4 py-2 text-sm font-semibold text-gray-700 whitespace-nowrap">{{ $column->getTitle() }}</th>
						@endforeach
						<th></th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-200">
					@foreach($registers as $register)
						<tr >
							@foreach($columns as $column)
								@php
									$column->setRegister($register);

									$column->setContentFromRegister();

									$column->runCallbacks();
								@endphp

								<td class="px-4 py-2 text-sm text-gray-700 whitespace-nowrap">
									<span>
										{{ $column->getContentFormatted() }}
									</span>

									@if($details = $column->getDetails())
										<p class="text-base-500 text-xs">{{ $details }}</p>
									@endif
								</td>
							@endforeach
							<td>
								<div class="font-medium w-full flex items-center justify-end gap-4 pr-4">
									@isset($actions['update'])
										<a title="Editar" href="{{ route($resource->getRouteName('action', 'update'), ['id' => $register->id]) }}" class="text-sm text-gray-500 hover:text-gray-600">
											<i class="fa fa-edit"></i>
										</a>
									@endisset

									@isset($actions['read'])
										<a title="Visualizar" href="{{ route($resource->getRouteName('action', 'read'), ['id' => $register->id]) }}" class="text-sm text-gray-500 hover:text-gray-600">
											<i class="fa fa-eye"></i>
										</a>
									@endisset
	
									@isset($actions['delete'])
										<form class="flex" onsubmit="return window.confirm('Tem certeza que deseja excluir este registro?')" method="POST"  action="{{ route($resource->getRouteName('action', 'delete'), ['id' => $register->id]) }}">
											@csrf
											@method('DELETE')

											<button title="Excluir" class="text-sm text-red-500 cursor-pointer hover:text-red-600">
												<i class="fa fa-trash"></i>
											</button>
										</form>
 									@endisset
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		@if(!$registers->isEmpty())
			{{ $registers->appends(request()->query())->links('backline::layout.pagination') }}
		@endif
	</x-backline::card>
@endsection
