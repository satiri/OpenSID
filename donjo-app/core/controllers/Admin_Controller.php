<?php

class Admin_Controller extends MY_Controller {

public $grup;
public $CI = NULL;
public $pengumuman = NULL;
public $header;
protected $nav = 'nav';
protected $minsidebar = 0;
public function __construct()
{
    parent::__construct();
    $this->CI = CI_Controller::get_instance();
    $this->controller = strtolower($this->router->fetch_class());
    $this->load->model(['header_model', 'user_model', 'notif_model']);
    $this->grup	= $this->user_model->sesi_grup($_SESSION['sesi']);

    $this->load->model('modul_model');
    if (!$this->modul_model->modul_aktif($this->controller))
    {
        session_error("Fitur ini tidak aktif");
        redirect('/');
    }
    if (!$this->user_model->hak_akses($this->grup, $this->controller, 'b'))
    {
        if (empty($this->grup))
        {
            $_SESSION['request_uri'] = $_SERVER['REQUEST_URI'];
            redirect('siteman');
        }
        else
        {
            session_error("Anda tidak mempunyai akses pada fitur ini");
            unset($_SESSION['request_uri']);
            redirect('/');
        }
    }
    $this->cek_pengumuman();
    $this->header = $this->header_model->get_data();
}

private function cek_pengumuman()
{
    if ($this->grup == 1) // hanya utk user administrator
    {
        $notifikasi = $this->notif_model->get_semua_notif();
        foreach($notifikasi as $notif)
        {
            $this->pengumuman = $this->notif_model->notifikasi($notif);
            if ($notif['jenis'] == 'persetujuan') break;
        }
    }
}

protected function redirect_hak_akses($akses, $redirect = '', $controller = '')
{
    $kembali = $_SERVER['HTTP_REFERER'];

    if (empty($controller))
        $controller = $this->controller;
    if ( ! $this->user_model->hak_akses($this->grup, $controller, $akses))
    {
        session_error("Anda tidak mempunyai akses pada fitur ini");
        if (empty($this->grup)) redirect('siteman');
        empty($redirect) ? redirect($kembali) : redirect($redirect);
    }
}

public function cek_hak_akses($akses, $controller = '')
{
    if (empty($controller))
        $controller = $this->controller;
    return $this->user_model->hak_akses($this->grup, $controller, $akses);
}

public function render($view, Array $data = NULL)
{
    $this->header['minsidebar'] = $this->get_minsidebar();
    $this->load->view('header', $this->header);
    $this->load->view('nav');
    $this->load->view($view, $data);
    $this->load->view('footer');
}

/**
 * Get the value of minsidebar
 */
public function get_minsidebar()
{
    return $this->minsidebar;
}

/**
 * Set the value of minsidebar
 *
 * @return  self
 */
public function set_minsidebar($minsidebar)
{
    $this->minsidebar = $minsidebar;
    $this->header['minsidebar'] = $this->get_minsidebar();

    return $this;
}

}
