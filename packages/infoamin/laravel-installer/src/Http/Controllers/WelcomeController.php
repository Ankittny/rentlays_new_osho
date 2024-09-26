<?php

namespace Infoamin\Installer\Http\Controllers;

use AppController;

class WelcomeController extends AppController
{
    /**
     * Display the installer welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        echo env('APP_INSTALL'); die;
        return view('vendor.installer.welcome');
    }

}