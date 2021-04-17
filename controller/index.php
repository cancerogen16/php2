<?php

use Engine\Controller_Base;

class Controller_Index extends Controller_Base {
	function index() {
        $this->render('index/home.html.twig', [
            'title' => 'Главная страница',
            'description' => 'Урок №4',
        ]);
	}
}