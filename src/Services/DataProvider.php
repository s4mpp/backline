<?php

namespace S4mpp\Backline\Services;

use Illuminate\Database\Eloquent\Model;
use S4mpp\Backline\Builders\TableBuilder;

final class DataProvider
{
	public function __construct(private TableBuilder $builder, private Model $model)
	{
		
	}

    public function getData()
    {
        return $this->model::paginate();
    }
}