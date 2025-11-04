        const urlParams = new URLSearchParams(window.location.search);
        const name = urlParams.get('name');
        
        if (name) {
            document.getElementById('userName').textContent = name;
        } else {
            document.getElementById('userName').textContent = '';
        }