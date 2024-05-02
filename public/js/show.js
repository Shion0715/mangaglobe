const episodes = document.querySelectorAll('.episode-container');
const pageButtonsContainer = document.getElementById('pageButtons');
const prevButton = document.getElementById('prevButton');
const nextButton = document.getElementById('nextButton');
let currentIndex = 0;
const episodesPerPage = 7;

const showEpisodes = () => {
    episodes.forEach((episode, index) => {
        if (index >= currentIndex && index < currentIndex + episodesPerPage) {
            episode.style.display = 'block';
        } else {
            episode.style.display = 'none';
        }
    });
};

const createPageButton = (page) => {
    const button = document.createElement('button');
    button.textContent = page + 1;
    button.className = page === currentIndex / episodesPerPage ? 'current' : '';
    button.addEventListener('click', () => {
        currentIndex = page * episodesPerPage;
        showEpisodes();
        window.history.pushState({}, '', `?page=${page + 1}`);
    });
    return button;
};

// Get the page number from the URL parameters
const urlParams = new URLSearchParams(window.location.search);
const pageParam = urlParams.get('page');
if (pageParam) {
    currentIndex = (pageParam - 1) * episodesPerPage;
}

showEpisodes();