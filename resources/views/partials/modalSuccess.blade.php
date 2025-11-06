<div id="successModal" class="successModal">
    <div class="successModalContent">
        <div class="successModalBody">
            <h2 class="fontTitle">¡Registro exitoso!</h2>
            <p class="fontBody">Tu usuario se creó correctamente. Bienvenido a Tortas Manuela.</p>
        </div>
        <button id="closeSuccessModalBtn" class="btn btnPrimary">Continuar</button>
    </div>
</div>

<style>
    .successModal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .successModalContent {
        background-color: #f8f7ff;
        border-radius: 12px;
        padding: 40px;
        max-width: 400px;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        animation: slideUp 0.3s ease-out;
    }

    @keyframes slideUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .successModalBody {
        margin-bottom: 30px;
    }

    .successModalBody h2 {
        margin-bottom: 12px;
        color: #2d3436;
    }

    .successModalBody p {
        color: #636e72;
        line-height: 1.6;
    }

    #closeSuccessModalBtn {
        width: 100%;
        padding: 12px 24px;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    #closeSuccessModalBtn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    }

    @media (max-width: 768px) {
        .successModalContent {
            margin: 20px;
            padding: 30px;
            max-width: none;
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }
</style>

<script>
    document.getElementById('closeSuccessModalBtn').addEventListener('click', function() {
        const modal = document.getElementById('successModal');
        modal.style.animation = 'fadeOut 0.3s ease-in-out';
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    });

    document.getElementById('successModal').addEventListener('click', function(event) {
        if (event.target === this) {
            this.style.animation = 'fadeOut 0.3s ease-in-out';
            setTimeout(() => {
                this.style.display = 'none';
            }, 300);
        }
    });
</script>