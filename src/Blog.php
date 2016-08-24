<?php

namespace SystemInc\LaravelAdmin;

class Blog
{
    public function posts()
    {
        return BlogPost::all();
    }
}
