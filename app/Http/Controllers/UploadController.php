<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
  public function index()
  {
    return view('upload.index');
  }

  public function save(Request $request)
  {

    if ($request->hasFile('file')) {
      $file = $request->file('file');

      // S3にファイルをアップロード
      $filePath = Storage::put("data", $file);

      return view('upload.complete', compact('filePath'));
    }
    return view('upload.index');
  }

  public function download(Request $request)
  {
    $filePath = $request->filePath;

    if (Storage::exists($filePath)) {
      $file = Storage::get($filePath);
      $fileName = basename($filePath);

      // ダウンロード処理
      return response()->streamDownload(function () use ($file) {
        echo $file;
      }, $fileName);
    } else {
      // TODO: エラー処理を適切にする。
      abort(404);
    }
  }
}