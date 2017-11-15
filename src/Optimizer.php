<?php

namespace LaralLover\Optimizer;

use Illuminate\Support\Facades\Schema;
use DB;

Class Optimizer
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

	public function checkStatus()
	{
		if (Schema::hasTable('permissions')) {
			$query = DB::table('permissions')->where('permission', 'yes')->first();

			if (!is_null($query)) {
				return true;
			}

			return false;
		}
	}
}
