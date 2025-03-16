$(document).ready(function() {
    const apiKey = '6cf96494d2d88470ef456aa5cf938cf2';  // Replace with your actual TMDb API key

    // Fetch trending movies for today
    $.ajax({
        url: `https://api.themoviedb.org/3/trending/movie/day?api_key=${apiKey}`,
        dataType: 'json',
        success: function(data) {
            if (data.results && data.results.length > 0) {
                // Pass the movie data to the container as JSON
                $('#trending-movie-container').data('movies', data.results);
            }
            else {
                $('#trending-movie-container').html('<p>No trending movies found.</p>');
            }
        },
        error: function() {
            $('#trending-movie-container').html('<p>Error fetching movie data.</p>');
        }
    });
});
