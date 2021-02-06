<?php

class Mandiri_Controller extends MY_Controller 
{
	/*
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->includes['folder_themes'] = '../../'.$this->theme_folder.'/'.$this->theme;
		$this->controller = strtolower($this->router->fetch_class());
		if ($this->session->mandiri != 1 OR $this->setting->layanan_mandiri == 0) redirect();
	}

}
