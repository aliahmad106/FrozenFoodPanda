// Form validation for checkout

document.addEventListener('DOMContentLoaded', function() {
    // Get the checkout form
    const checkoutForm = document.querySelector('form[action*="checkout/place-order"]');
    
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Validate delivery address
            const deliveryAddress = document.getElementById('delivery_address');
            if (!deliveryAddress.value.trim()) {
                showError(deliveryAddress, 'Delivery address is required');
                isValid = false;
            } else if (deliveryAddress.value.trim().length < 10) {
                showError(deliveryAddress, 'Please enter a complete delivery address');
                isValid = false;
            } else {
                clearError(deliveryAddress);
            }
            
            // Validate phone number
            const phoneNumber = document.getElementById('phone_number');
            const phoneRegex = /^[0-9+\-\s()]{7,15}$/;
            if (!phoneNumber.value.trim()) {
                showError(phoneNumber, 'Phone number is required');
                isValid = false;
            } else if (!phoneRegex.test(phoneNumber.value.trim())) {
                showError(phoneNumber, 'Please enter a valid phone number');
                isValid = false;
            } else {
                clearError(phoneNumber);
            }
            
            // Validate terms checkbox
            const termsCheckbox = document.getElementById('terms');
            if (!termsCheckbox.checked) {
                showError(termsCheckbox, 'You must agree to the terms and conditions');
                isValid = false;
            } else {
                clearError(termsCheckbox);
            }
            
            if (!isValid) {
                event.preventDefault();
                
                // Scroll to the first error
                const firstError = document.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    }
    
    // Helper functions
    function showError(element, message) {
        element.classList.add('is-invalid');
        
        // Check if error message element already exists
        let errorElement = element.nextElementSibling;
        if (!errorElement || !errorElement.classList.contains('invalid-feedback')) {
            errorElement = document.createElement('div');
            errorElement.classList.add('invalid-feedback');
            element.parentNode.insertBefore(errorElement, element.nextSibling);
        }
        
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
    
    function clearError(element) {
        element.classList.remove('is-invalid');
        
        // Remove error message if it exists
        const errorElement = element.nextElementSibling;
        if (errorElement && errorElement.classList.contains('invalid-feedback')) {
            errorElement.textContent = '';
            errorElement.style.display = 'none';
        }
    }
});