<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\NotePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Tag;
use App\Models\Note;
use App\Helpers\ImageHelper;

class HomeController extends Controller
{
    public function index(): View
    {
        $user_id = Auth::id();
        $tag_id = '';
        $tags = Tag::where('user_id', $user_id)->where('mastered', 0)->take(5)->get();
        $mastered_tags = Tag::where('user_id', $user_id)->where('mastered', 1)->take(6)->get();
        $notes = Note::where('user_id', $user_id)->where('break', 0)->orderBy('id', 'desc')->take(100)->get();

        return view('/home', compact('tag_id', 'tags', 'notes', 'mastered_tags'));
    }

    public function show(string $tag_id): View
    {
        $user_id = Auth::id();
        $get_tag = Tag::where('user_id', $user_id)->find($tag_id);
        $tags = Tag::where('user_id', $user_id)->where('mastered', 0)->take(5)->get();
        $mastered_tags = Tag::where('user_id', $user_id)->where('mastered', 1)->take(6)->get();
        $notes = Note::where('user_id', $user_id)->where('break', 0)->where('tag_id', $tag_id)->orderBy('id', 'desc')->take(100)->get();

        return view('/home', compact('tag_id', 'get_tag', 'tags', 'notes', 'mastered_tags'));
    }

    public function edit_note(Request $request): View
    {
        $user_id = Auth::id();
        $tag_id = $request->tag_id;
        $note_id = $request->note_id;
        $note = Note::find($note_id);

        // 中断ノート
        $break_note = Note::where('user_id', $user_id)->where('break', 1)->first();

        return view('/edit-note', compact('tag_id', 'note', 'break_note'));
    }

    public function update_note(NotePostRequest $request): RedirectResponse
    {
        $note_id = $request->note_id;
        $note = Note::find($note_id);

        if ($request->file('image')) {
            // 画像を保存
            $path = $request->file('image')->store('public/images');

            // 保存された画像のフルパスを取得
            $fullPath = storage_path('app/' . $path);

            // 幅のみ指定してリサイズ（高さはアスペクト比を維持して計算）
            ImageHelper::resizeImage($fullPath, $path,
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
        $update_note_message = '';
        if ($request->has('to_break')) {
            $note->break = 1;
            $break_note_message = 'ノートを中断保存しました';
            $tag_id = $request->tag_id;
            $url = route('tag.home', ['tag_id' => $tag_id]);
        } else {
            $update_note_message = 'ノートを更新しました';
            $tag_id = $request->tag_id;
            $url = route('tag.home', ['tag_id' => $tag_id]);
        }
        $note->save();

        return redirect($url)->with('tag_id', $tag_id)->with('update_note_message', $update_note_message)->with('break_note_message', $break_note_message);
    }
}
