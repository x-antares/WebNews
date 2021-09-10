<?php

namespace App\Http\Requests;

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
        $this->formatTagsString();
        return parent::getValidatorInstance();
    }

    protected function formatTagsString()
    {
        $this->request->set('tag', explode(" ", $this->request->get('tag')));
    }
}
