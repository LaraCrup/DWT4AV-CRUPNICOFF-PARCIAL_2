const Validator = {
    validateEmail: function(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    },

    validatePassword: function(password) {
        return password.length >= 6 && 
               /[a-zA-Z]/.test(password) && 
               /\d/.test(password);
    },

    validateName: function(name) {
        return name.trim().length >= 3;
    },

    validateBirthdate: function(birthdate) {
        const today = new Date();
        const birthdateObj = new Date(birthdate);
        
        if (isNaN(birthdateObj.getTime())) {
            return false;
        }
        
        let age = today.getFullYear() - birthdateObj.getFullYear();
        const monthDiff = today.getMonth() - birthdateObj.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdateObj.getDate())) {
            age--;
        }
        
        return age >= 18;
    },

    showError: function(inputElement, message) {
        const parent = inputElement.parentElement;
        const existingError = parent.querySelector('.errorMessage');
        if (existingError) {
            parent.removeChild(existingError);
        }

        const errorDiv = document.createElement('div');
        errorDiv.className = 'errorMessage';
        errorDiv.textContent = message;
        
        parent.appendChild(errorDiv);
        inputElement.style.borderColor = '#e63946';
    },

    removeError: function(inputElement) {
        const parent = inputElement.parentElement;
        const existingError = parent.querySelector('.errorMessage');
        if (existingError) {
            parent.removeChild(existingError);
        }
        inputElement.style.borderColor = '';
    },

    validatePasswordMatch: function(password, confirmPassword) {
        return password === confirmPassword;
    },
    
    validateRole: function(role) {
        return role && role !== "";
    }
};

Object.assign(Validator, {
    validateProductName: function(name) {
        return name.trim().length >= 3;
    },
    
    validatePrice: function(price) {
        return !isNaN(price) && parseFloat(price) > 0;
    },
    
    validateCategory: function(category) {
        return category && category !== "";
    },
    
    validateImage: function(fileInput) {
        if (!fileInput.files || fileInput.files.length === 0) {
            return false;
        }
        
        const file = fileInput.files[0];
        const validTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        return validTypes.includes(file.type);
    },
    
    validateSizes: function(form) {
        const sizeCheckboxes = form.querySelectorAll('input[name="sizes"]:checked');
        if (sizeCheckboxes.length === 0) {
            return false;
        }
        
        let allValid = true;
        sizeCheckboxes.forEach(checkbox => {
            const size = checkbox.value;
            const portionsInput = document.getElementById(`sizePorciones${size.charAt(0).toUpperCase() + size.slice(1)}`);
            const priceInput = document.getElementById(`sizePrecio${size.charAt(0).toUpperCase() + size.slice(1)}`);
            
            if (!portionsInput.value || parseInt(portionsInput.value) <= 0) {
                Validator.showError(portionsInput, 'Ingresa un número válido de porciones');
                allValid = false;
            }
            
            if (!priceInput.value || parseFloat(priceInput.value) <= 0) {
                Validator.showError(priceInput, 'Ingresa un precio válido');
                allValid = false;
            }
        });
        
        return allValid;
    }
});

Object.assign(Validator, {
    validateUserName: function(name) {
        return name.trim().length >= 3;
    },
    
    validateUserEmail: function(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    },
    
    validateUserPassword: function(password) {
        return password.length >= 6 && 
               /[a-zA-Z]/.test(password) && 
               /\d/.test(password);
    },
    
    validateUserRole: function(role) {
        return role && (role === 'admin' || role === 'user');
    }
});

Object.assign(Validator, {
    validateCategoryName: function(name) {
        return name.trim().length >= 2;
    }
});

function validateLoginForm(event) {
    event.preventDefault();
    let isValid = true;
    
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    
    if (!Validator.validateEmail(emailInput.value)) {
        Validator.showError(emailInput, 'Ingresa un email válido');
        isValid = false;
    } else {
        Validator.removeError(emailInput);
    }
    
    if (!Validator.validatePassword(passwordInput.value)) {
        Validator.showError(passwordInput, 'La contraseña debe tener al menos 6 caracteres, una letra y un número');
        isValid = false;
    } else {
        Validator.removeError(passwordInput);
    }
    
    if (isValid) {
        if (event.target.id === 'loginAdminForm') {
            window.location.href = '../admin/dashboard.html';
        } else {
            window.location.href = '/index.html';
        }
    }
}

function validateRegisterForm(event) {
    event.preventDefault();
    let isValid = true;
    
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const dateInput = document.getElementById('date');
    const passwordInput = document.getElementById('password');
    
    if (!Validator.validateName(nameInput.value)) {
        Validator.showError(nameInput, 'Ingresa un nombre válido (mínimo 3 caracteres)');
        isValid = false;
    } else {
        Validator.removeError(nameInput);
    }
    
    if (!Validator.validateEmail(emailInput.value)) {
        Validator.showError(emailInput, 'Ingresa un email válido');
        isValid = false;
    } else {
        Validator.removeError(emailInput);
    }
    
    if (!dateInput.value) {
        Validator.showError(dateInput, 'Ingresa tu fecha de nacimiento');
        isValid = false;
    } else if (!Validator.validateBirthdate(dateInput.value)) {
        Validator.showError(dateInput, 'Debes ser mayor de 18 años para registrarte');
        isValid = false;
    } else {
        Validator.removeError(dateInput);
    }
    
    if (!Validator.validatePassword(passwordInput.value)) {
        Validator.showError(passwordInput, 'La contraseña debe tener al menos 6 caracteres, una letra y un número');
        isValid = false;
    } else {
        Validator.removeError(passwordInput);
    }
    
    if (isValid) {
        window.location.href = '/login.html';
    }
}

function validateProductForm(event) {
    event.preventDefault();
    let isValid = true;
    
    const nameInput = document.getElementById('productName');
    const categoryInput = document.getElementById('category');
    const imageInput = document.getElementById('productImage');
    const form = event.target;
    
    if (!Validator.validateProductName(nameInput.value)) {
        Validator.showError(nameInput, 'El nombre del producto debe tener al menos 3 caracteres');
        isValid = false;
    } else {
        Validator.removeError(nameInput);
    }
    
    if (!Validator.validateCategory(categoryInput.value)) {
        Validator.showError(categoryInput, 'Selecciona una categoría');
        isValid = false;
    } else {
        Validator.removeError(categoryInput);
    }
    
    if (!Validator.validateImage(imageInput)) {
        Validator.showError(imageInput, 'Selecciona una imagen válida (JPG, PNG, WEBP, GIF)');
        isValid = false;
    } else {
        Validator.removeError(imageInput);
    }
    
    if (!Validator.validateSizes(form)) {
        const sizesGroup = document.querySelector('.sizeGroup');
        if (document.querySelectorAll('input[name="sizes"]:checked').length === 0) {
            const firstRow = document.querySelector('.sizeRow');
            Validator.showError(firstRow, 'Selecciona al menos un tamaño');
        }
        isValid = false;
    }
    
    const allergensChecked = document.querySelectorAll('input[name="allergens"]:checked');
    if (allergensChecked.length === 0) {
        const allergensGroup = document.querySelector('.formGroup:has(input[name="allergens"])');
        Validator.showError(allergensGroup, 'Selecciona al menos un alérgeno');
        isValid = false;
    }
    
    if (isValid) {
        window.location.href = '/admin/products.html';
    }
}

function validateProductEditForm(event) {
    event.preventDefault();
    let isValid = true;
    
    const nameInput = document.getElementById('productName');
    const categoryInput = document.getElementById('category');
    const imageInput = document.getElementById('productImage');
    const form = event.target;
    
    if (!Validator.validateProductName(nameInput.value)) {
        Validator.showError(nameInput, 'El nombre del producto debe tener al menos 3 caracteres');
        isValid = false;
    } else {
        Validator.removeError(nameInput);
    }
    
    if (!Validator.validateCategory(categoryInput.value)) {
        Validator.showError(categoryInput, 'Selecciona una categoría');
        isValid = false;
    } else {
        Validator.removeError(categoryInput);
    }
    
    if (imageInput.files && imageInput.files.length > 0) {
        if (!Validator.validateImage(imageInput)) {
            Validator.showError(imageInput, 'Selecciona una imagen válida (JPG, PNG, WEBP, GIF)');
            isValid = false;
        } else {
            Validator.removeError(imageInput);
        }
    }
    
    if (!Validator.validateSizes(form)) {
        const sizesGroup = document.querySelector('.sizeGroup');
        if (document.querySelectorAll('input[name="sizes"]:checked').length === 0) {
            const firstRow = document.querySelector('.sizeRow');
            Validator.showError(firstRow, 'Selecciona al menos un tamaño');
        }
        isValid = false;
    }
    
    const allergensChecked = document.querySelectorAll('input[name="allergens"]:checked');
    if (allergensChecked.length === 0) {
        const allergensGroup = document.querySelector('.formGroup:has(input[name="allergens"])');
        Validator.showError(allergensGroup, 'Selecciona al menos un alérgeno');
        isValid = false;
    }
    
    if (isValid) {
        window.location.href = '/admin/products.html';
    }
}

function validateUserForm(event) {
    event.preventDefault();
    let isValid = true;
    
    const nameInput = document.getElementById('userName');
    const emailInput = document.getElementById('userEmail');
    const passwordInput = document.getElementById('userPassword');
    const passwordConfirmInput = document.getElementById('userPasswordConfirm');
    const roleInput = document.getElementById('userRole');
    
    if (!Validator.validateUserName(nameInput.value)) {
        Validator.showError(nameInput, 'El nombre debe tener al menos 3 caracteres');
        isValid = false;
    } else {
        Validator.removeError(nameInput);
    }
    
    if (!Validator.validateUserEmail(emailInput.value)) {
        Validator.showError(emailInput, 'Ingresa un email válido');
        isValid = false;
    } else {
        Validator.removeError(emailInput);
    }
    
    if (!Validator.validateUserPassword(passwordInput.value)) {
        Validator.showError(passwordInput, 'La contraseña debe tener al menos 6 caracteres, una letra y un número');
        isValid = false;
    } else {
        Validator.removeError(passwordInput);
    }
    
    if (passwordInput.value !== passwordConfirmInput.value) {
        Validator.showError(passwordConfirmInput, 'Las contraseñas no coinciden');
        isValid = false;
    } else if (passwordInput.value) {
        Validator.removeError(passwordConfirmInput);
    }
    
    if (!Validator.validateUserRole(roleInput.value)) {
        Validator.showError(roleInput, 'Selecciona un rol válido');
        isValid = false;
    } else {
        Validator.removeError(roleInput);
    }
    
    if (isValid) {
        window.location.href = '/admin/users.html';
    }
}

function validateUserEditForm(event) {
    event.preventDefault();
    let isValid = true;
    
    const nameInput = document.getElementById('userName');
    const emailInput = document.getElementById('userEmail');
    const passwordInput = document.getElementById('userPassword');
    const passwordConfirmInput = document.getElementById('userPasswordConfirm');
    const roleInput = document.getElementById('userRole');
    
    if (!Validator.validateUserName(nameInput.value)) {
        Validator.showError(nameInput, 'El nombre debe tener al menos 3 caracteres');
        isValid = false;
    } else {
        Validator.removeError(nameInput);
    }
    
    if (!Validator.validateUserEmail(emailInput.value)) {
        Validator.showError(emailInput, 'Ingresa un email válido');
        isValid = false;
    } else {
        Validator.removeError(emailInput);
    }
    
    if (passwordInput.value) {
        if (!Validator.validateUserPassword(passwordInput.value)) {
            Validator.showError(passwordInput, 'La contraseña debe tener al menos 6 caracteres, una letra y un número');
            isValid = false;
        } else {
            Validator.removeError(passwordInput);
        }
        
        if (passwordInput.value !== passwordConfirmInput.value) {
            Validator.showError(passwordConfirmInput, 'Las contraseñas no coinciden');
            isValid = false;
        } else {
            Validator.removeError(passwordConfirmInput);
        }
    }
    
    if (!Validator.validateUserRole(roleInput.value)) {
        Validator.showError(roleInput, 'Selecciona un rol válido');
        isValid = false;
    } else {
        Validator.removeError(roleInput);
    }
    
    if (isValid) {
        window.location.href = '/admin/users.html';
    }
}

function validateCategoryForm(event) {
    event.preventDefault();
    let isValid = true;
    
    const nameInput = document.getElementById('categoryName');
    
    if (!Validator.validateCategoryName(nameInput.value)) {
        Validator.showError(nameInput, 'El nombre de la categoría debe tener al menos 2 caracteres');
        isValid = false;
    } else {
        Validator.removeError(nameInput);
    }
    
    if (isValid) {
        window.location.href = '/admin/categories.html';
    }
}

function validateCategoryEditForm(event) {
    event.preventDefault();
    let isValid = true;
    
    const nameInput = document.getElementById('categoryName');
    
    if (!Validator.validateCategoryName(nameInput.value)) {
        Validator.showError(nameInput, 'El nombre de la categoría debe tener al menos 2 caracteres');
        isValid = false;
    } else {
        Validator.removeError(nameInput);
    }
    
    if (isValid) {
        window.location.href = '/admin/categories.html';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const loginAdminForm = document.getElementById('loginAdminForm');
    const createProductForm = document.getElementById('createProductForm');
    const editProductForm = document.getElementById('editProductForm');
    const createUserForm = document.getElementById('createUserForm');
    const editUserForm = document.getElementById('editUserForm');
    const createCategoryForm = document.getElementById('createCategoryForm');
    const editCategoryForm = document.getElementById('editCategoryForm');
    
    if (loginAdminForm) {
        loginAdminForm.addEventListener('submit', validateLoginForm);
    }
    
    if (loginForm) {
        loginForm.addEventListener('submit', validateLoginForm);
    }
    
    if (registerForm) {
        registerForm.addEventListener('submit', validateRegisterForm);
    }
    
    if (createProductForm) {
        createProductForm.addEventListener('submit', validateProductForm);
        
        const sizeCheckboxes = document.querySelectorAll('input[name="sizes"]');
        sizeCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const size = this.value;
                const portionsInput = document.getElementById(`sizePorciones${size.charAt(0).toUpperCase() + size.slice(1)}`);
                const priceInput = document.getElementById(`sizePrecio${size.charAt(0).toUpperCase() + size.slice(1)}`);
                
                if (this.checked) {
                    portionsInput.required = true;
                    priceInput.required = true;
                } else {
                    portionsInput.required = false;
                    priceInput.required = false;
                    portionsInput.value = '';
                    priceInput.value = '';
                }
            });
        });
        
        const fileInput = document.getElementById('productImage');
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                const fileNameDisplay = document.getElementById('selectedFileName');
                if (fileNameDisplay) {
                    if (this.files && this.files.length > 0) {
                        fileNameDisplay.textContent = this.files[0].name;
                        fileNameDisplay.classList.add('active');
                    } else {
                        fileNameDisplay.textContent = 'No hay archivo seleccionado';
                        fileNameDisplay.classList.remove('active');
                    }
                }
            });
        }
    }
    
    if (editProductForm) {
        editProductForm.addEventListener('submit', validateProductEditForm);
        
        const sizeCheckboxes = document.querySelectorAll('input[name="sizes"]');
        sizeCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const size = this.value;
                const portionsInput = document.getElementById(`sizePorciones${size.charAt(0).toUpperCase() + size.slice(1)}`);
                const priceInput = document.getElementById(`sizePrecio${size.charAt(0).toUpperCase() + size.slice(1)}`);
                
                if (this.checked) {
                    portionsInput.required = true;
                    priceInput.required = true;
                } else {
                    portionsInput.required = false;
                    priceInput.required = false;
                    portionsInput.value = '';
                    priceInput.value = '';
                }
            });
        });
        
        const fileInput = document.getElementById('productImage');
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                const fileNameDisplay = document.getElementById('selectedFileName');
                if (fileNameDisplay) {
                    if (this.files && this.files.length > 0) {
                        fileNameDisplay.textContent = this.files[0].name;
                        fileNameDisplay.classList.add('active');
                    } else {
                        fileNameDisplay.textContent = 'No hay archivo seleccionado';
                        fileNameDisplay.classList.remove('active');
                    }
                }
            });
        }
    }
    
    if (createUserForm) {
        createUserForm.addEventListener('submit', validateUserForm);
        
        const userFileInput = document.getElementById('userImage');
        if (userFileInput) {
            userFileInput.addEventListener('change', function() {
                const fileNameDisplay = document.getElementById('selectedFileName');
                if (fileNameDisplay) {
                    if (this.files && this.files.length > 0) {
                        fileNameDisplay.textContent = this.files[0].name;
                        fileNameDisplay.classList.add('active');
                    } else {
                        fileNameDisplay.textContent = 'No hay archivo seleccionado';
                        fileNameDisplay.classList.remove('active');
                    }
                }
            });
        }
    }
    
    if (editUserForm) {
        editUserForm.addEventListener('submit', validateUserEditForm);
    }
    
    if (createCategoryForm) {
        createCategoryForm.addEventListener('submit', validateCategoryForm);
    }
    
    if (editCategoryForm) {
        editCategoryForm.addEventListener('submit', validateCategoryEditForm);
    }
});
