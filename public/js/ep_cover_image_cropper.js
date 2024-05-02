let cropper;

document.getElementById('ep_cover_image').addEventListener('change', function(e) {
    let file = e.target.files[0];

    // If no file was selected, remove the preview image and destroy the cropper
    if (!file) {
        let image = document.getElementById('ep_cover_image_preview');
        image.src = '';
        image.alt = '';

        if (cropper) {
            cropper.destroy();
            cropper = null;
        }

        return;
    }

    let reader = new FileReader();

    reader.onload = function(e) {
        // Remove the original image preview
        let oldImage = document.getElementById('original_ep_cover_image');
        if (oldImage) {
            oldImage.parentNode.removeChild(oldImage);
        }

        let image = document.getElementById('ep_cover_image_preview');
        image.src = e.target.result;

        if (cropper) {
            cropper.destroy();
        }

        cropper = new Cropper(image, {
            aspectRatio: 2 / 3,
            viewMode: 3,
            crop: function(e) {
                let croppedImageDataUrl = cropper.getCroppedCanvas({
                    width: 160,
                }).toDataURL();
        
                // Set the cropped image data to a hidden input
                document.getElementById('cropped_ep_cover_image').value = croppedImageDataUrl;
            }
        });
    };

    reader.readAsDataURL(file);
});