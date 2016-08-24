<?php

namespace SystemInc\LaravelAdmin;

use SystemInc\LaravelAdmin\BlogPost;

class Blog
{

	public function posts()
	{
		return BlogPost::all();
	}

}