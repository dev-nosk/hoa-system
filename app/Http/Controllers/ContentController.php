<?php

namespace App\Http\Controllers;
use App\Models\Content\Feed;

use Illuminate\Http\Request;

class ContentController extends Controller
{
    //
public function getFeed(Request $request)
{
    $data = Feed::with('user')->orderBy('created_at', 'desc')->get();
    $html = $data ? view('content.feed',compact('data'))->render() : 'no data found';
    return response()->json([
        'html' => $html,
    ]); 
}
}
