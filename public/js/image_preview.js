$(function () {
    var fileArr = [];
    $("#images").change(function () {
        fileArr = [];
        $('#image_preview').html("");
        var total_file = document.getElementById("images").files;
        if (!total_file.length) return;
        for (var i = 0; i < total_file.length; i++) {
            if (total_file[i].size > 1048576) {
                return false;
            } else {
                fileArr.push(total_file[i]);
                $('#image_preview').append("<div class='img-div' id='img-div" + i + "'><span class='img-number'>" + (i + 1) + "</span><img src='" + URL.createObjectURL(total_file[i]) + "' class='img-responsive image img-thumbnail' title='" + total_file[i].name + "'><div class='middle'><button id='action-icon' value='img-div" + i + "' class='btn btn-danger' role='" + total_file[i].name + "'><i class='fa fa-trash'></i></button></div></div>");
            }
        }
    });

    // 画像削除処理
    $('body').on('click', '#action-icon', function (evt) {
        var divName = this.value;
        var fileName = $(this).attr('role');
        $(`#${divName}`).remove();

        for (var i = 0; i < fileArr.length; i++) {
            if (fileArr[i].name === fileName) {
                fileArr.splice(i, 1);
            }
        }

        // ページ番号の更新
        $('#image_preview .img-div').each(function (index) {
            $(this).find('.img-number').text(index + 1);
        });

        document.getElementById('images').files = FileListItem(fileArr);
        evt.preventDefault();
    });

    function FileListItem(file) {
        file = [].slice.call(Array.isArray(file) ? file : arguments)
        for (var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
        if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
        for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
        return b.files
    }

    // ドラッグアンドドロップによる画像の入れ替え
    $("#image_preview").sortable({
        update: function (event, ui) {
            var updatedFileArr = [];
            var imageOrder = [];
            $("#image_preview .img-div").each(function (index) {
                var fileName = $(this).find("button").attr("role");
                for (var i = 0; i < fileArr.length; i++) {
                    if (fileArr[i].name === fileName) {
                        updatedFileArr.push(fileArr[i]);
                        imageOrder.push(fileName); // 順序を保存
                        break;
                    }
                }
            });
            fileArr = updatedFileArr;
            document.getElementById('images').files = FileListItem(fileArr);

            // ページ番号の更新
            $("#image_preview .img-div").each(function (index) {
                $(this).find('.img-number').text(index + 1);
            });

            // 順序情報を隠しフィールドに設定
            $('#image_order').val(imageOrder.join(','));
        }
    });
});