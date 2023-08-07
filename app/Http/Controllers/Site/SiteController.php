<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\BlogView;
use App\Models\CommitteeMember;
use App\Models\Event;
use App\Models\Member;
use App\Models\Slider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function home()
    {
        $members = Member::all();
        $sliders = Slider::all();
        return view('site.index', compact('members', 'sliders'));
    }

    public function presidentsMessage()
    {
        return view('site.presidents-message');
    }

    public function contactUs()
    {
        return view('site.contact-us');
    }

    public function blogs(Request $request)
    {

        $request->validate([
            'q' => 'nullable|string|max:255',
        ]);


        // $blogs = Blog::active()
        //     ->when($request->q, function ($query) use ($request) {
        //         $query->where('title', 'like', '%' . $request->q . '%');
        //     })

        //     ->whereHas('user', function ($query) {
        //         $query->where('isAdmin', '1');
        //     })

        //     ->with(['user' => function ($query) {
        //         $query->select('id', 'name');
        //     }])
        //     ->get();


        $blogs = Blog::select('blogs.*')
            ->selectRaw('COUNT(DISTINCT blog_likes.id) AS bloglikes')
            ->selectRaw('COUNT(DISTINCT blog_comments.id) AS blogcomments')
            ->selectRaw('COUNT(DISTINCT blog_shares.id) AS blogshares')
            ->selectRaw('COUNT(DISTINCT blog_views.id) AS blogviews')
            ->leftJoin('blog_likes', 'blogs.id', '=', 'blog_likes.blog_id')
            ->leftJoin('blog_comments', 'blogs.id', '=', 'blog_comments.blog_id')
            ->leftJoin('blog_shares', 'blogs.id', '=', 'blog_shares.blog_id')
            ->leftJoin('blog_views', 'blogs.id', '=', 'blog_views.blog_id')
            ->where(['blogs.status' => 'active'])
            ->groupBy('blogs.id')
            ->orderBy('blogs.created_at', 'Desc')
            ->get();
       
        $users = User::get()->pluck('name', 'id')->toArray();
        return view('site.blogs', compact('blogs', 'users'));
    }


    public function blogDetails(Request $request, $id)
    {
        // $blog = Blog::where('slug', $id)
        //     ->whereHas('user', function ($query) {
        //         $query->where('isAdmin', '1');
        //     })
        //     ->firstOrFail();

        // $blog->load([
        //     'user' => function ($query) {
        //         $query->select('id', 'name');
        //     }
        // ]);

        // $comments = BlogComment::where('blog_id', $blog->id)
        //     ->where('parent_id', null)
        //     ->with(['user' => function ($query) {
        //         $query->select('id', 'name');
        //     }])
        //     ->limit(2)
        //     ->get();

        // $related = Blog::inRandomOrder()
        //     ->whereHas('user', function ($query) {
        //         $query->where('isAdmin', '1');
        //     })
        //     ->where('id', '!=', $blog->id)
        //     ->limit(2)
        //     ->get();


        $blog = Blog::findOrFail($id);
        $comments = BlogComment::where(['blog_id' => $id])->limit(2)->get();

        $related = Blog::inRandomOrder()
            ->where('id', '!=', $blog->id)
            ->limit(2)
            ->get();

        $from = "blog";



        //inserting views
        $ipAddress = $request->ip();
        $views = BlogView::where(['ip_address' => $ipAddress, 'blog_id' => $id])->first();
        if(!$views){
            $new_view = new BlogView();
            $new_view->blog_id = $id;
            $new_view->ip_address = $ipAddress;
            $new_view->save();
        }   

        return view('site.blog-details', compact('blog', 'related', 'comments', 'from'));
    }



    public function feeds(Request $request)
    {

        $request->validate([
            'q' => 'nullable|string|max:255',
        ]);


        $blogs = Blog::active()
            ->when($request->q, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->q . '%');
            })

            ->whereHas('user', function ($query) {
                $query->where('isAdmin', '0');
            })

            ->with(['user' => function ($query) {
                $query->select('id', 'name');
            }])
            ->get();
        return view('site.feeds', compact('blogs'));
    }


    public function feedDetails($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->whereHas('user', function ($query) {
                $query->where('isAdmin', '0');
            })
            ->firstOrFail();

        $blog->load([
            'user' => function ($query) {
                $query->select('id', 'name');
            }
        ]);

        $comments = BlogComment::where('blog_id', $blog->id)
            ->where('parent_id', null)
            ->with(['user' => function ($query) {
                $query->select('id', 'name');
            }])
            ->limit(2)
            ->get();

        $related = Blog::inRandomOrder()
            ->whereHas('user', function ($query) {
                $query->where('isAdmin', '0');
            })
            ->where('id', '!=', $blog->id)
            ->limit(2)
            ->get();
        $from = 'feed';

        return view('site.blog-details', compact('blog', 'related', 'comments', 'from'));
    }

    public function aboutUs()
    {
        return view('site.about-us');
    }


    public function events()
    {
        return view('site.events');
    }


    public function eventByDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        if (!$request->ajax()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $events =  Event::whereDate('start_date', '<=', Carbon::parse($request->date)->addDays(1))
            ->whereDate('end_date', '>=', Carbon::parse($request->date)->addDays(1))
            ->get();

        return response()->json($events);
    }


    public function eventDetails($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        return view('site.event-details', compact('event'));
    }

    public function committeeMembers()
    {
        $members = CommitteeMember::all();

        return view('site.committee-members', compact('members'));
    }

    public function board()
    {
        return view('site.board');
    }
}
