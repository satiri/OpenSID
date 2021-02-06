<?php

class Web_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->includes['folder_themes'] = '../../'.$this->theme_folder.'/'.$this->theme;
        $this->controller = strtolower($this->router->fetch_class());
    }

    /*
    * Jika file theme/view tidak ada, gunakan file klasik/view
    * Supaya tidak semua layout atau partials harus diulangi untuk setiap tema
    */
    public static function fallback_default($theme, $view)
    {
        $view = trim($view, '/');
        $theme_folder = self::get_instance()->theme_folder;
        $theme_view = "../../$theme_folder/$theme/$view";

        if (!is_file(APPPATH .'views/'. $theme_view))
        {
            $theme_view = "../../themes/klasik/$view";
        }

        return $theme_view;
    }
}
