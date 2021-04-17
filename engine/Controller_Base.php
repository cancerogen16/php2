<?php

namespace Engine;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller_Base {

	protected $loader;
	protected $twig;

	public $data = [];

    public function __construct() {
        $this->loader = new FilesystemLoader(TEMPLATES_DIR);
        $this->twig = new Environment($this->loader, ['debug' => true]);
	}

	abstract function index();

	protected function render($template, $data) {
        echo $this->twig->render($template, $data);
    }
}