// Get the current URL and extract the "id" parameter from the query string
const urlParams = new URLSearchParams(window.location.search);
const articleId = urlParams.get('id');

// Use the "fetch()" API to send a request
fetch('https://4.216.116.11/article/'+articleId)
    .then(response => response.json()) // Parse JSON data
    .then(data => {
        console.log(data); // 印出接收到的數據
        
        // Create a new HTML element
        var div = document.createElement('div');
        div.classList.add("border", "border-1", "rounded-3", "p-3", "shadow", "bg-body", "rounded");

        div.innerHTML = 
        '<h1 class="text-break">' + data.title +'</h1>' +
        '<h6 class="text-muted">Create at: ' + data.created_at +'</h6>' +
        '<h6 class="text-muted">Latest Update: ' + data.updated_at +'</h6>' +
        '<hr>' +
        '<h5 class="text-break">' + data.content + '</h5>';
        // Append the new element to the <div> element with ID "data-container"
        document.getElementById('data-container').appendChild(div);

        // Create another new HTML element and append to the <div> element with ID "button-container"
        var div2 = document.createElement('div');
        div2.innerHTML =  
        '<a href="edit_article.html?update&id=' + articleId + 
        '" class="btn btn-light border border-1" style="background-color: #f2f2f2;">Update</a>';
        document.getElementById('button-container').appendChild(div2);
        
    })
    .catch(error => {
        console.error('Error:', error); // Handle errors
    });
