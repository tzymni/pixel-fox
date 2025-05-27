let isPortrait = false;
let generating = false;

const imageInput = document.getElementById('image');
const previewImage = document.getElementById('preview-image');
const form = document.getElementById('pixel-form');  // jednolita deklaracja formy

function handleImageChange(event) {
    const reader = new FileReader();
    reader.onload = () => {
        previewImage.onload = () => {
            isPortrait = previewImage.naturalHeight > previewImage.naturalWidth;
        };
        previewImage.src = reader.result;
        previewImage.classList.remove('hidden');
    };
    reader.readAsDataURL(event.target.files[0]);
}

async function handleFormSubmit(e) {
    e.preventDefault();
    if (generating) return;

    previewImage.classList.add('spin-y');

    if (isPortrait) {
        previewImage.classList.add('top-[17%]', 'left-[25%]');
    } else {
        previewImage.classList.add('top-[30%]', 'left-[20%]');
    }

    generating = true;
    const formData = new FormData(form); // używamy form, które jest już zdefiniowane
    const url = form.dataset.generateUrl;

    const response = await fetch(url, {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
    });

    console.log(response)
    if (!response.ok) {
        console.error('HTTP error', response.status);
        generating = false;
        previewImage.classList.remove('spin-y', 'top-[17%]', 'top-[30%]', 'left-[20%]', 'left-[25%]');
        previewImage.classList.add('hidden');
        alert(response.statusText);
        return;
    }

    const data = await response.json();
    const taskId = data.task_id;

    console.log('Task queued. ID:', taskId);

    Echo.channel('pixel-task.' + taskId).listen('PixelImageGenerated', (e) => {
        const linkPixel = '/storage/pixel_images/' + e.pixelImageName;
        previewImage.src = linkPixel;
        previewImage.classList.remove('spin-y', 'top-[17%]', 'top-[30%]', 'left-[20%]', 'left-[25%]');
        generating = false;
    });
}

imageInput.addEventListener('change', handleImageChange);
form.addEventListener('submit', handleFormSubmit);
