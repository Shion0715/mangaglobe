function showWarning() {
    var episodeNumber = document.getElementById('episode_number').value;
    var currentEpisodeNumber = parseInt("{{ $episode_number }}");
    if (episodeNumber !== currentEpisodeNumber) {
        alert('Please be careful when changing the episode number. It can affect the order of the episodes.');
    }
}