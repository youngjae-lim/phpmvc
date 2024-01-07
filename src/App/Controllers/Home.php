<?php

// Must be at the top of the file. This will enable strict typing mode.
declare(strict_types=1);

namespace App\Controllers;

use Framework\Controller;
use Framework\Viewer;

class Home extends Controller
{
    public function index()
    {
        $viewer = new Viewer;

        echo $viewer->render('shared/header.php', [
            'title' => 'Home Page',
        ]);

        echo $viewer->render('Home/index.php');
    }
}
