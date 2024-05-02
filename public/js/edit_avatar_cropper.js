$(document).ready(function () {
    var $avatarInput = $('#avatar');
    var $croppedAvatarInput = $('#cropped_avatar');
    var cropper;

    $avatarInput.on('change', function (e) {
        var files = e.target.files;

        if (files && files.length > 0) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var image = new Image();
                image.src = e.target.result;

                if (cropper) {
                    cropper.destroy();
                }

                image.onload = function () {
                    var cropper = new Cropper(image, {
                        aspectRatio: 1,
                        crop: function (event) {
                            var canvas = this.cropper.getCroppedCanvas();
                            var dataUrl = canvas.toDataURL('image/png');
                            document.getElementById('cropped_avatar').value = dataUrl;
                        }
                    });
                };

                $('#current_avatar').replaceWith(image);
            };

            reader.readAsDataURL(files[0]);
        }
    });
});