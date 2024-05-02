<h1>アップロードテスト</h1>

<form method="POST" action="{{route('upload.save')}}" enctype="multipart/form-data">
  @csrf
  <input type="file" name="file" />
  <button type="submit">送信する</button>
</form>