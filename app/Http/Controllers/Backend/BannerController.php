<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Banner;




class BannerController extends Controller
{
    public function AllBanner() {
        $banner = Banner::latest()->get();
        return view('backend.banner.banner_all', compact('banner'));
    }
}
