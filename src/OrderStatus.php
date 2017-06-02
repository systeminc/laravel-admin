<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{	 
	const REFUNDED = -2;
	const NOT_ACCEPTED = -1;
	const CREATED = 0;
	const ACCEPTED = 1;
	const PAID = 2;
	const SHIPPED = 3;
	const DELIVERED = 4;

    protected $fillable = ['title'];
}
