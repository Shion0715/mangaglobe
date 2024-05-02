let cropper;
let defaultImage = '/storage/public/avatar/user_default.jpg'; // デフォルトの画像のパスを設定します。

document.getElementById('avatar').addEventListener('change', function (e) {
    let file = e.target.files[0];

    // If no file was selected, remove the preview image and destroy the cropper
    if (!file) {
        let image = document.getElementById('avatar_preview');
        image.src = defaultImage; // デフォルトの画像を表示します。
        image.alt = 'Default image';

        if (cropper) {
            cropper.destroy();
            cropper = null;
        }

        // Reset the file input field
        e.target.value = null;

        // Reset the hidden input for the cropped image
        document.getElementById('cropped_image').value = '';

        return;
    }

    let reader = new FileReader();

    reader.onload = function (e) {
        // Remove the original image preview
        let oldImage = document.getElementById('original_avatar_image');
        if (oldImage) {
            oldImage.parentNode.removeChild(oldImage);
        }

        let image = document.getElementById('avatar_preview');
        image.src = e.target.result;

        if (cropper) {
            cropper.destroy();
        }

        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
            crop: function (e) {
                let croppedImageDataUrl = cropper.getCroppedCanvas({
                    width: 160,
                    height: 90
                }).toDataURL();
                document.getElementById('cropped_image').value = croppedImageDataUrl;
            }
        });
    };

    reader.readAsDataURL(file);
});