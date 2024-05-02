document.addEventListener('DOMContentLoaded', function () {
    var button = document.querySelector('#options-menu');
    var dropdown = button.parentElement.nextElementSibling;

    button.addEventListener('click', function (event) {
        event.stopPropagation();
        dropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', function () {
        dropdown.classList.add('hidden');
    });
});