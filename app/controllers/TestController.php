<?php

class TestController
{
    public function index()
    {
        $message = $_GET['message'] ?? 'NO MESSAGE';
        require __DIR__ . '/../views/test/index.php';
    }           
}
