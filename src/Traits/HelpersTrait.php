<?php

namespace SystemInc\LaravelAdmin\Traits;


trait HelpersTrait
{

	public function sanitizeUri($uri)
	{
		return trim(strtolower(preg_replace(['/[^a-zA-Z0-9-\/]/', '/\/+/', '/-+/'], ['', '/', '-'], $uri)), '/-');
	}

	public function sanitizeUriKey($uri_key)
	{
		return trim(strtolower(preg_replace(['/[^a-zA-Z0-9-]/', '/-+/'], ['', '-'], $uri_key)), '-');
	}

	public function sanitizeElements($element)
	{
		return trim(strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', $element)), '_');
	}

}