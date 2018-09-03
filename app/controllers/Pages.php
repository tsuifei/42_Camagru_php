<?php
class Pages extends Controller
{
    public function __construct()
    {
     
    }
    public function index()
    {
        $data = [
            'title' => 'CAMAGRU PARIS',
            'description' => 'CAMAGRU PARIS',
        ];

        $this->view('pages/index', $data); //不需加.php 會自動去views裡載過來這裡。

    }

    public function about()
    {
        $data = [
            'title' => 'About Us',
            'description' => 'c\'est un projet PHP d\'ecole 42'
        ];
        //echo 'This is About';
        $this->view('pages/about', $data);
    }

    public function gallery()
    {
        $data = [
            'title' => 'Gallery',
            'description' => 'Gallery pour les photos de Camagru'
        ];
        //echo 'This is About';
        $this->view('pages/gallery', $data);
    }
}