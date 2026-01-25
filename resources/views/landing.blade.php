<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SICLEAN - Laundry Online Professional</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary: #74b9ff; /* Biru muda */
            --primary-dark: #0984e3; /* Biru lebih gelap */
            --secondary: #a29bfe; /* Ungu */
            --secondary-dark: #6c5ce7; /* Ungu lebih gelap */
            --accent: #fdcb6e; /* Kuning */
            --accent-dark: #e17055; /* Oranye */
            --light: #f8fafc;
            --dark: #2d3436;
            
            --gray: #636e72;
            --success: #00b894;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Animated Background */
        .bg-animation {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            background: linear-gradient(135deg, #74b9ff 0%, #a29bfe 100%);
            opacity: 0.05;
        }
        
        .bg-bubbles {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            overflow: hidden;
        }
        
        .bg-bubbles li {
            position: absolute;
            display: block;
            list-style: none;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            bottom: -160px;
            border-radius: 50%;
            animation: bubble 25s infinite ease-in-out;
        }
        
        .bg-bubbles li:nth-child(1) {
            left: 10%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
            animation-duration: 20s;
            background-color: rgba(116, 185, 255, 0.1);
        }
        
        .bg-bubbles li:nth-child(2) {
            left: 20%;
            width: 20px;
            height: 20px;
            animation-delay: 2s;
            animation-duration: 12s;
            background-color: rgba(162, 155, 254, 0.1);
        }
        
        .bg-bubbles li:nth-child(3) {
            left: 35%;
            width: 50px;
            height: 50px;
            animation-delay: 4s;
            animation-duration: 16s;
            background-color: rgba(253, 203, 110, 0.1);
        }
        
        .bg-bubbles li:nth-child(4) {
            left: 50%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
            animation-duration: 22s;
            background-color: rgba(116, 185, 255, 0.1);
        }
        
        .bg-bubbles li:nth-child(5) {
            left: 55%;
            width: 30px;
            height: 30px;
            animation-delay: 0s;
            animation-duration: 14s;
            background-color: rgba(162, 155, 254, 0.1);
        }
        
        .bg-bubbles li:nth-child(6) {
            left: 65%;
            width: 60px;
            height: 60px;
            animation-delay: 3s;
            animation-duration: 18s;
            background-color: rgba(253, 203, 110, 0.1);
        }
        
        .bg-bubbles li:nth-child(7) {
            left: 70%;
            width: 25px;
            height: 25px;
            animation-delay: 7s;
            animation-duration: 16s;
            background-color: rgba(116, 185, 255, 0.1);
        }
        
        .bg-bubbles li:nth-child(8) {
            left: 80%;
            width: 40px;
            height: 40px;
            animation-delay: 15s;
            animation-duration: 20s;
            background-color: rgba(162, 155, 254, 0.1);
        }
        
        .bg-bubbles li:nth-child(9) {
            left: 90%;
            width: 50px;
            height: 50px;
            animation-delay: 2s;
            animation-duration: 14s;
            background-color: rgba(253, 203, 110, 0.1);
        }
        
        .bg-bubbles li:nth-child(10) {
            left: 25%;
            width: 70px;
            height: 70px;
            animation-delay: 9s;
            animation-duration: 24s;
            background-color: rgba(116, 185, 255, 0.1);
        }
        
        @keyframes bubble {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 50%;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
            }
        }
        
        /* Header & Navigation */
        header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 15px 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        header.scrolled {
            padding: 10px 0;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.15);
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideInLeft 1s ease-out;
        }
        
        .logo-text {
            font-size: 28px;
            font-weight: 700;
            color: white;
            letter-spacing: 1px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .logo-icon {
            font-size: 32px;
            color: var(--accent);
            animation: rotate 10s linear infinite;
        }
        
        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        
        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
            animation: slideInRight 1s ease-out;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 8px 12px;
            border-radius: 5px;
            position: relative;
        }
        
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background-color: var(--accent);
            transform: translateX(-50%);
            transition: width 0.3s ease;
        }
        
        .nav-links a:hover::after {
            width: 80%;
        }
        
        .nav-links a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        
        .login-btn {
            background-color: var(--accent);
            color: var(--dark) !important;
            padding: 10px 20px !important;
            border-radius: 30px;
            font-weight: 600 !important;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--accent-dark) 0%, var(--accent) 100%);
            z-index: -1;
            transition: all 0.3s ease;
            opacity: 0;
        }
        
        .login-btn:hover::before {
            opacity: 1;
        }
        
        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            color: white !important;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, rgba(116, 185, 255, 0.9) 0%, rgba(162, 155, 254, 0.9) 100%), url('https://images.unsplash.com/photo-1581578731548-c64695cc6952?ixlib=rb-4.0.3&auto=format&fit=crop&w=1500&q=80') no-repeat center center/cover;
            color: white;
            text-align: center;
            padding: 100px 20px;
            border-radius: 0 0 30px 30px;
            margin-bottom: 60px;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            animation: pulse 4s infinite alternate;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(0.8);
                opacity: 0.5;
            }
            100% {
                transform: scale(1.2);
                opacity: 0.8;
            }
        }
        
        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: fadeInDown 1s ease-out;
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            animation: fadeInUp 1s ease-out 0.3s both;
        }
        
        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease-out 0.6s both;
        }
        
        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background-color: var(--accent);
            color: var(--dark);
            padding: 15px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .cta-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--accent-dark) 0%, var(--accent) 100%);
            z-index: -1;
            transition: all 0.3s ease;
            opacity: 0;
        }
        
        .cta-btn:hover::before {
            opacity: 1;
        }
        
        .cta-btn.outline {
            background-color: transparent;
            border: 2px solid white;
            color: white;
        }
        
        .cta-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            color: white;
        }
        
        .cta-btn.outline:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        /* Features Section */
        .features {
            padding: 40px 0 80px;
            position: relative;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
            color: var(--primary-dark);
            font-size: 2.5rem;
            position: relative;
            animation: fadeIn 1s ease-out;
        }
        
        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            margin: 15px auto;
            border-radius: 2px;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            transform: translateY(50px);
            opacity: 0;
        }
        
        .feature-card.animated {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }
        
        .feature-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .feature-icon {
            font-size: 60px;
            margin-bottom: 20px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-15px);
            }
            100% {
                transform: translateY(0px);
            }
        }
        
        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--primary-dark);
        }
        
        .feature-card p {
            color: var(--gray);
        }
        
        /* How It Works Section */
        .how-it-works {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
            color: white;
            padding: 80px 0;
            border-radius: 20px;
            margin-bottom: 60px;
            position: relative;
            overflow: hidden;
        }
        
        .how-it-works::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            animation: pulse 4s infinite alternate;
        }
        
        .section-title.white {
            color: white;
        }
        
        .section-title.white::after {
            background: linear-gradient(to right, var(--accent), white);
        }
        
        .steps {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 30px;
            margin-top: 50px;
            position: relative;
            z-index: 1;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            max-width: 250px;
            transform: translateY(50px);
            opacity: 0;
        }
        
        .step.animated {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .step-number {
            background-color: var(--accent);
            color: var(--dark);
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .step:hover .step-number {
            transform: scale(1.1) rotate(10deg);
            background-color: white;
        }
        
        .step h3 {
            font-size: 1.3rem;
            margin-bottom: 15px;
        }
        
        .step p {
            color: rgba(255, 255, 255, 0.9);
        }
        
        /* Pricing Section */
        .pricing {
            padding: 40px 0 80px;
            position: relative;
        }
        
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .pricing-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            transform: translateY(50px);
            opacity: 0;
        }
        
        .pricing-card.animated {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .pricing-card.popular {
            border: 2px solid var(--secondary);
            transform: scale(1.05);
            z-index: 2;
        }
        
        .pricing-card.popular::before {
            content: 'PALING POPULER';
            position: absolute;
            top: 15px;
            right: -30px;
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
            color: white;
            padding: 5px 30px;
            font-size: 12px;
            font-weight: 600;
            transform: rotate(45deg);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .pricing-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .pricing-card.popular:hover {
            transform: scale(1.05) translateY(-15px);
        }
        
        .pricing-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--primary-dark);
        }
        
        .price {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }
        
        .price span {
            font-size: 1rem;
            color: var(--gray);
            -webkit-text-fill-color: var(--gray);
        }
        
        .pricing-features {
            list-style: none;
            margin-bottom: 30px;
        }
        
        .pricing-features li {
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
            color: var(--gray);
        }
        
        .pricing-features li:last-child {
            border-bottom: none;
        }
        
        .pricing-btn {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            width: 100%;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .pricing-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
            z-index: -1;
            transition: all 0.3s ease;
            opacity: 0;
        }
        
        .pricing-btn:hover::before {
            opacity: 1;
        }
        
        .pricing-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        
        /* Testimonials */
        .testimonials {
            background: linear-gradient(135deg, rgba(116, 185, 255, 0.1) 0%, rgba(162, 155, 254, 0.1) 100%);
            padding: 80px 0;
            border-radius: 20px;
            margin-bottom: 60px;
            position: relative;
        }
        
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: relative;
            transform: translateY(50px);
            opacity: 0;
        }
        
        .testimonial-card.animated {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 80px;
            color: rgba(116, 185, 255, 0.1);
            font-family: Georgia, serif;
        }
        
        .testimonial-text {
            font-style: italic;
            margin-bottom: 20px;
            color: var(--gray);
            position: relative;
            z-index: 1;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        .author-details h4 {
            color: var(--primary-dark);
            margin-bottom: 5px;
        }
        
        .author-details p {
            color: var(--gray);
            font-size: 0.9rem;
        }
        
        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--dark) 0%, #2d3436 100%);
            color: white;
            padding: 60px 0 30px;
            position: relative;
            overflow: hidden;
        }
        
        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary), var(--secondary), var(--accent));
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }
        
        .footer-column h3 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            color: var(--accent);
            position: relative;
        }
        
        .footer-column h3::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: var(--accent);
        }
        
        .footer-column ul {
            list-style: none;
        }
        
        .footer-column ul li {
            margin-bottom: 10px;
            transform: translateX(-20px);
            opacity: 0;
        }
        
        .footer-column ul li.animated {
            animation: slideInLeft 0.5s ease-out forwards;
        }
        
        .footer-column ul li a {
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .footer-column ul li a:hover {
            color: white;
            transform: translateX(5px);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #334155;
            color: #94a3b8;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 50%;
            transition: all 0.3s ease;
            transform: translateY(20px);
            opacity: 0;
        }
        
        .social-links a.animated {
            animation: fadeInUp 0.5s ease-out forwards;
        }
        
        .social-links a:nth-child(1) {
            animation-delay: 0.1s;
        }
        
        .social-links a:nth-child(2) {
            animation-delay: 0.2s;
        }
        
        .social-links a:nth-child(3) {
            animation-delay: 0.3s;
        }
        
        .social-links a:nth-child(4) {
            animation-delay: 0.4s;
        }
        
        .social-links a:hover {
            background-color: var(--primary);
            transform: translateY(-5px);
        }
        
        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .nav-links {
                gap: 15px;
            }
            
            .logo-text {
                font-size: 22px;
            }
            
            .steps {
                flex-direction: column;
                align-items: center;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .cta-btn {
                width: 100%;
                justify-content: center;
            }
        }
        
        @media (max-width: 576px) {
            .hero {
                padding: 60px 20px;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .nav-links a:not(.login-btn) {
                display: none;
            }
        }
        
        /* Floating Action Button */
        .fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            z-index: 100;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }
        
        .fab:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
        }
        
        /* Scroll to Top Button */
        .scroll-top {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark);
            font-size: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            z-index: 100;
            transition: all 0.3s ease;
            opacity: 0;
            visibility: hidden;
        }
        
        .scroll-top.active {
            opacity: 1;
            visibility: visible;
        }
        
        .scroll-top:hover {
            transform: translateY(-5px);
            background: var(--accent-dark);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-animation"></div>
    <ul class="bg-bubbles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
    
    <!-- Header & Navigation -->
    <header id="header">
        <div class="container">
            <nav>
                <div class="logo">
                    <span class="logo-icon"><i class="fas fa-tshirt"></i></span>
                    <span class="logo-text">SICLEAN</span>
                </div>
                <div class="nav-links">
                    <a href="#beranda"><i class="fas fa-home"></i> Beranda</a>
                    <a href="#layanan"><i class="fas fa-concierge-bell"></i> Layanan</a>
                    <a href="#harga"><i class="fas fa-tag"></i> Harga</a>
                    <a href="/login" class="login-btn"><i class="fas fa-sign-in-alt"></i> Login</a>
                </div>
            </nav>
        </div>
    </header>
    
    <!-- Hero Section -->
    <section class="hero" id="beranda">
        <div class="container">
            <div class="hero-content">
                <h1>Laundry Kiloan Online? SICLEAN Aja!</h1>
                <p>Kami hadir untuk memudahkan hidup Anda. Cuci, setrika, dan pengeringan pakaian dengan hasil maksimal tanpa perlu keluar rumah.</p>
                <div class="cta-buttons">
                    <a href="/register" class="cta-btn"><i class="fas fa-shopping-cart"></i> Pesan Sekarang</a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="features" id="layanan">
        <div class="container">
            <h2 class="section-title">Layanan Kami</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <h3>Cuci Setrika</h3>
                    <p>Layanan lengkap cuci, kering, dan setrika dengan hasil rapi dan wangi.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-wind"></i>
                    </div>
                    <h3>Cuci Kering</h3>
                    <p>Cuci dan pengeringan tanpa setrika untuk pakaian casual Anda.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-soap"></i>
                    </div>
                    <h3>Setrika Saja</h3>
                    <p>Untuk Anda yang hanya perlu menyetrika pakaian yang sudah kering.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- How It Works Section -->
    <section class="how-it-works">
        <div class="container">
            <h2 class="section-title white">Cara Kerja SICLEAN</h2>
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Pesan Online</h3>
                    <p>Pesan layanan melalui website atau aplikasi kami</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Jemput Laundry</h3>
                    <p>Kurir kami akan menjemput laundry Anda</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Proses Laundry</h3>
                    <p>Laundry diproses secara profesional</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Antar & Bayar</h3>
                    <p>Laundry diantar kembali dan bayar dengan mudah</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Pricing Section -->
    <section class="pricing" id="harga">
        <div class="container">
            <h2 class="section-title">Paket Harga</h2>
            <div class="pricing-grid">
                <div class="pricing-card">
                    <h3>Cuci Kering</h3>
                    <div class="price">Rp 10.000<span>/kg</span></div>
                    <ul class="pricing-features">
                        <li>Cuci bersih dengan deterjen berkualitas</li>
                        <li>Pengeringan dengan mesin dryer</li>
                        <li>Tidak termasuk setrika</li>
                        <li>Minimal order 3 kg</li>
                    </ul>
                    <a href="#pesan" class="pricing-btn">Pesan Sekarang</a>
                </div>
                <div class="pricing-card popular">
                    <h3>Cuci Setrika</h3>
                    <div class="price">Rp 15.000<span>/kg</span></div>
                    <ul class="pricing-features">
                        <li>Cuci bersih dengan deterjen berkualitas</li>
                        <li>Pengeringan dengan mesin dryer</li>
                        <li>Setrika rapi dan wangi</li>
                        <li>Gratis antar-jemput</li>
                        <li>Minimal order 3 kg</li>
                    </ul>
                    <a href="#pesan" class="pricing-btn">Pesan Sekarang</a>
                </div>
                <div class="pricing-card">
                    <h3>Setrika Saja</h3>
                    <div class="price">Rp 8.000<span>/kg</span></div>
                    <ul class="pricing-features">
                        <li>Setrika rapi dan wangi</li>
                        <li>Dilipat dengan rapi</li>
                        <li>Gratis plastik packaging</li>
                        <li>Minimal order 3 kg</li>
                    </ul>
                    <a href="#pesan" class="pricing-btn">Pesan Sekarang</a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <h2 class="section-title">Apa Kata Pelanggan Kami?</h2>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <p class="testimonial-text">"Pelayanan SICLEAN sangat memuaskan! Pakaian saya selalu bersih, wangi, dan rapi. Pengiriman juga tepat waktu."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">R</div>
                        <div class="author-details">
                            <h4>Utin</h4>
                            <p>Pelanggan Setia</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">"Pelayanan SICLEAN sangat memuaskan! Pakaian saya selalu bersih, wangi, dan rapi. Pengiriman juga tepat waktu."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">R</div>
                        <div class="author-details">
                            <h4>Aceng</h4>
                            <p>Pelanggan Tetap</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">"SICLEAN sangat membantu. Sekarang tidak perlu lagi weekend habis untuk laundry."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">A</div>
                        <div class="author-details">
                            <h4>Ujang</h4>
                            <p>Karyawan Swasta</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <div class="container" id="tentang-kami">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>SICLEAN</h3>
                    <p>Layanan laundry online profesional yang mengutamakan kualitas, kecepatan, dan kepuasan pelanggan.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="www.instagram.com/@fallmonarch"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Layanan</h3>
                    <ul>
                        <li><a href="#">Cuci Setrika</a></li>
                        <li><a href="#">Cuci Kering</a></li>
                        <li><a href="#">Setrika Saja</a></li>
                        <li><a href="#">Layanan Khusus</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Link Penting</h3>
                    <ul>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Kontak</h3>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> Jl. Bandung No. 46, Cianjur</li>
                        <li><i class="fas fa-phone"></i> +62 815-7355-1169</li>
                        <li><i class="fas fa-envelope"></i> abay@siclean.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2025 SICLEAN. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>
    
    <!-- Floating Action Button -->
    <div class="fab">
        <i class="fab fa-whatsapp"></i>
    </div>
    
    <!-- Scroll to Top Button -->
    <div class="scroll-top">
        <i class="fas fa-arrow-up"></i>
    </div>
    
    <script>
        // Animasi untuk elemen saat di-scroll
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('header');
            const scrollTop = document.querySelector('.scroll-top');
            const fab = document.querySelector('.fab');
            
            // Header scroll effect
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                    scrollTop.classList.add('active');
                } else {
                    header.classList.remove('scrolled');
                    scrollTop.classList.remove('active');
                }
            });
            
            // Scroll to top functionality
            scrollTop.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
            
            // WhatsApp FAB functionality
            fab.addEventListener('click', function() {
                window.open('https://wa.me/6281573551169', '_blank');
            });
            
            // Animate elements on scroll
            const animatedElements = document.querySelectorAll('.feature-card, .pricing-card, .testimonial-card, .step, .footer-column ul li, .social-links a');
            
            function checkScroll() {
                animatedElements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 1.2;
                    
                    if (elementPosition < screenPosition && !element.classList.contains('animated')) {
                        element.classList.add('animated');
                    }
                });
            }
            
            // Initial check for elements in view
            checkScroll();
            
            // Check on scroll
            window.addEventListener('scroll', checkScroll);
            
            // Smooth scroll untuk anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Add stagger animation to feature cards
            const featureCards = document.querySelectorAll('.feature-card');
            featureCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
            
            // Add stagger animation to pricing cards
            const pricingCards = document.querySelectorAll('.pricing-card');
            pricingCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
            
            // Add stagger animation to testimonial cards
            const testimonialCards = document.querySelectorAll('.testimonial-card');
            testimonialCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
            
            // Add stagger animation to steps
            const steps = document.querySelectorAll('.step');
            steps.forEach((step, index) => {
                step.style.animationDelay = `${index * 0.1}s`;
            });
            
            // Add stagger animation to footer elements
            const footerListItems = document.querySelectorAll('.footer-column ul li');
            footerListItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.05}s`;
            });
        });
    </script>
</body>
</html>