<div class="flex justify-between mt-5 mb-10 px-4 sm:px-0 max-w-full sm:max-w-3xl mx-auto">
    <div class="w-full sm:w-auto text-center">
        <a href="{{ route('ranking.all') }}" class="dropdown-link" id="top-link" style="{{ request()->routeIs('ranking.all') ? 'font-weight: bold; color: #000; background-color: transparent;' : 'font-weight: normal; color: #6b7280; background-color: transparent;' }}">
            <h2 id="top-button" class="text-center text-xl leading-tight">
                All
            </h2>
        </a>
    </div>

    <div class="w-full sm:w-auto text-center">
        <a href="{{ route('ranking.daily') }}" class="dropdown-link" id="favorite-link" style="{{ request()->routeIs('ranking.daily') ? 'font-weight: bold; color: #000; background-color: transparent;' : 'font-weight: normal; color: #6b7280; background-color: transparent;' }}">
            <h2 id="favorite-button" class="text-center text-xl leading-tight">
                Daily
            </h2>
        </a>
    </div>

    <div class="w-full sm:w-auto text-center">
        <a href="{{ route('ranking.weekly') }}" class="dropdown-link" id="history-link" style="{{ request()->routeIs('ranking.weekly') ? 'font-weight: bold; color: #000; background-color: transparent;' : 'font-weight: normal; color: #6b7280; background-color: transparent;' }}">
            <h2 id="history-button" class="text-center text-xl leading-tight">
                Weekly
            </h2>
        </a>
    </div>

    <div class="w-full sm:w-auto text-center">
        <a href="{{ route('ranking.monthly') }}" class="dropdown-link" id="history-link" style="{{ request()->routeIs('ranking.monthly') ? 'font-weight: bold; color: #000; background-color: transparent;' : 'font-weight: normal; color: #6b7280; background-color: transparent;' }}">
            <h2 id="history-button" class="text-center text-xl leading-tight">
                Monthly
            </h2>
        </a>
    </div>
</div>

<script>
    // ページが読み込まれたときに実行
    window.addEventListener('DOMContentLoaded', function() {
        // 現在のページのリンクまたはボタンを太字にする
        setActiveLinkOrButton();
    });

    // リンクまたはボタンがクリックされたときに実行
    document.querySelectorAll('.dropdown-link, .dropdown-button').forEach(item => {
        item.addEventListener('click', function() {
            // すべてのリンクとボタンのスタイルをリセット
            document.querySelectorAll('.dropdown-link, .dropdown-button').forEach(item => {
                item.style.fontWeight = 'normal';
                item.style.color = '#6b7280'; // 通常のテキストの色
                item.style.backgroundColor = 'transparent'; // 背景色を透明にする
            });
            // クリックされたリンクまたはボタンを太字にする
            this.style.fontWeight = 'bold';
            this.style.color = '#000'; // 選択されたリンクの色
        });
    });

    // 現在のページのリンクまたはボタンを太字にする関数
    function setActiveLinkOrButton() {
        // 現在のURLを取得
        var currentUrl = window.location.pathname;
        // リンクまたはボタンのIDに基づいて太字スタイルを適用
        if (currentUrl.includes("top")) {
            document.getElementById('top-link').style.fontWeight = 'bold';
            document.getElementById('top-link').style.color = '#000';
            document.getElementById('top-button').style.fontWeight = 'bold';
        } else if (currentUrl.includes("favorite")) {
            document.getElementById('favorite-link').style.fontWeight = 'bold';
            document.getElementById('favorite-link').style.color = '#000';
            document.getElementById('favorite-button').style.fontWeight = 'bold';
        } else if (currentUrl.includes("history")) {
            document.getElementById('history-link').style.fontWeight = 'bold';
            document.getElementById('history-link').style.color = '#000';
            document.getElementById('history-button').style.fontWeight = 'bold';
        }
    }
</script>