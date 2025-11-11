<?php

namespace S4mpp\Backline\DataTransfer;

use Illuminate\Database\Eloquent\Model;
use S4mpp\Backline\Builders\TableBuilder;

final class DataList
{
	public function __construct(private TableBuilder $builder, private Model $model)
	{
		
	}

    public function getData()
    {
        return $this->model::paginate();
    }
}