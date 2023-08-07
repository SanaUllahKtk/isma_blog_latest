<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\FileUploader;
use App\DataTables\BlogDataTable;
use App\DataTables\EventDataTable;
use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB ;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function home()
    {
        return view('content.dashboard');
    }
    public function blogs(BlogDataTable $table)
    {
        
        $pageConfigs = ['has_table' => true];
        $table->with('blogs', 'true');

        // if(isset($_GET['columns'])){
        //     dd($_GET);
        // }
        return $table->render('content.tables.blogs', compact('pageConfigs'));
    }
    public function feeds(BlogDataTable $table)
    {
        $pageConfigs = ['has_table' => true];
        $table->with('blogs', 'false');
        return $table->render('content.tables.blogs', compact('pageConfigs'));
    }



    public function allblogs(){
       $blogs = Blog::orderBy('created_at', 'DESC')->get();
       return view('site.all-blog', compact('blogs'));
    }




    public function addBlog()
    {
        return view('content.forms.add-blog');
    }

    public function storeBlog(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        Blog::create([
            'title' => $request->title,
            'description' => $request->content,
            'slug' => Str::slug($request->title),
            'image' => FileUploader::uploadFile($request->image, 'images/blogs'),
            'user_id' => auth()->user()->id,
            'status' => 'active',
        ]);

        return response()->json([
            'message' => 'Blog created successfully',
            'status' => 'success',
            'reload' => true,
        ]);
    }
    public function deleteBlog($id)
    {

        $blog = Blog::findOrFail($id);

        $blog->delete();

        return response()->json([
            'message' => 'Blog deleted successfully',
            'status' => 'success',
            'table' => 'blog-table'
        ]);
    }
    public function blogStatus(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        $blog = Blog::find($request->id);
        $blog->status = $request->status;
        $blog->save();

        //save notification 
        $data = [
            'user_id' => $blog->user_id,
            'title' => 'Blog Approved',
            'message' => $request->title.' blog approved by admin.',
            'status' => 'success'
        ];
        $this->save_notifcation($data);

        return response()->json([
            'message' => 'Blog status updated successfully',
            'status' => 'success',
            'table' => 'blog-table'
        ]);
    }


    public function save_notifcation($data){

        if(!empty($data)){
            $notification = new Notification();
            $notification->user_id = $data['user_id'];
            $notification->title = $data['title'];
            $notification->message = $data['message'];
            $notification->seen = '0';
            $notification->status = $data['status'];
            $notification->save();
        }
        return true;
    }


    public function addEvent()
    {
        return view('content.forms.add-event');
    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $event = Event::create([
            'name' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                $event->images()->create([
                    'image' => FileUploader::uploadFile($image, 'images/events'),
                ]);
            }
        }

        return response()->json([
            'message' => 'Event created successfully',
            'status' => 'success',
            'reload' => true,
        ]);
    }


    public function events(EventDataTable $table)
    {
        $pageConfigs = ['has_table' => true];
        return $table->render('content.tables.events', compact('pageConfigs'));
    }
    
    public function form()
    {
        $form = DB::table('form')->first();
        return view('content.forms.add-form', compact('form'));
    }
    
     public function storeForm(Request $request)
    {
        $request->validate([
            'form' => 'required'
        ]);
        
         $form = DB::table('form')->first();
         if($form ){
         $form->path =  FileUploader::uploadFile($request->form, 'images/form');
         }else{
             DB::table('form')->insert([
                    'path' => FileUploader::uploadFile($request->form, 'images/form')
                 ]);
         }
         return response([
             'message' => 'form added successfully'
             ]);
        
    }
    
    
    
    
    
    
}
