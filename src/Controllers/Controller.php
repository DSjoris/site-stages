<?php
    namespace App\Controllers;

    abstract class Controller {
        protected $model;
        protected $templateEngine;

        public function __construct($templateEngine) {
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
            header('Pragma: no-cache');
        }
    }
?>