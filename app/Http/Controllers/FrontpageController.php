<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Testimonial;
use App\Mail\SendMail;
use Mail;
use App\Property;
use App\Service;
use App\Slider;
use App\Post;
use App\SearchHistory;




class FrontpageController extends Controller
{
    
    public function index()
    {
        $sliders        = Slider::latest()->get();
        $properties     = Property::latest()->where('featured',1)->with('rating')->withCount('comments')->take(6)->get();
        $services       = Service::orderBy('service_order')->get();
        $testimonials   = Testimonial::latest()->get();
        $posts          = Post::latest()->where('status',1)->take(6)->get();

        return view('frontend.index', compact('sliders','properties','services','testimonials','posts'));
    }


    public function search(Request $request)
    {
        $city     = strtolower($request->city);
        $type     = $request->type;
        $purpose  = $request->purpose;
        $bedroom  = $request->bedroom;
        $bathroom = $request->bathroom;
        $minprice = $request->minprice;
        $maxprice = $request->maxprice;
        $minarea  = $request->minarea;
        $maxarea  = $request->maxarea;
        $featured = $request->featured;
        
        if (Auth::check() && $city !== null && $type !== null && $purpose !== null) {
            $userId = Auth::id();
            $featured = $request->featured == 'on' ? 1 : 0;
            SearchHistory::create([
                'user_id' => $userId,
                'city' => $city,
                'type' => $type,
                'purpose' => $purpose,
                'bedroom' => $bedroom,
                'bathroom' => $bathroom,
                'minprice' => $minprice,
                'maxprice' => $maxprice,
                'minarea' => $minarea,
                'maxarea' => $maxarea,
                'featured' => $featured,
            ]);
        }
        

        $properties = Property::latest()->withCount('comments')
                                ->when($city, function ($query, $city) {
                                    return $query->where('city', '=', $city);
                                })
                                ->when($type, function ($query, $type) {
                                    return $query->where('type', '=', $type);
                                })
                                ->when($purpose, function ($query, $purpose) {
                                    return $query->where('purpose', '=', $purpose);
                                })
                                ->when($bedroom, function ($query, $bedroom) {
                                    return $query->where('bedroom', '=', $bedroom);
                                })
                                ->when($bathroom, function ($query, $bathroom) {
                                    return $query->where('bathroom', '=', $bathroom);
                                })
                                ->when($minprice, function ($query, $minprice) {
                                    return $query->where('price', '>=', $minprice);
                                })
                                ->when($maxprice, function ($query, $maxprice) {
                                    return $query->where('price', '<=', $maxprice);
                                })
                                ->when($minarea, function ($query, $minarea) {
                                    return $query->where('area', '>=', $minarea);
                                })
                                ->when($maxarea, function ($query, $maxarea) {
                                    return $query->where('area', '<=', $maxarea);
                                })
                                ->when($featured, function ($query, $featured) {
                                    return $query->where('featured', '=', 1);
                                })
                                ->paginate(10); 
                                
        return view('pages.search', compact('properties'));
    }

}
