<?php

namespace App\Http\Controllers\Site;

use App\Models\BlogFavorite;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\FileUploader;
use App\DataTables\BlogDataTable;
use App\Http\Controllers\Controller;
use App\Models\BlogLike;
use App\Models\BlogShare;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function home()
    {
        $blogs = Blog::where(['user_id' => Auth()->user()->id])->get();

        $blogs = Blog::select('blogs.*')
            ->selectRaw('COUNT(DISTINCT blog_likes.id) AS bloglikes')
            ->selectRaw('COUNT(DISTINCT blog_comments.id) AS blogcomments')
            ->selectRaw('COUNT(DISTINCT blog_shares.id) AS blogshares')
            ->selectRaw('COUNT(DISTINCT blog_views.id) AS blogviews')
            ->leftJoin('blog_likes', 'blogs.id', '=', 'blog_likes.blog_id')
            ->leftJoin('blog_comments', 'blogs.id', '=', 'blog_comments.blog_id')
            ->leftJoin('blog_shares', 'blogs.id', '=', 'blog_shares.blog_id')
            ->leftJoin('blog_views', 'blogs.id', '=', 'blog_views.blog_id')
            ->where(['blogs.user_id' => auth()->user()->id])
            ->groupBy('blogs.id')
            ->orderBy('blogs.created_at', 'Desc')
            ->get();
        return view('site.dashboard.index', ['blogs' => $blogs]);
    }

    //Creating blog
    public function addFeed()
    {
        return view('site.dashboard.blog.create');
        //return view('content.forms.add-feed');
    }

    public function storeBlog(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        Blog::create([
            'title' => $this->cleanText($request->title),
            'description' => $this->cleanText($request->content),
            'slug' => Str::slug($request->title),
            'image' => FileUploader::uploadFile($request->image, 'images/blogs'),
            'user_id' => auth()->user()->id,
            'status' => 'pending',
        ]);

        //creating notfication for user and admin 
        $data = [
            'user_id' => auth()->user()->id,
            'title' => 'New Blog Created',
            'message' => $request->title.' sent to admin for approval.',
            'status' => 'success'
        ];
        $this->save_notifcation($data);

        $admin = User::where(['isAdmin' => '1'])->first();
        $data = [
            'user_id' => $admin->id,
            'title' => 'New Blog Created',
            'message' => $request->title.' blog created successfully and waiting for approval',
            'status' => 'success'
        ];
        $this->save_notifcation($data);


        $response = json_encode([
            'status' => 'success',
            'message' => 'Blog created successfully.'
        ]);
        
        return redirect()->route('dashboard.home')->with(['response' => $response]);
    }




    /**
     * Show the form for editing the Blog.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        return view('site.dashboard.blog.edit', compact('blog'));
    }


    /**
     * Update the specified blog.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $blog = Blog::findOrFail($id);

        // Validate the form data (e.g., title, content, etc.)
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            // Add other validation rules for your form fields
        ]);

        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            Storage::delete($blog->image);
            $blog->image = FileUploader::uploadFile($request->image, 'images/blogs');
        }

        $blog->title = $this->cleanText($request->title);
        $blog->description = $request->content;
        $blog->save();


        //creating notfication for user and admin 
        $data = [
            'user_id' => auth()->user()->id,
            'title' => 'Blog Updated',
            'message' => $blog->title.' updated successfully.',
            'status' => 'success'
        ];
        $this->save_notifcation($data);


        $response = json_encode([
            'status' => 'success',
            'message' => 'Blog updated successfully.'
        ]);
        return redirect()->route('dashboard.home')->with(['response' => $response]);
    }


    /**
     * Display the specified blog.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    
            $blog = Blog::select('blogs.*')
            ->selectRaw('COUNT(DISTINCT blog_likes.id) AS bloglikes')
            ->selectRaw('COUNT(DISTINCT blog_comments.id) AS blogcomments')
            ->selectRaw('COUNT(DISTINCT blog_shares.id) AS blogshares')
            ->selectRaw('COUNT(DISTINCT blog_views.id) AS blogviews')
            ->leftJoin('blog_likes', 'blogs.id', '=', 'blog_likes.blog_id')
            ->leftJoin('blog_comments', 'blogs.id', '=', 'blog_comments.blog_id')
            ->leftJoin('blog_shares', 'blogs.id', '=', 'blog_shares.blog_id')
            ->leftJoin('blog_views', 'blogs.id', '=', 'blog_views.blog_id')
            ->where('blogs.id',  $id)
            ->groupBy('blogs.id')
            ->first();

        return view('site.dashboard.blog.view', compact('blog'));
    }



    public function blogs(BlogDataTable $table)
    {
        $pageConfigs = ['has_table' => true];
        return $table->render('content.tables.blogs', compact('pageConfigs'));
    }

    public function profile()
    {
        $user = auth()->user();

        return view('site.dashboard.profile', compact('user'));
    }






    public function cleanText(string $string)
    {

        $string = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $string);
        $string = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', "", $string);
        $string = preg_replace('/<iframe\b[^>]*>(.*?)<\/iframe>/is', "", $string);
        $string = preg_replace('/<object\b[^>]*>(.*?)<\/object>/is', "", $string);
        $string = preg_replace('/<embed\b[^>]*>(.*?)<\/embed>/is', "", $string);
        $string = preg_replace('/<applet\b[^>]*>(.*?)<\/applet>/is', "", $string);

        //remove all special characters
        $string = preg_replace('/[^a-zA-Z0-9\s]/', '', $string);

        return $string;
    }


    public function deleteBlog($id)
    {




        $blog = Blog::findOrFail($id);

        if (auth()->user()->id !== $blog->user_id) {
            throw ValidationException::withMessages([
                'id' => 'You are not authorized to delete this blog',
            ]);
        }

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

        return response()->json([
            'message' => 'Blog status updated successfully',
            'status' => 'success',
            'table' => 'blog-table'
        ]);
    }


    public function sharedblogs()
    {
        $blogs = Blog::select(['blogs.*'])->leftjoin('blog_shares', 'blogs.id', '=', 'blog_shares.blog_id')
            ->where('blog_shares.shared_to', auth()->user()->id)
            ->get();
        $title = 'Shared Blogs';
        return view('site.dashboard.shared', compact('blogs', 'title'));
    }


    public function favoriteblogs()
    {
        $blogs = Blog::select(['blogs.*'])->join('blog_favorites', 'blogs.id', '=', 'blog_favorites.blog_id')
            ->where('blogs.user_id', auth()->user()->id)
            ->get();

        $title = 'Favorite Blogs';
        return view('site.dashboard.shared', compact('blogs', 'title'));
    }


    public function makeFavoriteBlog(Request $request)
    {

        if ($request->favorite == 'favorite') {
            $favorite = new BlogFavorite();
            $favorite->blog_id = $request->id;
            $favorite->user_id = auth()->user()->id;
            $favorite->created_at = date('Y-m-d H:i:s');
            $favorite->updated_at = date('Y-m-d H:i:s');
            $favorite->save();


            $blog = Blog::findOrFail($request->id);
            $data = [
                'user_id' => $blog->user_id,
                'title' => 'Blog Received Heart',
                'message' => auth()->user()->name.' favorite the '.$blog->title,
                'status' => 'success'
            ];
            $this->save_notifcation($data);

        } else {
            $is_exist = BlogFavorite::where(['blog_id' => $request->id, 'user_id' => auth()->user()->id])->first();
            if ($is_exist) {
                $is_exist->delete();
            }
        }
    }


    public function makeLikeBlog(Request $request)
    {


        if ($request->favorite == 'like') {
            $favorite = new BlogLike();
            $favorite->blog_id = $request->id;
            $favorite->user_id = auth()->user()->id;
            $favorite->created_at = date('Y-m-d H:i:s');
            $favorite->updated_at = date('Y-m-d H:i:s');
            $favorite->save();

            $blog = Blog::findOrFail($request->id);
            $data = [
                'user_id' => $blog->user_id,
                'title' => 'Blog Received Like',
                'message' => auth()->user()->name.' liked the '.$blog->title,
                'status' => 'success'
            ];
            $this->save_notifcation($data);
        } else {
            $is_exist = BlogLike::where(['blog_id' => $request->id, 'user_id' => auth()->user()->id])->first();
            if ($is_exist) {
                $is_exist->delete();
            }
        }


        $count = BlogLike::where(['blog_id' => $request->id])->count();
        return response()->json([
            'status' => 'success',
            'total_likes' => $count
        ]);

    }

    public function sharingBlog(Request $request)
    {
        $id = $request->id;
        $shared_to = $request->share_to;

        $is_exist = BlogShare::where(['blog_id' => $id, 'shared_by' => auth()->user()->id, 'shared_to' => $shared_to])->first();
        if(!$is_exist){
            $new_share = new BlogShare();
            $new_share->blog_id = $id;
            $new_share->shared_by = auth()->user()->id;
            $new_share->shared_to = $shared_to;
            $new_share->save();

            $blog = Blog::findOrFail($request->id);
            $data = [
                'user_id' => $blog->user_id,
                'title' => 'Blog Received Share',
                'message' => auth()->user()->name.' shared the '.$blog->title,
                'status' => 'success'
            ];
            $this->save_notifcation($data);



            $total_share = BlogShare::where(['blog_id' => $id])->count();
            return response()->json([
                'status' => 'success',
                'message' => 'Blog shared successfully',
                'total_share' => $total_share
            ]);

        }else{

            $total_share = BlogShare::where(['blog_id' => $id])->count();
            return response()->json([
                'status' => 'error',
                'message' => 'Blog already shared',
                'total_share' => $total_share
            ]);

        }

        
    }


    public function emailBlogs(){
        // $blogs = Blog::select('blogs.*')
        //     ->selectRaw('COUNT(DISTINCT blog_likes.id) AS bloglikes')
        //     ->selectRaw('COUNT(DISTINCT blog_comments.id) AS blogcomments')
        //     ->selectRaw('COUNT(DISTINCT blog_shares.id) AS blogshares')
        //     ->selectRaw('COUNT(DISTINCT blog_views.id) AS blogviews')
        //     ->leftJoin('blog_likes', 'blogs.id', '=', 'blog_likes.blog_id')
        //     ->leftJoin('blog_comments', 'blogs.id', '=', 'blog_comments.blog_id')
        //     ->leftJoin('blog_shares', 'blogs.id', '=', 'blog_shares.blog_id')
        //     ->leftJoin('blog_views', 'blogs.id', '=', 'blog_views.blog_id')
        //     ->where(['blogs.status' => 'active'])
        //     ->groupBy('blogs.id')
        //     ->orderBy('blogs.created_at', 'Desc')
        //     ->get();
        //$blogs = Blog::where(['status' => 'active'])->orderBy('created_at', 'DESC')->get();
        $blogs = Blog::select(['blogs.*'])->leftjoin('blog_shares', 'blogs.id', '=', 'blog_shares.blog_id')
            ->get();
        $user_emails = User::get()->pluck('email', 'id')->toArray();

       

        return view('site.dashboard.email-blogs', compact('blogs', 'user_emails'));   
    }

    public function sendingMail(Request $request){
        
        $validatedData = $request->validate([
            'to' => 'required|string|max:255',
            'subject' => 'required|string',
            'message' => 'required|string'
        ]);

        $senderEmail = auth()->user()->email;
        $receiverEmail = $request->to;
        $subject = $request->subject;
        $message = $request->message;

        // Mail::raw($message, function($email) use ($to, $subject) {
        //     $email->to($to);
        //     $email->subject($subject);
        // });

       
        Mail::to($receiverEmail)->send(new \App\Mail\WelcomeEmail($senderEmail, $receiverEmail, $subject, $message));

        $response = json_encode([
            'status' => 'success',
            'message' => 'Email sent successfully.'
        ]);
        return redirect()->route('dashboard.home')->with('response');

    }

    public function comment(Request $request)
    {
        $request->validate([
            'comment' => 'required|max:3000',
            'blog_id' => 'required|exists:blogs,id',
        ]);


        //check if three comments are already added by the user on the same blog
        $comments_count = BlogComment::where('user_id', auth()->user()->id)
            ->where('blog_id', $request->blog_id)
            ->where('created_at', '>=', now()->subMinutes(15))
            ->count();

        if ($comments_count >= 3) {
            throw ValidationException::withMessages([
                'comment' => 'You can add only 3 comments in 15 minutes',
            ]);
        }


        $comment =  BlogComment::create([
            'comment' => $request->comment,
            'blog_id' => $request->blog_id,
            'user_id' => auth()->user()->id,
            'status' => 'active',
        ]);

        $blog = Blog::findOrFail($request->id);
        $data = [
            'user_id' => $blog->user_id,
            'title' => 'Blog Received Comment',
            'message' => auth()->user()->name.' commented on your '.$blog->title,
            'status' => 'success'
        ];
        $this->save_notifcation($data);


        return response()->json([
            'message' => 'Comment added successfully',
            'status' => 'success',
            'comment' => $comment,
        ]);
    }

    public function deleteComment(Request $request)
    {
        $request->validate([
            'id' => 'required|int',
        ]);

        $comment = BlogComment::findOrFail($request->id);

        if ($comment->user_id != auth()->user()->id) {
            throw ValidationException::withMessages([
                'comment' => 'You can only delete your own comments',
            ]);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully',
            'status' => 'success',
        ]);
    }


    public function waitingForApproval()
    {
        return view('site.waiting-for-activation', ['user' => auth()->user()]);
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

    public function removeNotification(Request $request){
        // Find the notification by its ID
        $notification = Notification::find($request->id);

        if ($notification) {
            $notification->update(['seen' => '1']);

            $total_notification = Notification::where(['seen' => '0'])->count();
            return json_encode([
                'status' => 'success',
                'total_noti' => $total_notification
            ]);
        }
    }
}
