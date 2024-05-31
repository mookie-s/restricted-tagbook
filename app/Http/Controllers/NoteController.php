<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\NotePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Note;
use App\Models\Book;
use App\Helpers\ImageHelper;

class NoteController extends Controller
{
    public function index(): View
    {
        $user_id = Auth::id();
        $tags = Tag::where('user_id', $user_id)->get();

        // 中断ノート
        $break_note = Note::where('user_id', $user_id)->where('break', 1)->first();

        // TODO 以下、選択できるタグ名を制限するアルゴリズム（より良い組み方があるかも？）
        // １）■■■start■■■ 中断保存分含めた未昇格ノートが100件ある（＝未ブック化）タグのid取得アルゴリズム
        $un_promoted_notes = Note::where('user_id', $user_id)->where('promoted', 0)->get();
        $un_promoted_notes_per_tags = [];
        foreach ($tags as $tag) {
                array_push($un_promoted_notes_per_tags, [$tag->id => $un_promoted_notes->where('tag_id', $tag->id)->count()]);
        }

        $array_mapping = [];
        foreach ($un_promoted_notes_per_tags as $un_promoted_notes_per_tag) {
            array_push($array_mapping, [
                'tag_id' => array_keys($un_promoted_notes_per_tag)[0],
                'notes_count_per_tag' => array_values($un_promoted_notes_per_tag)[0],
            ]);
        }

        $notes100_tag_ids = [];
        foreach ($array_mapping as $row) {
            if ($row['notes_count_per_tag'] == 100) {
                array_push($notes100_tag_ids, $row['tag_id']);
            }
        }
        // ■■end■■（中断保存分含めた未昇格ノートが100件ある（＝未ブック化）タグのid取得アルゴリズム）

        // ２）■■■start■■■ 本日分投稿済みノートがあるタグのid取得アルゴリズム
        $today = Carbon::today();
        $today_notes = Note::where('user_id', $user_id)->whereDate('created_at', $today)->orderBy('tag_id', 'asc')->get();

        $tag_ids = [];
        foreach ($tags as $tag) {
            array_push($tag_ids, $tag->id);
        }

        $finished_tag_ids = [];
        foreach ($today_notes as $today_note) {
            array_push($finished_tag_ids, $today_note->tag_id);
        }
        // ■■■end■■■（本日分投稿済みノートがあるタグのid取得アルゴリズム）

        // すべてのタグid からアルゴリズム１）と２）のタグid を除外
        $unfinished_tag_ids = array_diff($tag_ids, $finished_tag_ids);
        $selectable_tag_ids = array_diff($unfinished_tag_ids, $notes100_tag_ids);

        return view('/note', compact('tags', 'selectable_tag_ids', 'break_note'));
    }

    public function store(NotePostRequest $request): RedirectResponse
    {
        $user_id = Auth::id();
        $tag_id = $request->tag_id;
        $tag = Tag::where('user_id', $user_id)->find($tag_id);
        $book = Book::where('user_id', $user_id)->where('cover', $tag->tagname)->first();

        $note = new Note();
        $note->user_id = $user_id;
        $note->tag_id = $tag_id;

        // 該当タグがすでに達人達成している場合は同名のブックへの紐づけを行う
        if ($tag->mastered == 1) {
            $note->book_id = $book->id;
        }

        if ($request->file('image')) {
            // 画像を保存 
            // ※パスの指定方法が本番・検証環境と異なるので注意
            $path = $request->file('image')->store('public/images');

            // 保存された画像の相対パスを取得
            // ※パスの指定方法が本番・検証環境と異なるので注意
            $relativePath = str_replace('public/', 'storage/', $path);

            // 幅のみ指定してリサイズ（高さはアスペクト比を維持して計算）
            ImageHelper::resizeImage($relativePath, $path,
                800, // 幅
                null, // 高さ
                function ($constraint) {
                    // 縦横比を保持したままにする
                    $constraint->aspectRatio();
                    // 小さい画像は大きくしない
                    $constraint->upsize();
                }
            );
            $note->image = $path;
        }
        $note->title = $request->title;
        $note->story = $request->story;

        $break_note_message = '';
        $new_note_message = '';
        if ($request->has('to_break')) {
            $note->break = 1;
            $break_note_message = 'ノートを中断保存しました';
        } else {
            $new_note_message = 'ノートを投稿しました';
        }
        // 該当タグがすでに達人達成している場合は作成ノートを最初から昇格させる
        if ($tag->mastered == 1) {
            $note->promoted = 1;
        }
        $note->save();

        return redirect('/home')->with('new_note_message', $new_note_message)->with('break_note_message', $break_note_message);
    }
}
