<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Http\Requests\TagRequest;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $news = News::where('active', 'on')->orderBy('created_at', 'desc')->paginate(4);
        return view('news.index', ["news" => $news]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('news.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewsRequest $request
     * @param TagRequest $tagRequest
     * @return RedirectResponse
     */
    public function store(NewsRequest $request, TagRequest $tagRequest)
    {
        $news = new News;
        $news->name = $request->get('name');
        $news->text = $request->get('text');
        $news->active = $request->get('active');

        // Load image
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('images');
            $news->image_path = '/storage/' . $path;
        }
        $news->save();

        // Create tags
        $tags = $tagRequest->get('tag');
        $tagsArray = array();

        foreach ($tags as $tag) {
                $tagModel = new Tag();
                $tagModel->name = $tag;
                $tagModel->save();
                array_push($tagsArray, $tagModel);
            }
        $news->tags()->saveMany($tagsArray);

        // Generate link to this news
        $thisArr = $news->tags;
        $id = $news->id;
        $this->generateLinkToNew($thisArr, $id);

        // Generate link in this news to another
        $this->generateLinkInNew($news);

        return redirect()->route('news.index')->withSuccess('Created news '.$request->name);
    }

    /**
     * Display the specified resource.
     *
     * @param News $news
     * @return Application|Factory|View
     */
    public function show(News $news)
    {
        return view('news.show', ['news' => $news]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param News $news
     * @return Application|Factory|View
     */
    public function edit(News $news)
    {
        $tags = $news->tags;
        $arr = [];

        foreach ($tags as $tag)
        {
            $arr[] = $tag->name;
        }
        $strTags = implode(" ", $arr);

        return view('news.form', [
            "news" => $news,
            "strTags" => $strTags
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NewsRequest $request
     * @param News $news
     * @param TagRequest $tagRequest
     * @return RedirectResponse
     */
    public function update(NewsRequest $request, News $news, TagRequest $tagRequest)
    {
        $news->name = $request->get('name');
        $news->text = $request->get('text');
        $news->active = $request->get('active');

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('images');
            $news->image_path = '/storage/' . $path;
        }
        $news->save();

        // Update tags
        $tags = $tagRequest->get('tag');
        $tagsArray = array();

        foreach ($tags as $tag) {
            $tagModel = new Tag();
            $tagModel->name = $tag;
            $tagModel->save();
            array_push($tagsArray, $tagModel);
        }
        $news->tags()->saveMany($tagsArray);

        // Generate link to this news
        $thisArr = $news->tags;
        $id = $news->id;
        $this->generateLinkToNew($thisArr, $id);

        // Generate link in this news to another
        $this->generateLinkInNew($news);

        return redirect()->route('news.index')->withSuccess('Updated news '.$news->name);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param News $news
     * @return RedirectResponse
     */
    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('news.index')->withDanger('Deleted news '.$news->name);
    }

    /**
     * Generate link to this new
     *
     * @param $arr
     * @param $arrId
     */
    public function generateLinkToNew($arr, $arrId)
    {
        foreach ($arr as $value)
        {
            $search = $value->name;
            $news = News::where('text', 'Like', '%'.$search.'%')->get();

            if(!empty($news)) {
                foreach ($news as $new) {
                    $subject = $new->text;
                    $url = url("/news/{$arrId}");
                    $replace = '<a href="'.$url.'">'.$search.'</a>';;
                    $result = str_replace($search, $replace, $subject);
                    $new->text = $result;
                    $new->save();
                }
            }
        }
    }

    /**
     * Generate link in this new to another news
     *
     * @param News $modelNew
     */
    public function generateLinkInNew(News $modelNew)
    {
        $subject = $modelNew->text;
        $tags = Tag::all();
        foreach ($tags as $tag) {
            $tagName = $tag->name;

            if(strpos($subject, $tagName) !== false) {
                $array = $tag->news;
                foreach ($array as $value) {
                    $newsId = $value->id;
                    $url = url("/news/{$newsId}");
                    $replace = '<a href="'.$url.'">'.$tagName.'</a>';
                    $result = str_replace($tagName, $replace, $subject);
                    $modelNew->text = $result;
                    $modelNew->save();
                }
            }
        }
    }
}

