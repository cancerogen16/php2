<?php

class Controller_Index extends Engine\Controller_Base {
	function index() {
        $this->render('index/home.html.twig', [
            'title' => 'Главная страница',
            'description' => 'Урок №4',
        ]);
	}
}