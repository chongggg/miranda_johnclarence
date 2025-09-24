<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management - Authentication</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: "Inter", sans-serif;
        }

        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(18px) saturate(180%);
            -webkit-backdrop-filter: blur(18px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .form-input {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .form-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(59, 130, 246, 0.6);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            transform: translateY(-2px);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-label {
            transition: all 0.3s ease;
        }

        .form-input:focus + .form-label,
        .form-input:not(:placeholder-shown) + .form-label {
            transform: translateY(-28px) scale(0.85);
            color: #60a5fa;
            font-weight: 600;
            background: rgba(30, 41, 59, 0.8);
            padding: 0 8px;
            border-radius: 4px;
        }

        .toggle-btn {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(18px) saturate(180%);
            -webkit-backdrop-filter: blur(18px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.25s ease;
        }

        .toggle-btn:hover {
            background: rgba(59, 130, 246, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(59, 130, 246, 0.25);
        }

        .toggle-btn.active {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
            transform: translateY(-2px);
        }

        .submit-btn {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            transition: all 0.25s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        .submit-btn:active {
            transform: scale(0.98);
        }

        .fade-in {
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(20px);
            }
            to { 
                opacity: 1; 
                transform: translateY(0);
            }
        }

        .error-message {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.4);
            backdrop-filter: blur(10px);
        }

        .success-message {
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.4);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-950 to-black text-white">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/10 backdrop-blur-md shadow-lg z-50">
        <div class="max-w-6xl mx-auto px-6 py-3 flex justify-between items-center">
            <span class="text-xl font-bold tracking-wide">🎓 Student Management</span>
            <div class="text-sm text-gray-300">Authentication Portal</div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center pt-20 pb-12 px-4">
        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-wide bg-gradient-to-r from-blue-400 to-indigo-500 bg-clip-text text-transparent mb-2">
                    Welcome
                </h1>
                <p class="text-gray-300">Access your student management portal</p>
            </div>

            <!-- Form Container -->
            <div class="glassmorphism rounded-2xl shadow-xl overflow-hidden">
                <!-- Toggle Buttons -->
                <div class="flex bg-black/20">
                    <button class="toggle-btn flex-1 py-4 px-6 font-semibold text-white active" onclick="showForm('login')">
                        Sign In
                    </button>
                    <button class="toggle-btn flex-1 py-4 px-6 font-semibold text-white" onclick="showForm('signup')">
                        Sign Up
                    </button>
                </div>

                <!-- Forms Container -->
                <div class="p-8">
                    <!-- Login Form -->
                    <form class="form active fade-in" id="loginForm">
                        <div class="space-y-6">
                            <div class="relative">
                                <input type="email" 
                                       class="form-input w-full px-4 py-3 rounded-lg text-white placeholder-transparent focus:outline-none" 
                                       placeholder="Email Address" 
                                       required>
                                <label class="form-label absolute left-4 top-3 text-gray-300 pointer-events-none">
                                    📧 Email Address
                                </label>
                            </div>

                            <div class="relative">
                                <input type="password" 
                                       class="form-input w-full px-4 py-3 rounded-lg text-white placeholder-transparent focus:outline-none" 
                                       placeholder="Password" 
                                       required>
                                <label class="form-label absolute left-4 top-3 text-gray-300 pointer-events-none">
                                    🔒 Password
                                </label>
                            </div>

                            <button type="submit" class="submit-btn w-full py-3 rounded-lg font-semibold text-white shadow-lg">
                                Sign In
                            </button>

                            <div class="text-center">
                                <a href="#" onclick="showForgotPassword()" class="text-blue-400 hover:text-blue-300 text-sm underline">
                                    Forgot your password?
                                </a>
                            </div>
                        </div>

                        <div class="success-message mt-4 p-3 rounded-lg text-green-200 hidden" id="loginSuccess">
                            ✅ Login successful! Welcome back to Student Management.
                        </div>
                    </form>

                    <!-- Signup Form -->
                    <form class="form fade-in hidden" id="signupForm">
                        <div class="space-y-6">
                            <div class="relative">
                                <input type="text" 
                                       class="form-input w-full px-4 py-3 rounded-lg text-white placeholder-transparent focus:outline-none" 
                                       placeholder="Full Name" 
                                       required>
                                <label class="form-label absolute left-4 top-3 text-gray-300 pointer-events-none">
                                    👤 First Name
                                </label>
                            </div>

                             <div class="relative">
                                <input type="text" 
                                       class="form-input w-full px-4 py-3 rounded-lg text-white placeholder-transparent focus:outline-none" 
                                       placeholder="Full Name" 
                                       required>
                                <label class="form-label absolute left-4 top-3 text-gray-300 pointer-events-none">
                                    👤 Last Name
                                </label>
                            </div>

                            <div class="relative">
                                <input type="email" 
                                       class="form-input w-full px-4 py-3 rounded-lg text-white placeholder-transparent focus:outline-none" 
                                       placeholder="Email Address" 
                                       required>
                                <label class="form-label absolute left-4 top-3 text-gray-300 pointer-events-none">
                                    📧 Email Address
                                </label>
                            </div>

                            <div class="relative">
                                <input type="password" 
                                       class="form-input w-full px-4 py-3 rounded-lg text-white placeholder-transparent focus:outline-none" 
                                       placeholder="Password" 
                                       required>
                                <label class="form-label absolute left-4 top-3 text-gray-300 pointer-events-none">
                                    🔒 Password
                                </label>
                                <div class="error-message mt-2 p-2 rounded text-red-200 text-sm hidden" id="passwordError">
                                    ⚠️ Password must be at least 8 characters long
                                </div>
                            </div>

                            <div class="relative">
                                <input type="password" 
                                       class="form-input w-full px-4 py-3 rounded-lg text-white placeholder-transparent focus:outline-none" 
                                       placeholder="Confirm Password" 
                                       required>
                                <label class="form-label absolute left-4 top-3 text-gray-300 pointer-events-none">
                                    🔒 Confirm Password
                                </label>
                                <div class="error-message mt-2 p-2 rounded text-red-200 text-sm hidden" id="confirmError">
                                    ⚠️ Passwords do not match
                                </div>
                            </div>

                            <button type="submit" class="submit-btn w-full py-3 rounded-lg font-semibold text-white shadow-lg">
                                Create Account
                            </button>
                        </div>

                        <div class="success-message mt-4 p-3 rounded-lg text-green-200 hidden" id="signupSuccess">
                            ✅ Account created successfully! Please check your email to verify your account.
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8 text-gray-400 text-sm">
                <p>© 2024 Student Management System</p>
            </div>
        </div>
    </div>

    <script>
        // Form state management
        let currentForm = 'login';

        // Toggle between forms
        function showForm(formType) {
            const forms = document.querySelectorAll('.form');
            const toggleBtns = document.querySelectorAll('.toggle-btn');
            
            // Remove active class from all forms and buttons
            forms.forEach(form => {
                form.classList.remove('active');
                form.classList.add('hidden');
            });
            toggleBtns.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to selected form and button
            const targetForm = document.getElementById(formType + 'Form');
            targetForm.classList.add('active', 'fade-in');
            targetForm.classList.remove('hidden');
            event.target.classList.add('active');
            
            currentForm = formType;
            
            // Clear any previous messages
            clearMessages();
        }

        // Clear success/error messages
        function clearMessages() {
            const messages = document.querySelectorAll('.success-message, .error-message');
            messages.forEach(msg => {
                msg.classList.add('hidden');
                msg.style.display = 'none';
            });
        }

        // Password validation
        function validatePassword(password) {
            return password.length >= 8;
        }

        // Email validation
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // Handle login form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            clearMessages();
            
            const inputs = this.querySelectorAll('.form-input');
            
            // Basic validation
            let isValid = true;
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = 'rgba(239, 68, 68, 0.6)';
                    input.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.2)';
                } else {
                    input.style.borderColor = 'rgba(255, 255, 255, 0.2)';
                    input.style.boxShadow = 'none';
                }
            });
            
            if (isValid) {
                // Simulate login process
                const submitBtn = this.querySelector('.submit-btn');
                submitBtn.textContent = 'Signing in...';
                submitBtn.disabled = true;
                
                setTimeout(() => {
                    const successMsg = document.getElementById('loginSuccess');
                    successMsg.classList.remove('hidden');
                    successMsg.style.display = 'block';
                    submitBtn.textContent = 'Sign In';
                    submitBtn.disabled = false;
                }, 1000);
            }
        });

        // Handle signup form submission
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            clearMessages();
            
            const inputs = this.querySelectorAll('.form-input');
            const password = inputs[2].value;
            const confirmPassword = inputs[3].value;
            
            let isValid = true;
            
            // Validate all fields are filled
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = 'rgba(239, 68, 68, 0.6)';
                    input.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.2)';
                } else {
                    input.style.borderColor = 'rgba(255, 255, 255, 0.2)';
                    input.style.boxShadow = 'none';
                }
            });
            
            // Validate password strength
            if (!validatePassword(password)) {
                const errorMsg = document.getElementById('passwordError');
                errorMsg.classList.remove('hidden');
                errorMsg.style.display = 'block';
                inputs[2].style.borderColor = 'rgba(239, 68, 68, 0.6)';
                inputs[2].style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.2)';
                isValid = false;
            }
            
            // Validate password match
            if (password !== confirmPassword) {
                const errorMsg = document.getElementById('confirmError');
                errorMsg.classList.remove('hidden');
                errorMsg.style.display = 'block';
                inputs[3].style.borderColor = 'rgba(239, 68, 68, 0.6)';
                inputs[3].style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.2)';
                isValid = false;
            }
            
            if (isValid) {
                // Simulate signup process
                const submitBtn = this.querySelector('.submit-btn');
                submitBtn.textContent = 'Creating account...';
                submitBtn.disabled = true;
                
                setTimeout(() => {
                    const successMsg = document.getElementById('signupSuccess');
                    successMsg.classList.remove('hidden');
                    successMsg.style.display = 'block';
                    submitBtn.textContent = 'Create Account';
                    submitBtn.disabled = false;
                }, 1500);
            }
        });

        // Show forgot password alert
        function showForgotPassword() {
            alert('🔐 Password reset link would be sent to your email address.');
        }

        // Enhanced floating label functionality
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-input');
            
            inputs.forEach(input => {
                // Handle autofill detection
                setTimeout(() => {
                    if (input.value) {
                        input.classList.add('has-value');
                    }
                }, 100);
                
                input.addEventListener('input', function() {
                    if (this.value) {
                        this.classList.add('has-value');
                    } else {
                        this.classList.remove('has-value');
                    }
                });

                input.addEventListener('blur', function() {
                    if (this.value) {
                        this.classList.add('has-value');
                    } else {
                        this.classList.remove('has-value');
                    }
                });
            });
        });

        // Handle browser back/forward buttons
        window.addEventListener('popstate', function(e) {
            window.location.reload();
        });
    </script>
</body>
</html>