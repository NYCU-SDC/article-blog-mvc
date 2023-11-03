function handleClick() {
    // Get the current URL and extract the "id" parameter from the query string
    const urlParams = new URLSearchParams(window.location.search);
    const articleId = urlParams.get('id');

    // Use the "fetch()" API to send a request with DELETE method
    fetch('https://4.216.116.11/article/' + articleId + '/delete', {
        method: 'DELETE'
    })
        .then(response => {
            // Check if the response status code is 204
            if (response.status === 204) {
                console.log("Article deleted successfully");
                // If the deletion is successful, redirect to the article list page
                window.location.href = `article_list.html`;
            } else {
                // If the response status code is not 204, try to parse and return JSON
                return response.json();
            }
        })
        .then(data => {
            if (data) {
                console.error('Error:', data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
