<?php

namespace LaralLover\Optimizer;

class Optimizer
{
	public $app;

	public function __construct( $app )
	{
		$this->app = $app;
	}

	public function getApp()
	{
		return $this->app;
	}
}
