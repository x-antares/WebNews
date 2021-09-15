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
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $news = News::where('active', '1')->orderBy('created_at', 'desc')->paginate(6);
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
            $imageName = $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->store('public/files');
            $news->image_name = $imageName;
            $news->image_path = '/storage/'.$imagePath;
        }
        $news->save();

        // Create tags
        $tags = $tagRequest->get('tag');
        $this->createTags($tags, $news);

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
            $imageName = $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->store('public/files');
            $news->image_name = $imageName;
            $news->image_path = '/storage/'.$imagePath;
        }

        $requestTags = $tagRequest->get('tag');

        $this->createTags($requestTags, $news);
        $news->save();

        // Unlink url
        $this->unlinkInNew($news);

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
        $news->tags()->delete();
        $news->tags()->detach();
        $news->delete();

        return redirect()->route('news.index')->withDanger('Deleted news '.$news->name);
    }

    /**
     * Generate link to this new
     *
     * @param $tagsForLink
     * @param $newsId
     */
    public function generateLinkToNew($tagsForLink, $newsId)
    {
        foreach ($tagsForLink as $value) {
            $search = $value->name;
            $news = News::where('text', 'Like', '%'.$search.'%')->get();
            if(!empty($news)) {
                foreach ($news as $new) {
                    if ($new->id !== $newsId) {
                        $regSearch = '/\b'.$search.'\b/';
                        $subject = $new->text;
                        $url = url("/news/{$newsId}");
                        $replace = ' <a href="'.$url.'">'. $search .'</a>';
                        $result = preg_replace($regSearch, $replace, $subject);
                        $new->text = $result;
                        $new->save();
                    }
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
        $modelNewId = $modelNew->id;
        $tags = Tag::all();

        $arrayTagName = [];
        $arrayReplace = [];

        foreach ($tags as $tag) {
            $tagName = $tag->name;

            if(strpos($subject, $tagName) !== false) {
                $news = $tag->news->first();
                $newsId = $news->id;

                if($modelNewId !== $newsId) {
                    $url = url("/news/{$newsId}");
                    $replace = '<a href="'.$url.'">'.$tagName.'</a>';
                    $tagName = '/\b'.$tagName.'\b/';
                    $arrayReplace[] = $replace;
                    $arrayTagName[] = $tagName;
                }
            }
        }
        $result = preg_replace($arrayTagName, $arrayReplace, $subject);
        $modelNew->text = $result;
        $modelNew->save();
    }

    /**
     * Create Tags
     *
     * @param $tags
     * @param News $news
     */
    public function createTags($tags, News $news)
    {
        $tagsArray = array();

        foreach ($tags as $tag) {
            if($tag !== "")
            {
                $tagModel = new Tag();
                $tagModel->name = $tag;
                $tagModel->save();
                array_push($tagsArray, $tagModel);
            }
        }

        if(!empty($tagsArray))
        {
            $news->tags()->saveMany($tagsArray);

            // Generate link to this news
            $newsId = $news->id;
            $this->generateLinkToNew($tagsArray, $newsId);
        }
    }

    /**
     * Generate link in new
     *
     * @param News $modelNew
     */
    public function unlinkInNew(News $modelNew)
    {
            $subject = $modelNew->text;
            $tags = Tag::all();
            $arraySearch = [];
            $arrayReplace = [];

            foreach ($tags as $tag) {
                $tagName = $tag->name;
                if(strpos($subject, $tagName) !== false) {

                    $news = $tag->news->first();
                    $newsId = $news->id;
                    $genUrl = url("/news/{$newsId}");
                    $url = '<a href="'.$genUrl.'">'.$tagName.'</a>';
                    $arraySearch[] = $url;
                    $arrayReplace[] = $tagName;
                }
            }
            $result = str_replace($arraySearch, $arrayReplace, $subject);
            $modelNew->text = $result;
            $modelNew->save();
    }
}

