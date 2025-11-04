document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('deleteModal');
    if (!modal) return;
    
    const deleteButtons = document.querySelectorAll('.btnDelete');
    
    const modalInfo = document.getElementById('deleteItemInfo');
    const cancelBtn = document.getElementById('cancelDeleteBtn');
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    const closeBtn = document.querySelector('.closeModalBtn');
    
    let itemToDelete = null;
    
    function getItemType() {
        const currentPage = window.location.pathname;
        if (currentPage.includes('product')) {
            return 'producto';
        } else if (currentPage.includes('categor')) {
            return 'categoría';
        } else if (currentPage.includes('user')) {
            return 'usuario';
        }
        return 'elemento';
    }
    
    function handleTableDelete(event) {
        const row = event.currentTarget.closest('tr');
        if (row) {
            const itemId = row.querySelector('td:first-child')?.textContent || 'N/A';
            let itemName;
            
            const imageCell = row.querySelector('td:nth-child(2) img');
            if (imageCell) {
                itemName = row.querySelector('td:nth-child(3)')?.textContent || 'elemento';
            } else {
                itemName = row.querySelector('td:nth-child(2)')?.textContent || 'elemento';
            }
            
            itemToDelete = {
                element: row,
                id: itemId,
                name: itemName,
                type: 'table-row'
            };
            
            if (modalInfo) {
                modalInfo.textContent = `"${itemName}" (ID: ${itemId}) será eliminado permanentemente.`;
            }
        }
    }
    
    function handleDetailPageDelete() {
        let itemName = '';
        let itemId = '';
        
        if (document.querySelector('.productInfo h2')) {
            itemName = document.querySelector('.productInfo h2').textContent;
        } 
        else if (document.querySelector('.categoryDetail h2')) {
            itemName = document.querySelector('.categoryDetail h2').textContent;
        }
        else if (document.querySelector('h2.fontTitle')) {
            itemName = document.querySelector('h2.fontTitle').textContent;
        }
        else {
            itemName = 'Este elemento';
        }
        
        const paragraphs = document.querySelectorAll('.infoGroup p');
        for (const p of paragraphs) {
            if (p.textContent.includes('ID:')) {
                itemId = p.textContent.split(':')[1].trim();
                break;
            }
        }
        
        itemToDelete = {
            element: null,
            id: itemId,
            name: itemName,
            type: 'detail-page'
        };
        
        if (modalInfo) {
            if (itemId) {
                modalInfo.textContent = `"${itemName}" (${itemId}) será eliminado permanentemente.`;
            } else {
                modalInfo.textContent = `"${itemName}" será eliminado permanentemente.`;
            }
        }
    }
    
    function openModal(event) {
        if (event.currentTarget.closest('tr')) {
            handleTableDelete(event);
        } else {
            handleDetailPageDelete();
        }
        
        modal.style.display = 'flex';
    }
    
    function closeModal() {
        modal.style.display = 'none';
        itemToDelete = null;
    }
    
    function deleteItem() {
        if (itemToDelete) {
            if (itemToDelete.type === 'table-row' && itemToDelete.element) {
                try {
                    itemToDelete.element.remove();
                    showSuccessMessage();
                } catch (error) {
                    console.error("Error removing table row:", error);
                }
            } else {
                showSuccessMessage();
                setTimeout(() => {
                    const currentPage = window.location.pathname;
                    if (currentPage.includes('product')) {
                        window.location.href = '/admin/products';
                    } else if (currentPage.includes('categor')) {
                        window.location.href = '/admin/categorias';
                    } else if (currentPage.includes('user')) {
                        window.location.href = '/admin/usuarios';
                    }
                }, 1000);
                closeModal();
                return;
            }
        }
        closeModal();
    }
    
    function showSuccessMessage() {
        const successMessage = document.createElement('div');
        successMessage.className = 'alertSuccess';
        successMessage.textContent = getItemType() + ' eliminado con éxito';
        
        document.body.appendChild(successMessage);
        
        setTimeout(() => {
            if (successMessage.parentNode) {
                successMessage.parentNode.removeChild(successMessage);
            }
        }, 3000);
    }
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', openModal);
    });
    
    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeModal);
    }
    
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }
    
    if (confirmBtn) {
        confirmBtn.addEventListener('click', deleteItem);
    }
    
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });
});
