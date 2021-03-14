let comments = document.querySelector('.wrapper-comments');
let checkReddit = document.querySelector('.buttonReddit');
let checkForum = document.querySelector('.buttonForum');

checkReddit.onclick = function() {
    comments.classList.add('displayNone');
}

checkForum.onclick = function() {
    if (comments.classList.contains('displayNone')) {
        comments.classList.remove('displayNone')
    }
} 

