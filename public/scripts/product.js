        document.querySelectorAll('.sizeBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.sizeBtn').forEach(b => b.classList.remove('selectedSize'));
                this.classList.add('selectedSize');                
            });
        });