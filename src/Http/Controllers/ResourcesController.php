<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use File;

class ResourcesController extends Controller
{
	private $css_path;
    private $js_path;
	private $image_path;

	public function __construct()
	{
		$this->css_path = base_path('vendor/systeminc/laravel-admin/src/resources/assets/dist/css/');
        $this->js_path = base_path('vendor/systeminc/laravel-admin/src/resources/assets/dist/js/');
		$this->image_path = base_path('vendor/systeminc/laravel-admin/src/resources/assets/dist/images/');
	}

    public function css($filename)
    {
        return response()->file($this->css_path.$filename, ['Content-Type' => 'text/css']);
    }

    public function scripts($filename)
    {
        if (File::extension($this->js_path.$filename)) {
            $mime = 'text/css';
        }
        else {
            $mime = File::mimeType($this->js_path.$filename);
        }

        return response()->file($this->js_path.$filename, ['Content-Type' => $mime]);
    }    

    public function images($filename)
    {
        return response()->file($this->image_path.$filename);
        
    }
}
