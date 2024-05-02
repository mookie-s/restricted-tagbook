<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Tag;
use App\Models\Note;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $user_id = Auth::id();

        // ■■■■■■■ 以下、検索窓の選択肢準備用 ■■■■■■■
        //過去にいったんタグを削除した後、再び同名タグが作成できる仕様のため
        $tags = Tag::withTrashed()->where('user_id', $user_id)->groupBy('tagname')->get('tagname');

        $normal_query = Note::query();

        // 削除分も含め一番最初に書いたノートの年を取得
        $first_active_note = $normal_query->withTrashed()->where('user_id', $user_id)->where('break', 0)->first();
        $start_year = $first_active_note->created_at->format('Y');

        // 削除分も含め一番最後に書いたノートの年を取得
        $latest_active_note = $normal_query->withTrashed()->where('user_id', $user_id)->where('break', 0)->orderBy('id', 'desc')->first();
        $last_year = $latest_active_note->created_at->format('Y');

        // 年指定の選択に使うため、最初の年～最後の年までを配列データにする
        $years = [];
        for ($i=$start_year; $i<=$last_year; $i++) {
            array_push($years, $i);
        }

        // 同じく月指定の選択用
        $months = [];
        for ($i=1; $i<=12; $i++) {
            array_push($months, $i);
        }


        // ■■■■■■■　以下、検索データ取得用 ■■■■■■■
        $search_tagname = $request->tagname;
        $search_year = $request->year;
        $search_month = $request->month;
        $search_keyword = $request->keyword;
        $search_query = Note::query();

        // 過去に（論理）削除したタグのノートも含めた全ノートを検索対象にする
        $search_query->withTrashed()->with('tag', function ($q) {
                $q->withTrashed();
            })->where('user_id', $user_id)->orderBy('id', 'desc');

        if (!empty($search_tagname)) {
            // 過去に削除した同名タグが新規で再作成できる仕様のため、
            // （tag_idではなく）tagnameで検索
            $search_query->WhereHas('tag', function ($q) use ($search_tagname) {
                    $q->where('tagname', $search_tagname);
                });
        }

        if (!empty($search_year)) {
            $search_query->whereYear('created_at' , $search_year);
        }

        if (!empty($search_month)) {
            $search_query->whereMonth('created_at' , $search_month);
        }

        if (!empty($search_keyword)) {
            $search_query->where('title' , 'Like', "%{$search_keyword}%")
                ->orWhere('story', 'Like', "%{$search_keyword}%")
                ->orWhereHas('tag', function ($q) use ($search_keyword) {
                    $q->where('tagname', 'Like', "%{$search_keyword}%");
                })
                ->orWhereHas('tag', function ($q) use ($search_keyword) {
                    $q->where('abbreviation', 'Like', "%{$search_keyword}%");
                });
        }

        // 検索キーを何も入れない検索は、何も表示させない
        if (empty($search_tagname) && empty($search_year) && empty($search_month) && empty($search_keyword)) {
            $searched_notes = [];
        } else {
            $searched_notes = $search_query->get();
        }

        return view('/search', compact('tags' ,'years', 'months', 'search_tagname', 'search_year', 'search_month', 'search_keyword', 'searched_notes'));
    }
}
