<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Helpers\FileUploader;
use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    public function index(SliderDataTable $table)
    {
        $pageConfigs = ['has_table' => true];

        return $table->render('content.tables.sliders', compact('pageConfigs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:512',
        ]);

        Slider::create([
            'title' => $request->name,
            'image' => FileUploader::uploadFile($request->image, 'images/sliders'),
        ]);


        return response()->json([
            'message' => 'Slider created successfully',
            'status' => 'success',
            'table' => 'slider-table'
        ]);
    }

    public function delete($id)
    {
        $slider = Slider::findOrFail($id);

        FileUploader::deleteFile($slider->image);

        $slider->delete();

        return response()->json([
            'message' => 'Slider deleted successfully',
            'status' => 'success',
            'table' => 'slider-table'
        ]);
    }
}
