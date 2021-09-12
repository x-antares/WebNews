<?php

namespace App\Http\Requests;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tag' => 'min:1|max:25|array',
            'tag.*' => 'min:3|max:25|string|unique:tags,name|distinct',
        ];
    }

    public function messages()
    {
        $messages = [];
        foreach ($this->get('tag') as $key => $val) {
            $messages["tag.$key.min"] = "The Tag: $val must be at least :min.";
            $messages["tag.$key.max"] = "The Tag: $val must not be greater than :max.";
            $messages["tag.$key.string"] = "Tags field input must be a string.";
            $messages["tag.$key.unique"] = "The Tag: $val has already been taken.";
            $messages["tag.$key.distinct"] = "Tags input has a duplicate value.";
        }

        return $messages;
    }

    public function getValidatorInstance()
    {
        $this->unlinkTags();
        $this->freshNewsTags();
        $this->formatTagsString();
        return parent::getValidatorInstance();
    }

    protected function formatTagsString()
    {
        $this->request->set('tag', explode(" ", $this->request->get('tag')));
    }

    protected function freshNewsTags()
    {
        $newsModel = $this->news;

        if(isset($newsModel))
        {
            $newsTags = $newsModel->tags;

            foreach ($newsTags as $newsTag)
            {
                $idTag = $newsTag->id;
                Tag::destroy($idTag);
            }
        }
    }

    public function unlinkTags()
    {
        $newsModel = $this->news;
        $newsId = $newsModel->id;
        $tags = $newsModel->tags;

        foreach ($tags as $value) {
            $replace = $value->name;
            $genUrl = url("/news/{$newsId}");
            $search = '<a href="'.$genUrl.'">'.$replace.'</a>';;

            $news = News::where('text', 'Like', '%'.$search.'%')->get();

            if(!empty($news)) {
                foreach ($news as $new) {
                    $subject = $new->text;
                    $result = str_replace($search, $replace, $subject);
                    $new->text = $result;
                    $new->save();
                }
            }
        }
    }
}
