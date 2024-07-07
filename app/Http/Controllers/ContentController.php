<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ContentController extends Controller
{
    public function showCategorySelection()
    {
        return view('front.development.crop-calendar');
    }

    public function showContent($category, $subcategory)
    {
        $jsonFilePath = public_path('crop-data.json');
        $jsonData = File::get($jsonFilePath);
        $data = json_decode($jsonData, true);

        if (isset($data[$category]) && isset($data[$category][$subcategory])) {
            return view('front.development.crop-content', ['content' => $data[$category][$subcategory]]);
        } else {
            return view('front.development.crop-content', ['content' => 'No content available.']);
        }
    }
}
