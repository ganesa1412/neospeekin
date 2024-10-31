<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
// use Top4\Images\Traits\ImageSync;
use Illuminate\View\View;
use Top4\Article\Models\Article;
use Top4\Article\Models\ArticleCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendGuestPost;
use App\Mail\SendCompletePayment;

class GuestPostController extends Controller
{
    function index(){
        $data['category'] = ArticleCategory::orderBy('page_title', 'asc')->get();
        return view('front.contribution-guidelines.index', $data);
    }
    function submit(Request $req){
        $article = new Article();
        $article->author_url = $req->email;
        $article->title = $req->title;
        $article->seo_title = $req->title;
        $article->cat_1_id = $req->category_id;
        $article->friendly_url = Str::slug($req->title);
        $article->author = "Top4 Team";
        $article->publication_date = date("Y-m-d");
        $article->abstract = $req->abstract;
        $article->seo_abstract = $req->abstract;
        $article->keywords = str_replace(', ', ' || ', $req->keywords);
        $article->seo_keywords = $req->keywords;
        $article->fulltextsearch_keyword = $req->title.' '.$req->abstract;
        $article->content = $req->content;
        $article->status = 'P';

        if ($req->hasFile('feature_image') && $req->file('feature_image')->isValid()) {
            $filename = $req->file('feature_image')->getClientOriginalName();
            
            try {
                Storage::disk('do')->putFileAs('articles', $req->file('feature_image'), $filename);

                $article->image_attribute = env('ASSET_URL').'/articles/'.$filename;
                $article->save();

                try{
                    Mail::to('michael@top4.com.au')
                    ->bcc(['marketing@top4.com.au','tasha@top4.com.au'])
                    ->send(new SendGuestPost(array(
                        'email' => $req->email,
                        'title' => $req->title,
                        'dofollow_link_1' => $req->dofollow_link_1,
                        'anchor_text_1' => $req->anchor_text_1,
                        'dofollow_link_2' => $req->dofollow_link_2,
                        'anchor_text_2' => $req->anchor_text_2,
                      )));
                }catch(\Exception $e){
                    return response()->json(['error' => 'Email could not be sent. '], 500);
                }
                
                try{
                    Mail::to($req->email)
                    ->send(new SendCompletePayment(array(
                        'email' => $req->email,
                      )));
                }catch(\Exception $e){
                    return response()->json(['error' => 'Email could not be sent. '], 500);
                }

                return redirect('https://buy.stripe.com/7sIdTVbrQ3YnbQseVb');
            } catch (\Exception $e) {
                return response()->json(['error' => 'File could not be saved.'], 500);
            }
        } else {
            return response()->json(['error' => 'Invalid file.'], 400);
        }

        // $article->save();
        // return redirect('https://buy.stripe.com/7sIdTVbrQ3YnbQseVb');
    }
}