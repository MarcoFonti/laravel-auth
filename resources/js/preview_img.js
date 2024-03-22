/* RECUPERO ELEMENTI */
const placeholder = 'https://marcolanci.it/boolean/assets/placeholder.png';
const input = document.getElementById('image');
const preview = document.getElementById('preview');

/* EVENTO */
input.addEventListener('input', () => {
    /* SCR DELL'IMMAGINE */
    preview.src = input.value || placeholder;
})
