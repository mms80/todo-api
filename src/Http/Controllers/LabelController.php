<?php

namespace mms80\TodoApi\Http\Controllers;

use mms80\TodoApi\Http\Requests\Label\StoreRequest;
use mms80\TodoApi\Http\Resources\LabelAPIResource;
use Illuminate\Http\Request;
use mms80\TodoApi\Label;

class LabelController extends Controller
{
    public function index()
    {
        $labels = Label::paginate()->getCollection();
        return LabelAPIResource::collection($labels);
    }

    public function store(StoreRequest $request)
    {
        $request->validated();
        $label = Label::create([
            'title' => $request['title']
        ]);
        return new LabelAPIResource($label);
    }
}
