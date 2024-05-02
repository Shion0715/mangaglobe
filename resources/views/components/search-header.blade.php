<div class="flex justify-center space-x-5 sm:justify-start sm:ml-10 sm:space-x-7">
    <!-- タイトル検索ボタン -->
    <button id="titleButton" class="text-lg font-bold sm:text-3xl" data-url="{{ route('search.title') }}">Manga Title</button>
    <!-- 著者検索ボタン -->
    <button id="authorButton" class="text-lg font-bold sm:text-3xl" data-url="{{ route('search.author') }}">Author</button>
</div>

<script>
    window.addEventListener('DOMContentLoaded', function() {
        // 初期化
        setActiveButton('titleButton', 'authorButton');
    });

    // ボタンがクリックされたときの処理
    document.getElementById('titleButton').addEventListener('click', function() {
        setActiveButton('titleButton', 'authorButton');
        window.location.href = this.dataset.url;
    });

    document.getElementById('authorButton').addEventListener('click', function() {
        setActiveButton('authorButton', 'titleButton');
        window.location.href = this.dataset.url;
    });

    // アクティブなボタンと非アクティブなボタンを設定する関数
    function setActiveButton(activeButtonId, inactiveButtonId) {
        document.getElementById(activeButtonId).style.fontWeight = 'bold';
        document.getElementById(activeButtonId).style.color = '#000';
        document.getElementById(inactiveButtonId).style.fontWeight = 'normal';
        document.getElementById(inactiveButtonId).style.color = '#888';
    }
</script>