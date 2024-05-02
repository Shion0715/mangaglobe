<h1>アップロード完了</h1>

<p>無事アップロードを行いました。</p>
<p>アップロードしたパスは{{$filePath}}です。</p>

<h2>今あげたファイルをダウンロード</h2>
<p>ダウンロードしたい時はこちらをクリックしてください。</p>

<form method="GET" action="{{route('upload.download')}}" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="filePath" value="{{$filePath}}" />
  <button type="submit">ダウンロード</button>
</form>

<a href="{{route('upload')}}">戻る</a>