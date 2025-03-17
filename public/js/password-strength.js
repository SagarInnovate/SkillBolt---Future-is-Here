// Add this JavaScript to your registration and password reset pages
// This shows a real-time password strength meter

document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    
    if (!passwordInput) return;
    
    // Create password strength meter elements
    const strengthMeter = document.createElement('div');
    strengthMeter.className = 'mt-1 w-full h-2 bg-gray-200 rounded-full overflow-hidden';
    
    const strengthBar = document.createElement('div');
    strengthBar.className = 'h-full bg-red-500 transition-all duration-300';
    strengthBar.style.width = '0%';
    
    const strengthText = document.createElement('p');
    strengthText.className = 'mt-1 text-xs text-gray-500';
    strengthText.innerText = 'Password strength: Too weak';
    
    // Insert after password input
    passwordInput.parentNode.insertBefore(strengthMeter, passwordInput.nextSibling);
    strengthMeter.appendChild(strengthBar);
    strengthMeter.parentNode.insertBefore(strengthText, strengthMeter.nextSibling);
    
    // Password validation criteria
    const criteria = [
        { regex: /.{8,}/, description: 'At least 8 characters' },
        { regex: /[A-Z]/, description: 'At least one uppercase letter' },
        { regex: /[a-z]/, description: 'At least one lowercase letter' },
        { regex: /[0-9]/, description: 'At least one number' },
        { regex: /[^A-Za-z0-9]/, description: 'At least one special character' }
    ];
    
    // Common password patterns to check against
    const commonPatterns = [
        '123456', '123456789', 'qwerty', 'password', '111111', '12345678',
        'abc123', '1234567', 'password1', '12345', '1234567890', 'admin',
        'welcome', 'admin123'
    ];
    
    // Create criteria list
    const criteriaList = document.createElement('ul');
    criteriaList.className = 'mt-2 text-xs space-y-1';
    
    criteria.forEach(criterion => {
        const listItem = document.createElement('li');
        listItem.className = 'flex items-center text-gray-600';
        listItem.innerHTML = `
            <svg class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            ${criterion.description}
        `;
        criteriaList.appendChild(listItem);
    });
    
    // Add one more for personal info
    const personalInfoItem = document.createElement('li');
    personalInfoItem.className = 'flex items-center text-gray-600';
    personalInfoItem.innerHTML = `
        <svg class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        No personal information
    `;
    criteriaList.appendChild(personalInfoItem);
    
    // Add criteria list after strength text
    strengthText.parentNode.insertBefore(criteriaList, strengthText.nextSibling);
    
    // Update password strength on input
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        let feedbackText = '';
        
        // Check each criteria
        criteria.forEach((criterion, index) => {
            const li = criteriaList.children[index];
            const meetsRequirement = criterion.regex.test(password);
            
            if (meetsRequirement) {
                strength += 1;
                li.classList.remove('text-gray-600');
                li.classList.add('text-green-600');
            } else {
                li.classList.remove('text-green-600');
                li.classList.add('text-gray-600');
            }
        });
        
        // Check for personal information
        let containsPersonalInfo = false;
        let personalInfo = [];
        
        if (nameInput && nameInput.value.length > 3) {
            personalInfo.push(nameInput.value.toLowerCase());
        }
        
        if (emailInput && emailInput.value.length > 3) {
            const emailParts = emailInput.value.split('@');
            personalInfo.push(emailParts[0].toLowerCase());
        }
        
        personalInfo.forEach(info => {
            if (info && info.length > 3 && password.toLowerCase().includes(info.toLowerCase())) {
                containsPersonalInfo = true;
            }
        });
        
        const personalInfoLi = criteriaList.children[criteria.length];
        if (!containsPersonalInfo && password.length > 0) {
            strength += 1;
            personalInfoLi.classList.remove('text-gray-600');
            personalInfoLi.classList.add('text-green-600');
        } else if (password.length > 0) {
            personalInfoLi.classList.remove('text-green-600');
            personalInfoLi.classList.add('text-gray-600');
        }
        
        // Check for common passwords
        let isCommonPassword = false;
        commonPatterns.forEach(pattern => {
            if (password.toLowerCase().includes(pattern.toLowerCase())) {
                isCommonPassword = true;
            }
        });
        
        if (isCommonPassword) {
            strength = 1; // Force weak if contains common pattern
        }
        
        // Update strength meter
        const strengthPercentage = password.length > 0 ? (strength / (criteria.length + 1)) * 100 : 0;
        strengthBar.style.width = `${strengthPercentage}%`;
        
        if (strengthPercentage <= 25) {
            strengthBar.className = 'h-full bg-red-500 transition-all duration-300';
            feedbackText = 'Too weak';
        } else if (strengthPercentage <= 50) {
            strengthBar.className = 'h-full bg-orange-500 transition-all duration-300';
            feedbackText = 'Could be stronger';
        } else if (strengthPercentage <= 75) {
            strengthBar.className = 'h-full bg-yellow-500 transition-all duration-300';
            feedbackText = 'Getting better';
        } else {
            strengthBar.className = 'h-full bg-green-500 transition-all duration-300';
            feedbackText = 'Strong password';
        }
        
        strengthText.innerText = `Password strength: ${feedbackText}`;
    });
});