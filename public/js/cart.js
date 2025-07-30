// FrozenFoodPanda - Cart JavaScript

// Update cart count in the navbar
function updateCartCount() {
    fetch('/cart/count')
        .then(response => response.json())
        .then(data => {
            const cartCountElement = document.getElementById('cartCount');
            if (cartCountElement) {
                cartCountElement.textContent = data.count;
            }
        })
        .catch(error => console.error('Error updating cart count:', error));
}

// Add product to cart
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart button click handler
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const quantity = document.getElementById(`quantity-${productId}`) ? 
                document.getElementById(`quantity-${productId}`).value : 1;
            
            addToCart(productId, quantity);
        });
    });
});

// Add to cart function
function addToCart(productId, quantity = 1) {
    // Get CSRF token
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Product added to cart!', 'success');
            updateCartCount();
        } else {
            showNotification(data.message || 'Failed to add product to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error adding to cart:', error);
        showNotification('An error occurred while adding to cart', 'error');
    });
}

// Remove item from cart
function removeFromCart(cartItemId) {
    // Get CSRF token
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/cart/${cartItemId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': token
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the cart item element from the DOM
            const cartItemElement = document.getElementById(`cart-item-${cartItemId}`);
            if (cartItemElement) {
                cartItemElement.remove();
            }
            
            // Update cart count and total
            updateCartCount();
            
            // Update cart total if provided in response
            if (data.total !== undefined) {
                const cartTotalElement = document.getElementById('cart-total');
                if (cartTotalElement) {
                    cartTotalElement.textContent = `$${data.total.toFixed(2)}`;
                }
            } else {
                updateCartTotal();
            }
            
            showNotification('Item removed from cart', 'success');
            
            // If cart is empty, reload the page to show empty cart message
            const cartItems = document.querySelectorAll('[id^="cart-item-"]');
            if (cartItems.length === 0) {
                window.location.reload();
            }
        } else {
            showNotification(data.message || 'Failed to remove item from cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error removing from cart:', error);
        showNotification('An error occurred while removing from cart', 'error');
    });
}

// Update cart item quantity
function updateCartItemQuantity(cartItemId, quantity) {
    // Get CSRF token
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/cart/${cartItemId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update item subtotal
            const subtotalElement = document.getElementById(`subtotal-${cartItemId}`);
            if (subtotalElement) {
                subtotalElement.textContent = `$${data.subtotal.toFixed(2)}`;
            }
            
            // Update cart total
            if (data.total !== undefined) {
                const cartTotalElement = document.getElementById('cart-total');
                if (cartTotalElement) {
                    cartTotalElement.textContent = `$${data.total.toFixed(2)}`;
                }
            } else {
                updateCartTotal();
            }
            
            showNotification('Cart updated', 'success');
        } else {
            showNotification(data.message || 'Failed to update cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error updating cart:', error);
        showNotification('An error occurred while updating cart', 'error');
    });
}

// Update cart total
function updateCartTotal() {
    const totalElement = document.getElementById('cart-total');
    if (!totalElement) return;
    
    // Calculate total from all subtotals
    let total = 0;
    const subtotalElements = document.querySelectorAll('[id^="subtotal-"]');
    
    subtotalElements.forEach(element => {
        const value = parseFloat(element.textContent.replace('$', ''));
        if (!isNaN(value)) {
            total += value;
        }
    });
    
    totalElement.textContent = `$${total.toFixed(2)}`;
}

// Show notification
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '9999';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    // Add to body
    document.body.appendChild(notification);
    
    // Auto dismiss after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Initialize quantity change handlers
document.addEventListener('DOMContentLoaded', function() {
    // Initialize quantity inputs if they exist
    const quantityInputs = document.querySelectorAll('[id^="quantity-"]');
    quantityInputs.forEach(input => {
        if (!input.value || isNaN(parseInt(input.value))) {
            input.value = 1;
        }
    });
    
    // Cart quantity inputs
    const cartQuantityInputs = document.querySelectorAll('.cart-quantity-input');
    
    cartQuantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const cartItemId = this.getAttribute('data-cart-item-id');
            let quantity = parseInt(this.value);
            
            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
                this.value = 1;
            } else if (quantity > 10) {
                quantity = 10;
                this.value = 10;
            }
            
            updateCartItemQuantity(cartItemId, quantity);
        });
    });
    
    // Initialize quantity buttons
    const quantityBtns = document.querySelectorAll('.quantity-btn');
    quantityBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.getAttribute('data-action');
            const cartItemId = this.getAttribute('data-cart-item-id');
            const inputElement = document.querySelector(`.cart-quantity-input[data-cart-item-id="${cartItemId}"]`);
            
            if (!inputElement) return;
            
            let currentValue = parseInt(inputElement.value) || 1;
            
            if (action === 'increase') {
                if (currentValue < 10) {
                    currentValue += 1;
                    inputElement.value = currentValue;
                    updateCartItemQuantity(cartItemId, currentValue);
                }
            } else if (action === 'decrease') {
                if (currentValue > 1) {
                    currentValue -= 1;
                    inputElement.value = currentValue;
                    updateCartItemQuantity(cartItemId, currentValue);
                }
            }
        });
    });
    
    // Initialize remove buttons
    const removeButtons = document.querySelectorAll('.remove-from-cart-btn');
    
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cartItemId = this.getAttribute('data-cart-item-id');
            removeFromCart(cartItemId);
        });
    });
});