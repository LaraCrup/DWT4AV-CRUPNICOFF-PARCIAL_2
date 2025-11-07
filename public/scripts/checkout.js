document.addEventListener('DOMContentLoaded', function() {
    const confirmPurchaseBtn = document.getElementById('confirmPurchaseBtn');

    if (confirmPurchaseBtn) {
        confirmPurchaseBtn.addEventListener('click', async function() {
            confirmPurchaseBtn.disabled = true;
            confirmPurchaseBtn.textContent = 'Procesando...';

            try {
                const response = await fetch('/compras', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({})
                });

                const data = await response.json();

                if (data.success) {
                    showMessage('Compra realizada exitosamente', 'success');
                    setTimeout(() => {
                        window.location.href = '/formReceived';
                    }, 2000);
                } else {
                    showMessage(data.message || 'Error al procesar la compra', 'error');
                    confirmPurchaseBtn.disabled = false;
                    confirmPurchaseBtn.textContent = 'Confirmar Compra';
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Error al procesar la compra', 'error');
                confirmPurchaseBtn.disabled = false;
                confirmPurchaseBtn.textContent = 'Confirmar Compra';
            }
        });
    }

    function showMessage(message, type = 'info') {
        const messageEl = document.createElement('div');
        messageEl.className = `message message-${type}`;
        messageEl.textContent = message;
        messageEl.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background-color: ${type === 'success' ? '#4CAF50' : '#f44336'};
            color: white;
            border-radius: 4px;
            z-index: 9999;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        `;

        document.body.appendChild(messageEl);

        setTimeout(() => {
            messageEl.remove();
        }, 3000);
    }
});