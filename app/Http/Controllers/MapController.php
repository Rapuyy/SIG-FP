<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Map;

class MapController extends Controller
{
    public function index()
    {
        $maps = Map::select('category')->distinct()->get();
        // dd($maps);
        return view('welcome', compact('maps'));
    }

    public function getMapData()
    {
        $maps = Map::all();
        return response()->json(['code'=>200, 'message'=>'Post Created successfully','data' => $maps], 200);
    }

    public function store(Request $request)
    {
        Map::create([
            'name' => $request->name,
            'category' => $request->category,
            'detail' => $request->detail,
            'lat' => $request->lat,
            'long' => $request->long,
        ]);
        return redirect()->route('index');
    }
}
