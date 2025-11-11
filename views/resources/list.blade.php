@extends('backline::resources.index')

@section('index')
	<x-backline::card class="bg-white">
		<div class="overflow-x-auto">
			<table class="w-full">
				<thead class="border-0 text-left bg-gray-200">
					<tr class=" border-b divide-x divide-gray-300 border-gray-300">
						@foreach($columns as $column)
							<th class="px-4 py-2 text-sm font-semibold text-gray-700 whitespace-nowrap">{{ $column->getTitle() }}</th>
						@endforeach
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($registers as $register)
						<tr class="odd:bg-gray-100/30 even:bg-gray-200/50 divide-x divide-gray-200">
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
									@isset($actions['read'])
										<a title="Visualizar" href="{{ route($resource->getRouteName('action', 'read'), ['id' => $register->id]) }}" class="text-sm text-gray-500 hover:text-gray-600">
											<i class="fa fa-eye"></i>
										</a>
									@endisset
		
									@isset($actions['update'])
										<a title="Editar" href="{{ route($resource->getRouteName('action', 'update'), ['id' => $register->id]) }}" class="text-sm text-gray-500 hover:text-gray-600">
											<i class="fa fa-edit"></i>
										</a>
									@endisset
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</x-backline::card>
@endsection
