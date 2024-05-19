<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\NotePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Tag;
use App\Models\Note;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $user_id = Auth::id();
        $years = [];
        $months = [];

        // ■■■■■■■ 以下、検索窓の選択肢準備用 ■■■■■■■
        $tags = Tag::where('user_id', $user_id)->get();

        // 一番最初に書いたノートの年を取得
        $first_active_note = Note::where('user_id', $user_id)->where('break', 0)->first();
        if ($first_active_note) {
            $start_year = $first_active_note->created_at->format('Y');

            // 一番最後に書いたノートの年を取得
            $latest_active_note = Note::where('user_id', $user_id)->where('break', 0)->orderBy('id', 'desc')->first();
            $last_year = $latest_active_note->created_at->format('Y');

            // 年指定の選択に使うため、最初の年～最後の年までを配列データにする
            for ($i=$start_year; $i<=$last_year; $i++) {
                array_push($years, $i);
            }

            // 同じく月指定の選択用
            for ($i=1; $i<=12; $i++) {
                array_push($months, $i);
            }
        }


        // ■■■■■■■　以下、検索データ取得用 ■■■■■■■
        $search_tag_id = $request->tag_id;
        $search_year = $request->year;
        $search_month = $request->month;
        $search_keyword = $request->keyword;
        $query = Note::query();

        $search_tag = $tags->where('id', $search_tag_id)->first();
        $query->where('user_id', $user_id)->where('break', 0)->orderBy('id', 'desc');

        if (!empty($search_tag_id)) {
            $query->WhereHas('tag', function ($q) use ($search_tag_id) {
                    $q->where('id', $search_tag_id);
                });
        }

        if (!empty($search_year)) {
            $query->whereYear('created_at' , $search_year);
        }

        if (!empty($search_month)) {
            $query->whereMonth('created_at' , $search_month);
        }

        if (!empty($search_keyword)) {
            $query->where(function ($q) use ($search_keyword) {
                $q->where('title', 'like', "%{$search_keyword}%")
                    ->orWhere('story', 'like', "%{$search_keyword}%")
                    ->orWhereHas('tag', function ($q) use ($search_keyword) {
                            $q->where('tagname', 'Like', "%{$search_keyword}%");
                        })
                    ->orWhereHas('tag', function ($q) use ($search_keyword) {
                            $q->where('abbreviation', 'Like', "%{$search_keyword}%");
                        });
            });
        }

        // 検索フォーム空の場合の検索結果は何も表示させない
        if (empty($search_tag_id) && empty($search_year) && empty($search_month) && empty($search_keyword)) {
            $searched_notes = [];
        } else {
            // $searched_notes = $search_query->get();
            $searched_notes = $query->simplePaginate(100);
        }

        return view('/search', compact('tags' ,'years', 'months', 'search_tag', 'search_tag_id', 'search_year', 'search_month', 'search_keyword', 'searched_notes'));
    }

    public function edit_searched_note(Request $request): View
    {
        $search_tag_id = $request->search_tag_id;
        $search_year = $request->search_year;
        $search_month = $request->search_month;
        $search_keyword = $request->search_keyword;

        $user_id = Auth::id();
        $note_id = $request->note_id;
        $note = Note::find($note_id);

        // 中断ノート
        $break_note = Note::where('user_id', $user_id)->where('break', 1)->first();

        return view('/edit-searched-note', compact('search_tag_id','search_year', 'search_month', 'search_keyword', 'note', 'break_note'));
    }

    public function update_searched_note(NotePostRequest $request): RedirectResponse
    {
        $user_id = Auth::id();
        $note_id = $request->note_id;

        $note = Note::find($note_id);
        if ($request->file('image')) {
            $image_path = $request->file('image')->store('public/images');
            $note->image = $image_path;
        }
        $note->title = $request->title;
        $note->story = $request->story;

        $break_note_message = '';
        $update_note_message = '';
        if ($request->has('to_break')) {
            $note->break = 1;
            $break_note_message = 'ノートを中断保存しました';

            $search_tag_id = $request->search_tag_id;
            $search_tag = Tag::where('user_id', $user_id)->find($search_tag_id);
            $search_year = $request->search_year;
            $search_month = $request->search_month;
            $search_keyword = $request->search_keyword;
        } else {
            $update_note_message = 'ノートを更新しました';

            $search_tag_id = $request->search_tag_id;
            $search_tag = Tag::where('user_id', $user_id)->find($search_tag_id);
            $search_year = $request->search_year;
            $search_month = $request->search_month;
            $search_keyword = $request->search_keyword;
        }
        $note->save();

        return redirect('/search')->with('search_tag_id', $search_tag_id)->with('search_tag', $search_tag)->with('search_year', $search_year)->with('search_month', $search_month)->with('search_keyword', $search_keyword)->with('update_note_message', $update_note_message)->with('break_note_message', $break_note_message);
        // ->with('autoSubmit', true); // js設定で検索ボタンを自動で押すため
    }
}
