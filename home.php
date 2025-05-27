<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StoryWeave - Collaborative Storywriting Platform</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #6C4AB6;
            --secondary-color: #8D72E1;
            --accent-color: #B9E0FF;
            --light-color: #F8F9FA;
            --dark-color: #212529;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--light-color);
            color: var(--dark-color);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }
        
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-color);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            opacity: 0.15;
        }
        
        .feature-card {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .story-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .story-card:hover {
            transform: translateY(-5px);
        }
        
        .story-card-img {
            height: 200px;
            object-fit: cover;
        }
        
        .story-card-body {
            padding: 1.5rem;
        }
        
        .story-card-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }
        
        .story-card-meta {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .contributor-badge {
            display: inline-block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--accent-color);
            color: var(--primary-color);
            text-align: center;
            line-height: 40px;
            font-weight: bold;
            margin-right: 5px;
        }
        
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 3rem 0;
        }
        
        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.1);
            color: white;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }
        
        .social-icon:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        /* Writing Editor Preview */
        .editor-preview {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .editor-toolbar {
            background-color: #f8f9fa;
            border-radius: 8px 8px 0 0;
            padding: 0.5rem 1rem;
            border-bottom: 1px solid #dee2e6;
        }
        
        .editor-content {
            min-height: 200px;
            padding: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0 0 8px 8px;
            background-color: white;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-section {
                padding: 3rem 0;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">StoryWeave</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#container py-5">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Explore</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-primary" href="login.php">Login</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-primary" href="register.php">Sign Up</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title mb-4">Craft Stories Together</h1>
                    <p class="lead mb-4">StoryWeave is a collaborative platform where writers from around the world come together to create amazing stories, chapter by chapter.</p>
                    
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                   
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="mb-3">Why Choose StoryWeave?</h2>
                <p class="lead text-muted">Powerful features designed for collaborative storytelling</p>
            </div>
            
            <div class="row g-4">
    <div class="col-md-6">
        <div class="feature-card card p-4">
            <div class="text-center">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h4>Real-time Collaboration</h4>
                <p>Write simultaneously with other authors, see changes as they happen, and maintain a seamless creative flow.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="feature-card card p-4">
            <div class="text-center">
                <div class="feature-icon">
                    <i class="fas fa-history"></i>
                </div>
                <h4>Version History</h4>
                <p>Track every change, revert to previous versions, and see the evolution of your story over time.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="feature-card card p-4">
            <div class="text-center">
                <div class="feature-icon">
                    <i class="fas fa-book"></i>
                </div>
                <h4>Story Management</h4>
                <p>Organize your work with chapters, scenes, and character profiles all in one place.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="feature-card card p-4">
            <div class="text-center">
                <div class="feature-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h4>Privacy Controls</h4>
                <p>Choose who can view, edit, or contribute to your stories with customizable permission settings.</p>
            </div>
        </div>
    </div>
</div>

    </section>

    <!-- Popular Stories Section -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="mb-3">Featured Collaborative Stories</h2>
                <p class="lead text-muted">Discover stories created by writers working together</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="story-card card">
                        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" class="story-card-img card-img-top" alt="Fantasy story">
                        <div class="story-card-body">
                            <h5 class="story-card-title">Whispers of the Forgotten</h5>
                            <p class="card-text">A fantasy epic about rediscovering lost magic in a world that has moved on.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="story-card-meta">12 contributors • 24 chapters</small>
                                <span class="badge bg-primary">Fantasy</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="story-card card">
                        <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1453&q=80" class="story-card-img card-img-top" alt="Mystery story">
                        <div class="story-card-body">
                            <h5 class="story-card-title">The Midnight Library</h5>
                            <p class="card-text">A mystery that unfolds within the shelves of a library that only appears at night.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="story-card-meta">8 contributors • 15 chapters</small>
                                <span class="badge bg-success">Mystery</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="story-card card">
                        <img src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1472&q=80" class="story-card-img card-img-top" alt="Sci-fi story">
                        <div class="story-card-body">
                            <h5 class="story-card-title">Neon Horizons</h5>
                            <p class="card-text">A cyberpunk adventure through the neon-lit streets of future megacities.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="story-card-meta">5 contributors • 10 chapters</small>
                                <span class="badge bg-info">Sci-Fi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </section>

            <!-- How It Works Section -->
            <section class="py-5">
            <div class="container py-5">
                <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h2 class="mb-4">How StoryWeave Works</h2>
                    <div class="d-flex mb-4">
                    <div class="me-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <span class="fs-4">1</span>
                        </div>
                    </div>
                    <div>
                        <h5>Start or Join a Story</h5>
                        <p class="text-muted mb-0">Begin your own collaborative project or contribute to existing stories that match your interests.</p>
                    </div>
                    </div>
                    <div class="d-flex mb-4">
                    <div class="me-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <span class="fs-4">2</span>
                            </div>
                        </div>
                        <div>
                            <h5>Write Together</h5>
                            <p class="text-muted mb-0">Collaborate in real-time with other writers, building upon each other's ideas and creativity.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="me-4">
                            <div class="bg-primary bg-opacity-10 text-primary rounded