<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class Unit extends Model
{
    use Sortable;
    public $sortable = [
		'id',
		'name',
		'shortcode',
		'status',
		'created_at',
	];
}
