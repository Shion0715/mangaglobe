document.addEventListener('DOMContentLoaded', (event) => {
    let cropper;
    let coverImageElement = document.getElementById('cover_image');

    if (coverImageElement) {
        coverImageElement.addEventListener('change', function(e) {
            let file = e.target.files[0];

            // If no file was selected, remove the preview image and destroy the cropper
            if (!file) {
                let image = document.getElementById('cover_image_preview');
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
                let oldImage = document.getElementById('original_cover_image');
                if (oldImage) {
                    oldImage.parentNode.removeChild(oldImage);
                }

                let image = document.getElementById('cover_image_preview');
                image.src = e.target.result;

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(image, {
                    aspectRatio: 2 / 3,
                    viewMode: 3,
                    crop: function(e) {
                        let croppedImageDataUrl = cropper.getCroppedCanvas({
                            width: 1024,
                            height: 768,
                        }).toDataURL();
                        document.getElementById('cropped_image').value = croppedImageDataUrl;
                    }
                });
            };

            reader.readAsDataURL(file);
        });
    } else {
        console.error("Element with id 'cover_image' not found");
    }
});