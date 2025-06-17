<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noah Waters</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Boogaloo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
        .feedback-section {
        padding: 20px 20px;
        text-align: center;
        margin-top: 50px;
        background-color: rgba(255, 255, 255);
        border-radius: 20px;
        margin-left: 50px;
        margin-right: 50px;
    }

    .feedback-section h2 {
        color: #112752;
        font-size: 2.5rem;
        margin-bottom: 30px;
    }

    .feedback-container {
        display: flex;
        justify-content: space-between;
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .feedback-form {
        flex: 1;
        background: rgba(255, 255, 255);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .feedback-display {
        flex: 1;
        background: rgba(255, 255, 255);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
        text-align: left;
        margin-right: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #112752;
        font-size: 1.1em;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 2px solid #112752;
        border-radius: 8px;
        font-size: 1em;
        font-family: "Boogaloo", sans-serif;
    }

    .form-group textarea {
        height: 120px;
        resize: vertical;
    }

    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }

    .rating input {
        display: none;
    }

    .rating label {
        cursor: pointer;
        font-size: 30px;
        color: #ddd;
        padding: 5px;
    }

    .rating input:checked ~ label,
    .rating label:hover,
    .rating label:hover ~ label {
        color: #ffd700;
    }

    .submit-btn {
        background-color: #112752;
        color: #79c7ff;
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-size: 1.2em;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: "Boogaloo", sans-serif;
    }

    .submit-btn:hover {
        background-color: #1a3a6e;
        transform: translateY(-2px);
    }

    .feedback-list {
        max-height: 400px;
        overflow-y: auto;
        padding: 10px;
    }

    .feedback-item {
        background: white;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 10px;
        text-align: left;
    }

    .feedback-item .name {
        font-weight: bold;
        color: #112752;
        margin-bottom: 5px;
    }

    .feedback-item .rating {
        color: #ffd700;
        margin-bottom: 5px;
    }

    .feedback-item .message {
        color: #333;
        font-size: 0.9em;
    }

    @media (max-width: 768px) {
        .feedback-container {
            flex-direction: column;
        }
    }

    /* Feedback Section Styles */
    #feedback {
        padding: 20px 0;
        background-color: #f8f9fa;
    }

    .feedback-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .feedback-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 20px;
    }

    .feedback-form {
        background: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .feedback-form h3 {
        color: #0f65b4;
        margin-bottom: 15px;
        font-size: 1.5em;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 12px;
    }

    .form-group label {
        display: block;
        margin-bottom: 4px;
        color: #333;
        font-weight: 500;
        font-size: 1.3em;
    }

    .form-control {
        width: 100%;
        padding: 6px 10px;
        border: 1px solid #ddd;
        border-radius: 3px;
        font-size: 1.3em;
    }

    .form-control:focus {
        border-color: #0f65b4;
        outline: none;
        box-shadow: 0 0 0 2px rgba(15,101,180,0.1);
    }

    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 4px;
    }

    .rating input {
        display: none;
    }

    .rating label {
        cursor: pointer;
        font-size: 1.5em;
        color: #ddd;
        transition: color 0.2s;
    }

    .rating label:hover,
    .rating label.hover,
    .rating input:checked + label {
        color: #ffc107;
    }

    .feedback-list {
        background: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        max-height: 350px;
        overflow-y: auto;
    }

    .feedback-list h3 {
        color: #0f65b4;
        margin-bottom: 15px;
        font-size: 1.5em;
        font-weight: 600;
    }

    .feedback-item {
        padding: 12px;
        border-bottom: 1px solid #eee;
        margin-bottom: 12px;
    }

    .feedback-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .feedback-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }

    .feedback-header h4 {
        margin: 0;
        color: #333;
        font-size: 1em;
        font-weight: 500;
    }

    .feedback-item .rating {
        margin: 0;
    }

    .feedback-item .rating label {
        font-size: 1.2em;
    }

    .feedback-item p {
        margin: 6px 0;
        color: #666;
        font-size: 0.9em;
        line-height: 1.4;
    }

    .feedback-item small {
        color: #999;
        font-size: 0.8em;
    }

    .btn-primary {
        background-color: #0f65b4;
        color: white;
        padding: 20px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.8em;
        transition: background-color 0.2s;
    }

    .btn-primary:hover {
        background-color: #0d4f8c;
    }

    .alert {
        padding: 8px 12px;
        margin-bottom: 12px;
        border-radius: 3px;
        font-size: 0.85em;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-info {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    @media (max-width: 768px) {
        .feedback-grid {
            grid-template-columns: 1fr;
        }
        
        .feedback-list {
            max-height: 250px;
        }
    }

    .form-note {
        color: #666;
        font-size: 0.9em;
        margin-bottom: 15px;
        font-style: italic;
    }

    .form-text {
        font-size: 0.85em;
        color: #666;
        margin-top: 4px;
    }

    .text-muted {
        color: #6c757d;
    }
    </style>
</head>

<body>

<nav class="navbar">
        <div class="logo">
            <img src="logo.jpg" class="logo">
        </div>
        <div class="hamburger">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <ul class="nav-menu">
            <li class="nav-item"><a href="#about" class="nav-link">About Us</a></li>
            <li class="nav-item"><a href="#contact" class="nav-link">Contact Us</a></li>
            <li class="nav-item"><a href="track_order_user.php" class="nav-link">My Orders</a></li>
            <li class="nav-item"><a href="admin_orders.php" class="nav-link">Admin Page</a></li>
            <li class="nav-item"><a href="logout.php" class="nav-link">Exit</a></li>
        </ul>
    </nav>

    <div class="content-container">
        <div class="gallon-container">
            <img src="round_gallon.png" class="gallon">
        </div>

        <div class="tagline-container">
            <h1 class="tagline">
                Delivering Purity,<br> One Refill at a Time
            </h1>
        </div>
    </div>

    <div class="button-container">
        <a href="menu.php" class="order-btn" style="text-decoration: none; display: inline-block; text-align: center; padding: 15px 70px; font-size: 1.8rem; background-color: #112752; color: #79c7ff; border: none; border-radius: 30px; cursor: pointer; transition: all 0.3s ease; font-family: 'Boogaloo', sans-serif; box-shadow: inset 4px 4px 4px rgba(0, 0, 0, 0.50);">Order Now</a>
        <div class="auth-buttons">
            <a href="logout.php"><button class="login-btn">Logout</button></a>
        </div>
    </div>

    <div class="background-container">
        <img src="back.webp" class="background">
    </div>

    <div id="feedback" class="feedback-section" style="opacity:0.9">
        <h2>Customer Feedback</h2>
        <div class="feedback-container">
            <div class="feedback-form">
                <h3>Share Your Experience</h3>
                <p class="form-note">* Only customers with previous orders can submit feedback</p>
                <form id="feedbackForm">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="<?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email (used for your order)</label>
                        <input type="email" id="email" name="email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" required>
                        <small class="form-text text-muted">Please use the same email address you used for your order</small>
                    </div>
                    <div class="form-group">
                        <label>Rating</label>
                        <div class="rating">
                            <input type="radio" name="rating" value="5" id="rating5" required>
                            <label for="rating5">★</label>
                            <input type="radio" name="rating" value="4" id="rating4">
                            <label for="rating4">★</label>
                            <input type="radio" name="rating" value="3" id="rating3">
                            <label for="rating3">★</label>
                            <input type="radio" name="rating" value="2" id="rating2">
                            <label for="rating2">★</label>
                            <input type="radio" name="rating" value="1" id="rating1">
                            <label for="rating1">★</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message">Your Feedback</label>
                        <textarea id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn-primary">Submit Feedback</button>
                </form>
            </div>
            <div class="feedback-display">
                <h3>Recent Feedback</h3>
                <div id="feedbackList" class="feedback-list">
                    <!-- Feedback items will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <div id="about" class="about-section">
        <h2>About Us</h2>
        <div class="about-content">
            <div class="about-text">
                <p>Noah Waters, your trusted water refilling station in Halayhay, Tanza, Cavite and around the area. We are committed to providing clean, safe, and pure drinking water to our community.
                    With years of experience in the water purification industry, we ensure that every drop of water we deliver meets the highest standards of quality and safety.</p>
                <div class="features">
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <span>100% Purified Water</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-truck"></i>
                        <span>Fast Delivery</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-shield-alt"></i>
                        <span>Quality Assured</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="contact" class="contact-section">
        <h2>Contact Us</h2>
        <div class="contact-info">
            <div class="contact-item">
                <i class="fas fa-phone"></i>
                <p>(046) 435-8524 | 0936-442-8287</p>
            </div>
            <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <p>noah.waters.station@gmail.com</p>
            </div>
            <div class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <p>084 Brgy. Halayhay, Tanza, Cavite, Philippines</p>
            </div>
        </div>
    </div>

    <script>
        const hamburger = document.querySelector(".hamburger");
        const navMenu = document.querySelector(".nav-menu");

        hamburger.addEventListener("click", () => {
            hamburger.classList.toggle("active");
            navMenu.classList.toggle("active");
        });

        document.querySelectorAll(".nav-link").forEach(n => n.addEventListener("click", () => {
            hamburger.classList.remove("active");
            navMenu.classList.remove("active");
        }));
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const feedbackForm = document.getElementById('feedbackForm');
        const feedbackList = document.getElementById('feedbackList');
        const ratingInputs = document.querySelectorAll('input[name="rating"]');
        const ratingLabels = document.querySelectorAll('.rating label');

        // Handle star rating hover effects
        ratingLabels.forEach((label, index) => {
            label.addEventListener('mouseover', () => {
                for (let i = 0; i <= index; i++) {
                    ratingLabels[i].classList.add('hover');
                }
            });

            label.addEventListener('mouseout', () => {
                ratingLabels.forEach(l => l.classList.remove('hover'));
                const checkedRating = document.querySelector('input[name="rating"]:checked');
                if (checkedRating) {
                    const checkedIndex = Array.from(ratingInputs).indexOf(checkedRating);
                    for (let i = 0; i <= checkedIndex; i++) {
                        ratingLabels[i].classList.add('hover');
                    }
                }
            });
        });

        // Handle rating selection
        ratingInputs.forEach((input, index) => {
            input.addEventListener('change', () => {
                ratingLabels.forEach(l => l.classList.remove('hover'));
                for (let i = 0; i <= index; i++) {
                    ratingLabels[i].classList.add('hover');
                }
            });
        });

        // Handle form submission
        feedbackForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            
            // Disable submit button and show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

            fetch('submit_feedback.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    const successMessage = document.createElement('div');
                    successMessage.className = 'alert alert-success';
                    successMessage.innerHTML = data.message;
                    feedbackForm.insertAdjacentElement('beforebegin', successMessage);
                    
                    // Reset form
                    feedbackForm.reset();
                    ratingLabels.forEach(l => l.classList.remove('hover'));
                    
                    // Remove success message after 3 seconds
                    setTimeout(() => {
                        successMessage.remove();
                    }, 3000);
                    
                    // Refresh feedback list
                    loadFeedback();
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                // Show error message
                const errorMessage = document.createElement('div');
                errorMessage.className = 'alert alert-danger';
                errorMessage.innerHTML = error.message || 'An error occurred. Please try again.';
                feedbackForm.insertAdjacentElement('beforebegin', errorMessage);
                
                // Remove error message after 3 seconds
                setTimeout(() => {
                    errorMessage.remove();
                }, 3000);
            })
            .finally(() => {
                // Re-enable submit button
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            });
        });

        // Function to load feedback
        function loadFeedback() {
            fetch('get_feedback.php')
                .then(response => response.json())
                .then(data => {
                    console.log('Feedback data:', data); // Debug log
                    
                    if (data.success) {
                        feedbackList.innerHTML = '';
                        
                        if (data.feedback.length === 0) {
                            feedbackList.innerHTML = `
                                <div class="alert alert-info">
                                    No feedback available yet. Be the first to share your thoughts!
                                </div>
                            `;
                            return;
                        }
                        
                        data.feedback.forEach(item => {
                            const feedbackItem = document.createElement('div');
                            feedbackItem.className = 'feedback-item';
                            
                            // Create stars HTML
                            const stars = Array(5).fill('').map((_, i) => 
                                `<i class="fas fa-star ${i < item.rating ? 'active' : ''}"></i>`
                            ).join('');
                            
                            feedbackItem.innerHTML = `
                                <div class="feedback-header">
                                    <h4>${item.name}</h4>
                                    <div class="rating">${stars}</div>
                                </div>
                                <p>${item.message}</p>
                                <small>${item.date}</small>
                            `;
                            
                            feedbackList.appendChild(feedbackItem);
                        });
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading feedback:', error); // Debug log
                    feedbackList.innerHTML = `
                        <div class="alert alert-danger">
                            ${error.message || 'Error loading feedback. Please try again later.'}
                        </div>
                    `;
                });
        }

        // Load feedback when page loads
        loadFeedback();
    });
    </script>
</body>
</html>