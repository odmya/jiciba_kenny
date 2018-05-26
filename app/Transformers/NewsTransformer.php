<?php

namespace App\Transformers;

use App\Models\News;
use League\Fractal\TransformerAbstract;

class NewsTransformer extends TransformerAbstract
{

    public function transform(News $news)
    {
        return [
            'id' => $news->id,
            'title' => $news->title,
            'sub_title' => $news->sub_title,
            'author' => $news->author,
            'image' => $news->image,
            'description' =>str_replace(array("&rdquo;","&ldquo;","&rsquo;","&#39;","&lsquo;"),"'",$news->description),
            'created_at' => $news->created_at->toDateTimeString(),
            'updated_at' => $news->updated_at->toDateTimeString(),
        ];
    }

}
