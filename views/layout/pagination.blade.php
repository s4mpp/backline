<div class="flex px-4 sm:px-6 lg:px-2 justify-between text-center border-t border-gray-200 py-3 text-xs mb-0 text-gray-700">
	<p>Pagina <strong>{{  Number::format($paginator->currentPage()) }}</strong> de <strong>{{ Number::format($paginator->lastPage()) }}</strong></p>
	<p>{{ Number::format($paginator->total()) }} {{ Str::plural('registro', $paginator->total()) }}</p>
</div>

@if ($paginator->hasPages())
	<nav class="flex items-center justify-between border-t  border-gray-200  px-0 ">
		<div class="-mt-px flex w-0 flex-1">

		@if ($paginator->onFirstPage())
				<span class="inline-flex items-center border-t-2 border-transparent  py-4 sm:px-6 lg:px-2 text-sm font-medium text-gray-400">
					<i class="fa fa-chevron-left"></i>
					<span>Anterior</span>
				</span>
			@else
				<a href="{{ $paginator->previousPageUrl() }}" class="inline-flex  transition-colors items-center border-t-2 border-transparent py-4 sm:px-6 lg:px-2  text-sm font-medium text-gray-600 hover:border-gray-400">
					<i class="fa fa-chevron-left"></i>
					<span>Anterior</span>
				</a>
			@endif
		</div>

		<div class="hidden md:-mt-px md:flex">
			@foreach ($elements as $element)
				@if (is_string($element))
					<span class="inline-flex   transition-colors items-center border-t-2 border-transparent px-4 py-4 text-sm font-medium text-gray-500">...</span>
				@endif

				@if (is_array($element))
					@foreach ($element as $page => $url)
						@if ($page == $paginator->currentPage())
							<span class="inline-flex  transition-colors items-center border-t-2 border-gray-700 px-4 py-4 text-sm font-medium text-gray-900" aria-current="page">{{ Number::format($page) }}</span>
						@else
							<a href="{{ $url }}" class="inline-flex transition-colors  items-center border-t-2 border-transparent px-4 py-4 text-sm font-medium text-gray-600 hover:border-gray-400 ">{{ Number::format($page) }}</a>
						@endif
					@endforeach
				@endif
			@endforeach
		</div>

		<div class="-mt-px flex w-0 flex-1 justify-end">
			@if ($paginator->hasMorePages())
				<a href="{{ $paginator->nextPageUrl() }}" class="inline-flex   backdrop:  transition-colors items-center border-t-2 border-transparent px-3 py-4 text-sm font-medium text-gray-600 hover:border-gray-400">
					<span>Próxima</span>
					<i class="fa fa-chevron-right"></i>
				</a>
			@else
				<span class="inline-flex  items-center border-t-2 border-transparent px-0 py-4 sm:px-6 lg:px-2 text-sm font-medium text-gray-400 ">
					<span>Próxima</span>
					<i class="fa fa-chevron-right"></i>
				</span>
			@endif
		</div>
	</nav>
@endif
