<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Login - Marina Bouregreg</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
        overflow: hidden;
        height: 100vh;
        position: relative;
        background-image: url("{{ asset('build/assets/images/bouregreg.jpg') }}");
        background-size: cover; 
        background-position: center;
        background-repeat: no-repeat;
    }

        /* Animated Background Scene */
        /* .marina-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            background: linear-gradient(180deg, 
                #f5e6d3 0%, 
                #e8d4b8 30%, 
                #d4c4a8 50%, 
                #9bb5d1 70%, 
                #7ea8cc 100%);
        } */


        /* Clouds */
        .cloud {
            position: absolute;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50px;
            opacity: 0.7;
            animation: float 25s ease-in-out infinite;
        }

        .cloud:before {
            content: '';
            position: absolute;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50px;
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
        }

        .mountain-back {
            width: 100%;
            height: 200px;
            background: linear-gradient(45deg, #a8c8e1 0%, #b8d0e8 100%);
            clip-path: polygon(0% 100%, 20% 60%, 35% 80%, 50% 40%, 65% 70%, 80% 50%, 100% 100%);
            opacity: 0.4;
            z-index: 1;
        }

        .mountain-mid {
            width: 100%;
            height: 250px;
            background: linear-gradient(45deg, #8fb8d9 0%, #a5c6dd 100%);
            clip-path: polygon(0% 100%, 15% 70%, 30% 45%, 45% 75%, 60% 35%, 75% 65%, 90% 45%, 100% 100%);
            opacity: 0.6;
            z-index: 2;
        }

        .mountain-front {
            width: 100%;
            height: 180px;
            background: linear-gradient(45deg, #7ea8cc 0%, #8fb4d1 100%);
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
            background: linear-gradient(135deg, #d4b896 0%, #c9ad88 100%);
            position: absolute;
            border-radius: 8px 8px 0 0;
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
            background: linear-gradient(135deg, #e6d4b8 0%, #d4b896 100%);
            border-radius: 50% 50% 0 0;
        }

        /* Water */
        .water {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 45%;
            background: linear-gradient(180deg, #7ea8cc 0%, #6b96c0 50%, #5a87b5 100%);
            z-index: 5;
            opacity: 0.8;
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
            background: linear-gradient(135deg, #2c5f8a 0%, #1e4a6b 100%);
            border-radius: 0 0 30px 30px;
            position: relative;
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
            border-bottom: 45px solid #1e4a6b;
            animation: sail-flutter 4s ease-in-out infinite;
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
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);          
    -webkit-backdrop-filter: blur(10px); 
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 24px;
    padding: 3rem;
    width: 100%;
    max-width: 420px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    position: relative;
}



        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .marina-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c5f8a;
            letter-spacing: 4px;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .marina-subtitle {
            font-size: 1rem;
            font-weight: 400;
            color: #4a7ba7;
            letter-spacing: 6px;
            margin-bottom: 1rem;
        }

        .login-subtitle {
            color: #6b7280;
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.375rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-input:focus {
            outline: none;
            border-color: #2c5f8a;
            box-shadow: 0 0 0 3px rgba(44, 95, 138, 0.1);
            background: rgba(255, 255, 255, 1);
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
        }

        .remember-me label {
            font-size: 0.875rem;
            color: #6b7280;
            cursor: pointer;
        }

        .form-footer {
            display: flex;
            items-center: space-between;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .forgot-password {
            color: #2c5f8a;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .forgot-password:hover {
            color: #1e4a6b;
            text-decoration: underline;
        }

        .login-button {
            background: linear-gradient(135deg, #2c5f8a 0%, #1e4a6b 100%);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
            min-width: 120px;
        }

        .login-button:hover {
            background: linear-gradient(135deg, #1e4a6b 0%, #2c5f8a 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(44, 95, 138, 0.3);
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
        }

        @media (max-width: 480px) {
            .sailboat {
                left: 15%;
                transform: scale(0.7);
            }
        }

        .marina-logo {
    display: block;
    margin: 0 auto 1.5rem auto; /* center + bottom spacing */
    width: 150px;
    max-width: 80%;
    height: auto;
}

        
    </style>
</head>
<body>
    {{-- <div class="marina-background">
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
    </div> --}}

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="{{ asset('build/assets/images/logo-marina-dark1.png') }}" 
     class="marina-logo mx-auto mb-6 w-32 sm:w-40 md:w-48 lg:w-56 h-auto" 
     alt="Marina Logo"/>

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
                    <input id="password"
                           class="form-input"
                           type="password"
                           name="password"
                           required 
                           autocomplete="current-password" />
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
</body>
</html>