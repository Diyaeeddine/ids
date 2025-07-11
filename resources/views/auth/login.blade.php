<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    {{-- <link href="https://cdn.tailwindcss.com" rel="stylesheet"> --}}

    <title>Login - Marina Bouregreg</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            /* Light theme colors */
            --bg-primary: #f8fafc;
            --bg-secondary: rgba(255, 255, 255, 0.95);
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --text-accent: #2c5f8a;
            --border-color: #e5e7eb;
            --border-focus: #2c5f8a;
            --input-bg: rgba(255, 255, 255, 0.9);
            --input-bg-focus: rgba(255, 255, 255, 1);
            --shadow-color: rgba(0, 0, 0, 0.25);
            --backdrop-blur: blur(10px);
            
            /* Marina background colors */
            --marina-bg-start: rgb(176, 214, 242);
            --marina-bg-mid1: #e8d4b8;
            --marina-bg-mid2: rgb(230, 192, 127);
            --marina-bg-mid3: #9bb5d1;
            --marina-bg-end: #7ea8cc;
            
            /* Water colors */
            --water-start: #7ea8cc;
            --water-mid: #6b96c0;
            --water-end: #5a87b5;
            
            /* Element colors */
            --cloud-color: rgba(255, 255, 255, 0.6);
            --mountain-back: linear-gradient(45deg, #a8c8e1 0%, #b8d0e8 100%);
            --mountain-mid: linear-gradient(45deg, #8fb8d9 0%, #a5c6dd 100%);
            --mountain-front: linear-gradient(45deg, #7ea8cc 0%, #8fb4d1 100%);
            --castle-color: linear-gradient(135deg, #d4b896 0%, #c9ad88 100%);
            --castle-top: linear-gradient(135deg, #e6d4b8 0%, #d4b896 100%);
            --boat-hull: linear-gradient(135deg, #2c5f8a 0%, #1e4a6b 100%);
            --boat-sail: #1e4a6b;
        }

        [data-theme="dark"] {
            /* This will be used only for manual override if needed */
            --bg-primary: #0f172a;
            --bg-secondary: rgba(30, 41, 59, 0.95);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-accent: #60a5fa;
            --border-color: #334155;
            --border-focus: #60a5fa;
            --input-bg: rgba(51, 65, 85, 0.8);
            --input-bg-focus: rgba(51, 65, 85, 1);
            --shadow-color: rgba(0, 0, 0, 0.5);
            
            /* Marina background colors - darker */
            --marina-bg-start: rgb(30, 58, 84);
            --marina-bg-mid1: #2d3748;
            --marina-bg-mid2: rgb(45, 55, 72);
            --marina-bg-mid3: #2a4365;
            --marina-bg-end: #1a365d;
            
            /* Water colors - darker */
            --water-start: #1a365d;
            --water-mid: #2c5282;
            --water-end: #2a4365;
            
            /* Element colors - darker */
            --cloud-color: rgba(148, 163, 184, 0.3);
            --mountain-back: linear-gradient(45deg, #334155 0%, #475569 100%);
            --mountain-mid: linear-gradient(45deg, #1e293b 0%, #334155 100%);
            --mountain-front: linear-gradient(45deg, #0f172a 0%, #1e293b 100%);
            --castle-color: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            --castle-top: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
            --boat-hull: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
            --boat-sail: #3b82f6;
        }

        body {
            overflow: hidden;
            height: 100vh;
            position: relative;
            background-image: url("{{ asset('build/assets/images/bouregreg.jpg') }}");
            background-size: cover; 
            background-position: center;
            background-repeat: no-repeat;
            background-color: var(--bg-primary);
            transition: background-color 0.3s ease;
        }

        /* Auto theme detection based on system preference */
        @media (prefers-color-scheme: dark) {
            :root {
                /* Dark theme colors */
                --bg-primary: #0f172a;
                --bg-secondary: rgba(30, 41, 59, 0.95);
                --text-primary: #f8fafc;
                --text-secondary: #94a3b8;
                --text-accent: #60a5fa;
                --border-color: #334155;
                --border-focus: #60a5fa;
                --input-bg: rgba(51, 65, 85, 0.8);
                --input-bg-focus: rgba(51, 65, 85, 1);
                --shadow-color: rgba(0, 0, 0, 0.5);
                
                /* Marina background colors - darker */
                --marina-bg-start: rgb(30, 58, 84);
                --marina-bg-mid1: #2d3748;
                --marina-bg-mid2: rgb(45, 55, 72);
                --marina-bg-mid3: #2a4365;
                --marina-bg-end: #1a365d;
                
                /* Water colors - darker */
                --water-start: #1a365d;
                --water-mid: #2c5282;
                --water-end: #2a4365;
                
                /* Element colors - darker */
                --cloud-color: rgba(148, 163, 184, 0.3);
                --mountain-back: linear-gradient(45deg, #334155 0%, #475569 100%);
                --mountain-mid: linear-gradient(45deg, #1e293b 0%, #334155 100%);
                --mountain-front: linear-gradient(45deg, #0f172a 0%, #1e293b 100%);
                --castle-color: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
                --castle-top: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
                --boat-hull: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
                --boat-sail: #3b82f6;
            }
        }

        .marina-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            background: linear-gradient(180deg, 
                var(--marina-bg-start) 0%, 
                var(--marina-bg-mid1) 30%, 
                var(--marina-bg-mid2) 50%, 
                var(--marina-bg-mid3) 70%, 
                var(--marina-bg-end) 100%);
            transition: all 0.3s ease;
        }

        /* Theme Toggle Button - Hidden since we use system preference */
        .theme-toggle {
            display: none;
        }

        /* Clouds */
        .cloud {
            position: absolute;
            background: var(--cloud-color);
            border-radius: 50px;
            opacity: 0.7;
            animation: float 25s ease-in-out infinite;
            transition: background 0.3s ease;
        }

        .cloud:before {
            content: '';
            position: absolute;
            background: var(--cloud-color);
            border-radius: 50px;
            transition: background 0.3s ease;
        }

        .cloud1 {
            width: 80px;
            height: 40px;
            top: 8%;
            left: 15%;
            animation-delay: 0s;
        }

        .cloud1:before {
            width: 50px;
            height: 50px;
            top: -25px;
            left: 10px;
        }

        .cloud2 {
            width: 60px;
            height: 30px;
            top: 12%;
            right: 20%;
            animation-delay: -10s;
        }

        .cloud2:before {
            width: 40px;
            height: 40px;
            top: -20px;
            right: 15px;
        }

        .cloud3 {
            width: 70px;
            height: 35px;
            top: 15%;
            left: 60%;
            animation-delay: -18s;
        }

        .cloud3:before {
            width: 45px;
            height: 45px;
            top: -22px;
            left: 15px;
        }

        /* Mountains */
        .mountain {
            position: absolute;
            bottom: 40%;
            transition: all 0.3s ease;
        }

        .mountain-back {
            width: 100%;
            height: 200px;
            background: var(--mountain-back);
            clip-path: polygon(0% 100%, 20% 60%, 35% 80%, 50% 40%, 65% 70%, 80% 50%, 100% 100%);
            opacity: 0.4;
            z-index: 1;
        }

        .mountain-mid {
            width: 100%;
            height: 250px;
            background: var(--mountain-mid);
            clip-path: polygon(0% 100%, 15% 70%, 30% 45%, 45% 75%, 60% 35%, 75% 65%, 90% 45%, 100% 100%);
            opacity: 0.6;
            z-index: 2;
        }

        .mountain-front {
            width: 100%;
            height: 180px;
            background: var(--mountain-front);
            clip-path: polygon(0% 100%, 25% 55%, 40% 80%, 55% 30%, 70% 60%, 85% 40%, 100% 100%);
            opacity: 0.5;
            z-index: 3;
        }

        /* Castle Towers */
        .castle {
            position: absolute;
            right: 20%;
            bottom: 45%;
            z-index: 4;
            opacity: 0.7;
        }

        .tower {
            background: var(--castle-color);
            position: absolute;
            border-radius: 8px 8px 0 0;
            transition: background 0.3s ease;
        }

        .tower1 {
            width: 40px;
            height: 120px;
            right: 0;
        }

        .tower2 {
            width: 35px;
            height: 100px;
            right: 60px;
            bottom: 0;
        }

        .tower-top {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 25px;
            background: var(--castle-top);
            border-radius: 50% 50% 0 0;
            transition: background 0.3s ease;
        }

        /* Water */
        .water {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 45%;
            background: linear-gradient(180deg, var(--water-start) 0%, var(--water-mid) 50%, var(--water-end) 100%);
            z-index: 5;
            opacity: 0.8;
            transition: background 0.3s ease;
        }

        /* Water waves */
        .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 200%;
            height: 80px;
            background: url("data:image/svg+xml,%3Csvg viewBox='0 0 120 28' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0,20 Q30,5 60,20 T120,20 V28 H0 Z' fill='rgba(255,255,255,0.08)'/%3E%3C/svg%3E") repeat-x;
            animation: wave 4s ease-in-out infinite;
        }

        .wave:nth-child(2) {
            bottom: 10px;
            animation: wave 5s ease-in-out infinite reverse;
            opacity: 0.6;
        }

        /* Sailboat */
        .sailboat {
            position: absolute;
            bottom: 52%;
            left: 25%;
            z-index: 6;
            opacity: 0.7;
            animation: boat-sway 6s ease-in-out infinite;
        }

        .boat-hull {
            width: 60px;
            height: 20px;
            background: var(--boat-hull);
            border-radius: 0 0 30px 30px;
            position: relative;
            transition: background 0.3s ease;
        }

        .mast {
            position: absolute;
            left: 28px;
            bottom: 20px;
            width: 2px;
            height: 45px;
            background: #8b7355;
        }

        .sail {
            position: absolute;
            left: -18px;
            bottom: 65px;
            width: 0;
            height: 0;
            border-left: 18px solid transparent;
            border-right: 18px solid transparent;
            border-bottom: 45px solid var(--boat-sail);
            animation: sail-flutter 4s ease-in-out infinite;
            transition: border-bottom-color 0.3s ease;
        }

        /* Main Content Container */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            z-index: 10;
        }

        .login-card {
            background: var(--bg-secondary);
            backdrop-filter: var(--backdrop-blur);
            -webkit-backdrop-filter: var(--backdrop-blur);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 3rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 50px -12px var(--shadow-color);
            position: relative;
            transition: all 0.3s ease;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .marina-logo {
            width: 150px;
            max-width: 80%;
            margin: 0 auto;
            height: auto;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.375rem;
            transition: color 0.3s ease;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: var(--input-bg);
            color: var(--text-primary);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
            background: var(--input-bg-focus);
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--text-secondary);
            transition: color 0.3s ease;
        }

        .toggle-password-icon:hover {
            color: var(--text-accent);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 0.375rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }

        .remember-me input {
            margin-right: 0.5rem;
            border-radius: 4px;
            accent-color: var(--text-accent);
        }

        .remember-me label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .forgot-password {
            color: var(--text-accent);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            text-decoration: underline;
            opacity: 0.8;
        }

        .login-button {
            background: linear-gradient(135deg, var(--text-accent) 0%, #1e40af 100%);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .login-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(96, 165, 250, 0.3);
        }

        .login-button:active {
            transform: translateY(0);
        }

        /* Status Message */
        .status-message {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            color: #166534;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        @media (prefers-color-scheme: dark) {
            .status-message {
                background: rgba(34, 197, 94, 0.2);
                border-color: rgba(34, 197, 94, 0.3);
                color: #22c55e;
            }
        }

        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateX(0px) translateY(0px); }
            33% { transform: translateX(30px) translateY(-10px); }
            66% { transform: translateX(-20px) translateY(5px); }
        }

        @keyframes wave {
            0%, 100% { transform: translateX(0px) translateY(0px); }
            50% { transform: translateX(-50px) translateY(-3px); }
        }

        @keyframes boat-sway {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-6px) rotate(0.5deg); }
            50% { transform: translateY(-3px) rotate(0deg); }
            75% { transform: translateY(-8px) rotate(-0.5deg); }
        }

        @keyframes sail-flutter {
            0%, 100% { transform: skewX(0deg); }
            50% { transform: skewX(3deg); }
        }

        /* Responsive Design */
        @media (max-width: 640px) {
            .login-card {
                margin: 1rem;
                padding: 2rem;
            }
            
            .marina-title {
                font-size: 2rem;
                letter-spacing: 2px;
            }
            
            .marina-subtitle {
                font-size: 0.875rem;
                letter-spacing: 4px;
            }
            
            .form-footer {
                flex-direction: column;
                align-items: stretch;
            }
            
            .login-button {
                width: 100%;
            }

            .theme-toggle {
                width: 45px;
                height: 45px;
                top: 15px;
                right: 15px;
            }
        }

        @media (max-width: 480px) {
            .sailboat {
                left: 15%;
                transform: scale(0.7);
            }
        }
.logo-light {
    display: block;
}

.logo-dark {
    display: none;
}

@media (prefers-color-scheme: dark) {
    .logo-light {
        display: none;
    }
    
    .logo-dark {
        display: block;
    }
}

[data-theme="dark"] .logo-light {
    display: none;
}

[data-theme="dark"] .logo-dark {
    display: block;
}
    </style>
</head>
<body>


    <div class="marina-background">
        <div class="cloud cloud1"></div>
        <div class="cloud cloud2"></div>
        <div class="cloud cloud3"></div>
        
        <div class="mountain mountain-back"></div>
        <div class="mountain mountain-mid"></div>
        <div class="mountain mountain-front"></div>
        
        <div class="castle">
            <div class="tower tower1">
                <div class="tower-top"></div>
            </div>
            <div class="tower tower2">
                <div class="tower-top"></div>
            </div>
        </div>
        
        <div class="water">
            <div class="wave"></div>
            <div class="wave"></div>
        </div>
        
        <div class="sailboat">
            <div class="sail"></div>
            <div class="mast"></div>
            <div class="boat-hull"></div>
        </div>
    </div>

    <div class="login-container">
        <div class="login-card">
<!-- Remplacez cette section -->
<div class="login-header">
    <img src="{{ asset('build/assets/images/marina-logo-black.png') }}"
         class="marina-logo logo-light"
         alt="Marina Logo">

    <img src="{{ asset('build/assets/images/marina-logo-white.png') }}"
         class="marina-logo logo-dark"
         alt="Marina Logo (Dark)">
</div>

            @if (session('status'))
                <div class="status-message">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" 
                           class="form-input" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           autocomplete="username" />
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <div class="password-wrapper">
                        <input id="password" 
                               class="form-input" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="current-password"/>
                        <span id="togglePassword" class="toggle-password-icon">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-me">
                    <input id="remember_me" 
                           type="checkbox" 
                           name="remember">
                    <label for="remember_me">{{ __('Remember me') }}</label>
                </div>

                <div class="form-footer">
                    @if (Route::has('password.request'))
                        <a class="forgot-password" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <button type="submit" class="login-button">
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Password toggle functionality
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const eyeIcon = togglePassword.querySelector('i');

            togglePassword.addEventListener('click', function (e) {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);

                if (type === 'password') {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                } else {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                }
            });
        });
    </script>
</body>
</html>