<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use App\Models\Note;

class CsvExportController extends Controller
{
    public function export(Request $request)
    {
        $delete_tag_id = $request->delete_tag_id;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // ヘッダー行の追加
        $sheet->setCellValue('A1', '■■■■■■■■■■■' . PHP_EOL);
        $sheet->setCellValue('B1', 'ノート作成日' . PHP_EOL);
        $sheet->setCellValue('C1', 'タイトル' . PHP_EOL);
        $sheet->setCellValue('D1', '内容' . PHP_EOL);
        $sheet->setCellValue('E1', '■■■■■■■■■■' . PHP_EOL);

        // データ行の追加
        $user_id = Auth::id();
        $notes = Note::where('user_id', $user_id)->where('tag_id', $delete_tag_id)->get();
        $rowNumber = 2;
        foreach ($notes as $note) {
            foreach ($note as $data) {
                $data = mb_convert_encoding($data, "SJIS", "UTF-8");
            }
            $sheet->setCellValue('A' . $rowNumber, '■■■■■■■■■■' . PHP_EOL);
            $sheet->setCellValue('B' . $rowNumber, '【ノート作成日】' . $note->created_at->isoFormat('YYYY/MM/DD (ddd)') . PHP_EOL);
            $sheet->setCellValue('C' . $rowNumber, '【タイトル】' . $note->title . PHP_EOL);
            $sheet->setCellValue('D' . $rowNumber, '【内容】' . PHP_EOL . $note->story . PHP_EOL);
            $sheet->setCellValue('E' . $rowNumber, '■■■■■■■■■■' . PHP_EOL);
            $rowNumber++;
        }

        // CSVファイルとして保存
        $writer = new Csv($spreadsheet);
        $fileName = 'notes.csv';
        $writer->save($fileName);

        // ダウンロード用のリンクを生成
        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}
