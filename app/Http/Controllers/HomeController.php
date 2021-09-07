<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.home', ["news" => $news]);
    }
}
