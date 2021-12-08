const searchBar = document.querySelector(".search input"),
    searchIcon = document.querySelector(".search button"),
    usersList = document.querySelector(".users-list");


let xhr = new XMLHttpRequest();
xhr.open("GET", "php/usersonlylist.php", true);
xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
            let data = xhr.response;
            if (!searchBar.classList.contains("active")) {
                usersList.innerHTML = data;
            }
        }
    }
}
xhr.send();