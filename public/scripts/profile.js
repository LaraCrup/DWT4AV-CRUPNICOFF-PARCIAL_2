document.addEventListener('DOMContentLoaded', function() {
    const editProfileBtn = document.getElementById('editProfileBtn');
    const saveProfileBtn = document.getElementById('saveProfileBtn');
    const cancelEditBtn = document.getElementById('cancelEditBtn');
    const profileViewMode = document.getElementById('profileViewMode');
    const profileEditMode = document.getElementById('profileEditMode');
    
    const userNameInput = document.getElementById('userName');
    const userEmailInput = document.getElementById('userEmail');
    const userBirthInput = document.getElementById('userBirth');
    
    let currentName = userNameInput.value;
    let currentEmail = userEmailInput.value;
    let currentBirth = userBirthInput.value;
    
    editProfileBtn.addEventListener('click', function() {
        profileViewMode.classList.add('hidden');
        profileEditMode.classList.remove('hidden');
    });
    
    saveProfileBtn.addEventListener('click', function() {
        currentName = userNameInput.value;
        currentEmail = userEmailInput.value;
        currentBirth = userBirthInput.value;
        
        const nameElement = profileViewMode.querySelector('p:nth-child(1)');
        const emailElement = profileViewMode.querySelector('p:nth-child(2)');
        const birthElement = profileViewMode.querySelector('p:nth-child(3)');
        
        const birthDate = new Date(currentBirth);
        const formattedDate = birthDate.toLocaleDateString('es-ES', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
        
        nameElement.innerHTML = `<strong>Nombre:</strong> ${currentName}`;
        emailElement.innerHTML = `<strong>Email:</strong> ${currentEmail}`;
        birthElement.innerHTML = `<strong>Fecha de nacimiento:</strong> ${formattedDate}`;
        
        profileViewMode.classList.remove('hidden');
        profileEditMode.classList.add('hidden');
    });
    
    cancelEditBtn.addEventListener('click', function() {
        userNameInput.value = currentName;
        userEmailInput.value = currentEmail;
        userBirthInput.value = currentBirth;
        
        profileViewMode.classList.remove('hidden');
        profileEditMode.classList.add('hidden');
    });
});
