@extends('backline::resources.index')

@section('index')
	<div class="overflow-x-auto">
		<table class="w-full">
			<thead class="border-0 text-left bg-gray-200">
				<tr class="divide-x divide-gray-200">
					@foreach($columns as $column)
						<th class="px-4 py-2 text-sm font-semibold text-gray-700 whitespace-nowrap">{{ $column->getTitle() }}</th>
					@endforeach
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($registers as $register)
					<tr class="odd:bg-gray-100/30 even:bg-gray-200/50">
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
							@isset($actions['read'])
								<a title="Visualizar" href="{{ route($resource->getRouteName('read'), ['id' => $register->id]) }}" class="text-sm text-gray-500 hover:text-gray-600">
									<i class="fa fa-eye"></i>
								</a>
							@endisset
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection
