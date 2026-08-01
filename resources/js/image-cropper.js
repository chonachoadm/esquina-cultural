import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';
import { Modal } from 'bootstrap/dist/js/bootstrap.bundle.min.js';

const ALLOWED_MIME_TYPES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

export function initImageCropper() {
    const modalEl = document.getElementById('image-cropper-modal');
    const modalImage = document.getElementById('image-cropper-target');
    const confirmBtn = document.getElementById('image-cropper-confirm');
    const inputs = document.querySelectorAll('input[type="file"][data-cropper-width]');

    if (!modalEl || !modalImage || !confirmBtn || !inputs.length) return;

    const bsModal = new Modal(modalEl, { backdrop: 'static' });
    let cropper = null;
    let activeInput = null;
    let confirmed = false;

    function destroyCropper() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }

    function onModalShown() {
        destroyCropper();
        const aspect = parseFloat(activeInput.dataset.cropperAspect) || 1;
        cropper = new Cropper(modalImage, {
            aspectRatio: aspect,
            viewMode: 1,
            autoCropArea: 1,
            dragMode: 'move',
            background: false,
        });
    }

    inputs.forEach((input) => {
        input.addEventListener('change', () => {
            const file = input.files && input.files[0];
            if (!file) return;

            if (!ALLOWED_MIME_TYPES.includes(file.type)) {
                alert('Formato de imagen no permitido. Usá jpeg, png, gif o webp.');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (event) => {
                activeInput = input;
                confirmed = false;
                modalImage.src = event.target.result;
                bsModal.show();
            };
            reader.readAsDataURL(file);
        });
    });

    modalEl.addEventListener('shown.bs.modal', onModalShown);

    confirmBtn.addEventListener('click', () => {
        if (!cropper || !activeInput) return;

        const width = parseInt(activeInput.dataset.cropperWidth, 10);
        const height = parseInt(activeInput.dataset.cropperHeight, 10);

        cropper.getCroppedCanvas({ width, height, imageSmoothingQuality: 'high' }).toBlob((blob) => {
            if (!blob) return;

            const originalFile = activeInput.files[0];
            const fileName = originalFile ? originalFile.name : 'cropped-image.jpg';
            const croppedFile = new File([blob], fileName, { type: 'image/jpeg' });

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            activeInput.files = dataTransfer.files;

            confirmed = true;
            bsModal.hide();
        }, 'image/jpeg', 0.9);
    });

    modalEl.addEventListener('hidden.bs.modal', () => {
        destroyCropper();
        if (!confirmed && activeInput) {
            activeInput.value = '';
        }
        activeInput = null;
        modalImage.src = '';
    });
}
