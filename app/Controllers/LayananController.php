<?php

namespace App\Controllers;

use App\Models\LayananModel;
use App\Models\PaketModel;

class LayananController extends BaseController
{
    public function index()
    {
        $model = new LayananModel();
        $data['layanan'] = $model->getAllLayanan();
        return view('index', $data);
    }
}
