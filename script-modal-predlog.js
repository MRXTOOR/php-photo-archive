const suggestionsList = document.querySelector('.suggestions-list');
const moveToAlbumForm = document.querySelector('.move-to-album-form');
const moveButton = document.querySelector('#move-button');
const cancelMoveButton = document.querySelector('#cancel-move-button');


suggestionsList.addEventListener('click', (event) => {
    if (event.target.classList.contains('approve-button')) {
        moveToAlbumForm.style.display = 'block';
    }
});


cancelMoveButton.addEventListener('click', () => {
    moveToAlbumForm.style.display = 'none';
});


moveButton.addEventListener('click', () => {
    const selectedAlbum = document.querySelector('#album-select').value;

    moveToAlbumForm.style.display = 'none';
});