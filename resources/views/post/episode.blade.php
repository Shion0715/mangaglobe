<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" rel="stylesheet">
    <link href="{{ asset('downloads/images/style.css') }}" rel="stylesheet">
    <link href="{{ asset('downloads/comi_style.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        /** 入力ここから **/
        var imgtype = "png,jpg"; //画像の拡張子
        var title = "{{$episode->title}}"; //タイトル名
        var site = "{{ url('post/' . $post->id) }}";
        var copy = "{{$post->user->name}}"; //作者名
        var display = 0; //左ページ始まりは「0」、右ページ始まりは「1」
        /* *ここまで **/

        $(function() {
            $("title,h1").text(title);
            $(".o_button").attr("onClick", "location.href='" + site + "'");
            $(".copy").text(copy);
            @php
            $sorted_ep_images = $ep_images -> sortBy('number');
            @endphp

            @foreach($sorted_ep_images as $ep_image)
            $('#last_page').before('<div class="c_i"><div><img data-lazy="{{ $ep_image->image }}"></div></div>');
            @endforeach


            /**長すぎるからh1の方のタイトル改行したいって時var/コメントアウト解除して編集**/
            //$("h1").html("サンプル<br>サンプル");
        });
    </script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JL7M7D7P36"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-JL7M7D7P36');
    </script>
</head>

<body>
    <!--漫画表示ゾーンここから-->
    <div class="slider" dir="rtl">
        <div id="first_page"></div>
        <div id="last_page">
            <div class="last_page_in" dir="ltr">
                <div>
                    <!--最終ページフリー追加ゾーンここから-->


                    <!--最終ページフリー追加ゾーンここまで-->
                </div>
                <h1></h1>
                <small>Copyright &copy; <span class="copy"></span> All Rights Reserved</small>
                <!-- 最終ページにボタンを追加する場合は以下をコメントアウト解除して編集 -->

                <p>
                    <!-- 前のエピソードへのリンク -->
                    @if($episode->number > 1)
                    <a class="button" href="{{ route('episode.navigate', ['post' => $post->id, 'number' => $episode->number, 'direction' => 'prev']) }}">Pre Chapter</a>
                    @endif

                    <!-- 次のエピソードへのリンク -->
                    @if($nextEpisodeExists)
                    <a class="button" href="{{ route('episode.navigate', ['post' => $post->id, 'number' => $episode->number, 'direction' => 'next']) }}">Next Chapter</a>
                    @endif
                </p>

                <p>
                    <input type="button" value="Read again" class="button b_button">
                    <input type="button" value="Back to Website" class="button o_button orange">
                </p>

            </div>
        </div>
    </div>
    <!--漫画表示ゾーンここまで-->

    <!--メニューここから-->
    <div class="menu_box">
        <div class="menu_button">Menu</div>
        <div class="menu_show">
            <h1></h1>
            <small>Copyright &copy; <span class="copy"></span> All Rights Reserved</small>
            <!-- メニューにボタンを追加する場合は以下をコメントアウト解除して編集-->

            <p>
                <!-- 前のエピソードへのリンク -->
                @if($episode->number > 1)
                <a class="button" href="{{ route('episode.navigate', ['post' => $post->id, 'number' => $episode->number, 'direction' => 'prev']) }}">Pre Chapter</a>
                @else
                <a class="button" href="#" disabled>Pre Chapter</a>
                @endif
                <!-- 次のエピソードへのリンク -->
                @if($nextEpisodeExists)
                <a class="button" href="{{ route('episode.navigate', ['post' => $post->id, 'number' => $episode->number, 'direction' => 'next']) }}">Next Chapter</a>
                @else
                <a class="button" href="#" disabled>Next Chapter</a>
                @endif
            </p>

            <p>
                <input type="button" value="Help" class="button p_button">
                <input type="button" value="Full Screen" class="button g_button sp_none">
                <input type="button" value="Expansion" class="button z_button">
                <input type="button" value="Back to Website" class="button o_button orange">
            </p>
            <div class="slick-counter"><span class="current"></span> / <span class="total"></span></div>
            <div class="dots" dir="rtl"></div>
            <div class="menu_button close">close</div>
        </div>
    </div>
    <!--メニューここまで-->

    <!--操作ヘルプここから-->
    <div class="help">
        <div class="help_in">
            <div class="help_img"><img src="{{ asset('downloads/images/help.png') }}" width="300"></div>
            <p>【How to use】</p>
            <!--class="sp_none"でPC以外だと非表示・class="pc_none"でPCだと非表示-->
            <ul class="pc_none">
                <li>&#9312;Double tap the center<span>……Expansion</span></li>
                <li>&#9312;Flick center<span>……Next Page・Previous Page</span></li>
                <li>&#9313;Tap ends<span>……Next Page・Previous Page</span></li>
                <li>&#9314;Tap pager<span>……Go to the Page</span></li>
            </ul>
            <ul class="sp_none">
                <li>&#9312;Slide the center<span>……Next Page・Previous Page</span></li>
                <li>&#9313;Tap ends<span>……Next Page・Previous Page</span></li>
                <li>&#9314;Tap pager<span>……Go to the Page</span></li>
            </ul>
            <p class="sp_none">【Keyboard operation】</p>
            <ul class="sp_none">
                <li>←key……Next Page</li>
                <li>→key……Previous Page</li>
                <li>↓key……Show menu</li>
                <li>↑key……Expansion</li>
                <li>F11key……Full Screen</li>
            </ul>
        </div>
    </div>
    <!--操作ヘルプここまで-->

    <!--拡大モードここから-->
    <div class="zoomwrap"></div>
    <div class="zoom_reset z_button">
        <div class="zr_in">Stop Expansion</div>
    </div>
    <!--拡大モードここまで-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
    <script src="{{ asset('downloads/comic.js') }}"></script>

</body>

</html>