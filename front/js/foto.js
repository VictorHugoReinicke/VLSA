const avatarImage = document.getElementById('foto');
const spanId = document.getElementById('spanId'); 

avatarImage.addEventListener('change', event => {
  const preview = document.querySelector('#preview_image'); 

  if (preview) {
    preview.remove(); 
  }

  const reader = new FileReader();

  reader.onload = function (event) {
    const previewImage = document.createElement('img');
    previewImage.width = 300;
    previewImage.height = 169;
    previewImage.id = 'preview_image';
    previewImage.src = event.target.result;

   
    spanId.innerHTML = ''; 
    spanId.appendChild(previewImage);
  };

  reader.readAsDataURL(avatarImage.files[0]);
});