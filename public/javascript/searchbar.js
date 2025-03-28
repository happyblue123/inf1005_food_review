$(document).ready(function() {
    // TMDb API key (replace with your own)
    const apiKey = '6cf96494d2d88470ef456aa5cf938cf2'; // Replace with your TMDb API key

    // Autocomplete function for movie search
    $('.movie-search').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: `https://api.themoviedb.org/3/search/movie`,
                dataType: 'json',
                data: {
                    api_key: apiKey,
                    query: request.term,
                    language: 'en-US'
                },
                success: function(data) {
                    response($.map(data.results, function(item) {
                        return {
                            label: item.title,
                            value: item.title,
                            id: item.id
                        };
                    }));
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            // Redirect to search page with the selected movie name in the URL
            const movieName = ui.item.value; // Get the selected movie name
            window.location.href = `/search/query/${encodeURIComponent(movieName)}`; // Redirect to /search/<movie_name>
        }
    });

    // Detect Enter key press in the search field
    $('.movie-search').on('keydown', function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent default action (like form submission)
            const searchTerm = $(this).val(); // Get the value of the input field
            if (searchTerm.length >= 2) {
                // Redirect to search page with the movie name
                window.location.href = `/search/query/${encodeURIComponent(searchTerm)}`;
            }
        }
    });
});
