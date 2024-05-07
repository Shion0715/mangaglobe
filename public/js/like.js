$(document).ready(function () {
    $('.like-btn').click(function () {
        var postId = $(this).data('postid');
        var likeCount = $(this).siblings('span');
        var isLiked = $(this).hasClass('text-red-500');

        if (!isLiked) {
            // いいねする
            $.ajax({
                url: '/posts/' + postId + '/like',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $(this).addClass('text-red-500 fas').removeClass('text-gray-500 far');
                    likeCount.addClass('text-red-500').text(response.likes_count);
                }.bind(this),
                error: function (xhr) {
                    alert('You need to log in.');
                }
            });
        } else {
            // いいねを解除する
            $.ajax({
                url: '/posts/' + postId + '/like',
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $(this).removeClass('text-red-500 fas').addClass('text-gray-500 far');
                    likeCount.removeClass('text-red-500').text(response.likes_count);
                }.bind(this),
                error: function (xhr) {
                    alert('You need to log in.');
                }
            });
        }
    });
});