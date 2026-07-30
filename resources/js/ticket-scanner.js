import { Html5Qrcode } from 'html5-qrcode';

const scannerEl = document.getElementById('ticket-scanner');

if (scannerEl) {
    const resultEl = document.getElementById('ticket-scanner-result');
    const scanUrl = scannerEl.dataset.scanUrl;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const html5Qrcode = new Html5Qrcode('ticket-scanner');
    let isProcessing = false;

    function renderResult(type, message, details = null) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        let detailsHtml = '';
        if (details) {
            detailsHtml = `
                <p class="mb-1"><strong>${details.play_title}</strong></p>
                <p class="mb-1">${details.buyer_name}</p>
                <p class="mb-0">${details.ticket_amount} ${details.ticket_amount == 1 ? 'entrada' : 'entradas'}</p>
            `;
        }
        resultEl.innerHTML = `
            <div class="alert ${alertClass}">
                <p class="mb-0">${message}</p>
                ${detailsHtml}
            </div>
        `;
    }

    function onScanSuccess(decodedText) {
        if (isProcessing) return;
        isProcessing = true;

        fetch(scanUrl, {
            method: 'POST',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ ticket_code: decodedText }),
        })
            .then((response) => response.json().then((data) => ({ ok: response.ok, data })))
            .then(({ ok, data }) => {
                renderResult(ok ? 'success' : 'error', data.message, ok ? data : null);
            })
            .catch((error) => {
                console.error(error);

                renderResult('error', 'No se pudo validar la entrada. Intentá de nuevo.');
            })
            .finally(() => {
                setTimeout(() => {
                    isProcessing = false;
                }, 2000);
            });
    }

    html5Qrcode.start(
        { facingMode: 'environment' },
        { fps: 10, qrbox: { width: 250, height: 250 } },
        onScanSuccess
    ).catch(() => {
        renderResult('error', 'No se pudo acceder a la cámara.');
    });
}
