<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Gallery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter');
        $query = Gallery::with('user', 'images');
        if ($filter) {
            $query = $query->where('name', 'like', "%$filter%")
                ->orWhere('description', 'like', "%$filter%")
                ->orWhereHas('user', function ($q) use ($filter) {
                    $q->where('first_name', 'like', "%$filter%")
                        ->orWhere('last_name', 'like', "%$filter%");
                });
        }
        $galleries = $query->orderBy('created_at', 'desc')->simplePaginate(10);

        return response()->json($galleries);
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGalleryRequest $request)
    {
        $gallery = Auth::user()->galleries()->create($request->validated());
        $order = 1;
        foreach ($request->images as $images) {
            $image_url = $images['image_url'];
            $gallery->images()->create(compact('image_url', 'order'));
            $order++;
        }
        $gallery->images;
        return response()->json($gallery);
    }


    public function myGalleries(Request $request)
    {
        $filter = $request->query('filter');
        $query = Auth::user()->galleries()->with('user', 'images');

        if ($filter) {
            $query = $query->where('name', 'like', "%$filter%")->orWhere('description', 'like', "%$filter%")->orWhere("description", 'like', "%$filter%");
        }
        $galleries = $query->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($galleries);
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gallery = Gallery::with('user', 'images')->findOrFail($id);
        return response()->json(($gallery));    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $gallery->update($request->validated());
        if ($request->images) {
            // ordering images by the order they are submited
            $order = 1;
            $gallery->images()->delete();
            foreach ($request->images as $images) {
                $image_url = $images['image_url'];
                $gallery->images()->create(compact('image_url', 'order'));
                $order++;
            }
            info($gallery->images()->get());
        }
        $gallery = $gallery->load('user', 'images');
        return response()->json($gallery);
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        $gallery->images()->delete();
        return response('Gallery deleted');
        }
}