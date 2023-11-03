// Check if the "update" and "create" query parameter is present in the URL
const urlParams = new URLSearchParams(window.location.search);
const isCreate = urlParams.has('create');
const isUpdate = urlParams.has('update');

console.log(isCreate);
console.log(isUpdate);

// If it's an update, fetch and populate existing article data into the form fields
if (isUpdate) {
    const articleId = urlParams.get('id');
    fetch('https://4.216.116.11/article/' + articleId)
    .then(response => response.json())
    .then(data => {
        document.getElementById('title').value = data.title;
        document.getElementById('content').value = data.content;
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Function to handle form submission
function handleClick(event) {
    event.preventDefault();
    
    const form = document.getElementById('article_form');
    const formData = new FormData(form);
    const title = formData.get('title');
    const content = formData.get('content');
    const articleId = urlParams.get('id');
    
    if (!form.checkValidity()) {
        event.stopPropagation();
    } else {
        if (isCreate) {
            fetch(`https://4.216.116.11/article/create`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                window.location.href = `article_list.html`;
            })
            .catch(error => {
                console.error("Error:", error);
            });
        } else if (isUpdate) {      
            fetch(`https://4.216.116.11/article/${articleId}/update`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                window.location.href = `article_list.html`;
            })
            .catch(error => {
                console.error("Error:", error);
            });
        }
    }
    
    form.classList.add('was-validated');
}

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('article_form');
    form.addEventListener('submit', handleClick, false);
});
