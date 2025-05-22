<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeakForm - Your Personalized Path to Peak Performance</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/830b39c5c0.js" crossorigin="anonymous"></script>

</head>
<body>
    <div id = "header">
        <nav>
           <img src="images/logo_9.png" class = "logo">
            <ul class="nav-list">
                <li><a href="#about"><img src="images/About.png"></a><div class="tooltip-text">Abouts<div></li>
                <li><a href="#features"><img src="images/Features.png"><div class="tooltip-text">Features<div></a></li>
                <li><a href="#FAQs"><img src="images/FAQs.png"><div class="tooltip-text">FAQs<div></a></li>
                <li>
                    <a href="{{ route('login') }}" class="login-btn" style="top:-0.2rem; margin-left:4rem; margin-right: 2.5rem;" >
                        <button style="background: none; border: none; padding: 0; margin: 0;"><img src="images/LogIn-btn.png" ></button>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    
    <div id="header-text">
        <div class="container">
            <div class="row">
                <div class="col_1">
                    <h1>Your Personalized Path <br> to Peak Performance.</h1>
                    <p>Unlock your full potential with PeakForm’s personalized fitness and <br> nutrition plans. 
                        From adaptive workouts to easy meal suggestions,
                    <br> everything you need to succeed is at your fingertips.</p>
                    <a href="{{ route('register') }}">
                        <button>Register</button>
                    </a>
                </div>
                <div class="col_2">
                    <img src="images/workout-1.png">
                </div>
            </div>
        </div>

        <a class="button-up" href="#header" style="display: none;"> <i class="fa-solid fa-arrow-up"></i> </a>

    </div>
    

    <div id="about">
        <h2>About</h2>
        <div class="container_2">
            <div class="row_2">
                <div class="col_3">
                    <img src="images/phone_left.png">
                </div>
                <div class="col_4">
                    <p class = "p1"> PeakForm is a web-based <b> gym split and meal planner </b> designed to help fitness enthusiasts and 
                        beginners optimize their workout routines and nutrition. Our platform provides personalized 
                        gym split schedules and meal plans tailored to your fitness goals and dietary preferences.</p>
                    <p class = "p2">With an <b>intuitive interface, progress tracking, and expert-backed recommendations, </b> PeakForm 
                        ensures that users stay on track and make informed decisions for a healthier lifestyle. 
                        Take the guesswork out of fitness planning achieve your peak form with PeakForm!</p>
                </div>
                <div class="col_5">
                    <img src="images/phone_right.png">
                </div>
            </div>
            <img src='images/bowl_v2.png' id = "bowl_v2">
        </div>
    </div>
    

    <div id="features">
        <h2>Features</h2>
        <div class="container_3">
            <div class="row_3">
                <div class="col_6">
                    <img src="images/planner.png">
                    <h3>Customizable Gym Split Planner</h3>
                    <p>Create personalized workout routines tailored to fitness goals, training frequency, 
                        and muscle recovery needs.</p>
                </div>
                <div class="col_7">
                    <img src="images/exercise.png">
                    <h3>Workout / Exercise Generator</h3>
                    <p>Get automatically generated workouts based on user preferences, fitness levels, and
                     targeted muscle groups.</p>
                </div>
                <div class="col_8">
                    <img src="images/tracker.png">
                    <h3>Progress Tracker</h3>
                    <p>Monitor workout performance, strength gains, and fitness progress over time with 
                        visual insights and analytics.</p>
                </div>
                <div class="col_9">
                    <img src="images/meal_planner.png">
                    <h3>Personalized Meal Planner</h3>
                    <p>Generate customized meal plans that align with dietary needs, fitness goals, 
                    and calorie requirements.</p>
                </div>
            </div>
            <div class="row_4">
                <div class="col_10">
                    <img src="images/protein.png">
                    <h3>Daily Protein Intake Recommendation</h3>
                    <p>Receive tailored protein intake suggestions based on body weight, fitness goals, 
                        and workout intensity.</p>
                </div>
                <div class="col_11">
                    <img src="images/muscle.png">
                    <h3>Muscle Recovery and Injury Prevention Tips</h3>
                    <p>Gain expert advice on post-workout recovery, stretching routines, and injury prevention 
                    strategies.</p>
                </div>
                <div class="col_12">
                    <img src="images/meal_tracker.png">
                    <h3>Food Intake Tracker</h3>
                    <p>Log daily food consumption to track calorie intake and maintain a balanced diet for optimal 
                    fitness results.</p>
                </div>
                <div class="col_13">
                    <img src="images/video.png">
                    <h3>Exercise Video Guide</h3>
                    <p>Access a library of instructional workout videos to ensure proper form, technique, and injury
                     prevention.</p>
                </div>
            </div>
        </div>
    </div>
    

 <div id="FAQs">
     <div class="faq-container">
        <h2>Frequently Asked Questions</h2>

        <div class="faq-item">
            <div class="faq-question">What is PeakForm?</div>
            <div class="faq-answer">PeakForm is a web-based workout split and meal planner designed to help you achieve your fitness goals through customized plans.</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">Is PeakForm free to use?</div>
            <div class="faq-answer">Yes, PeakForm offers a free version with core features. Premium features may be available with a subscription.</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">Do I need to create an account to use PeakForm? </div>
            <div class="faq-answer">Yes, creating an account allows you to save your progress, access personalized plans, and sync across devices. </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">How are the workout splits created? </div>
            <div class="faq-answer">Workout splits are generated based on your selected goals, experience level, and available days for training.</div>
        </div>


        <div class="faq-item">
            <div class="faq-question">Can I track my progress with PeakForm?</div>
            <div class="faq-answer">Yes, you can log your workouts and meals, and monitor your progress over time through visual graphs and statistics.</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">Can I customize my workout split?</div>
            <div class="faq-answer">Absolutely. PeakForm lets you create and edit workout splits to match your specific fitness goals and schedule.</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">How often should I update my plan?</div>
            <div class="faq-answer">We recommend updating your workout and meal plan every 4–6 weeks to keep progressing and avoid plateaus.</div>
        </div>
    </div>
</div>

    <footer>
        <div id="footer_things">
            <p>&copy; 2025 PeakForm. All rights reserved.</p>
            <div class="social-links">
                <a href="https://www.instagram.com/"><img src="images/instagram.png" alt="Instagram"></a>
                <a href="https://x.com/?lang=en"><img src="images/twitter.png" alt="Twitter"></a>
                <a href="https://www.facebook.com/"><img src="images/facebook.png" alt="Facebook"></a>
            </div>
        </div>
    </footer>



    <script src="script.js"></script>
    <script>
  document.addEventListener("DOMContentLoaded", function () {
    const button = document.querySelector(".button-up");
    const trigger = document.getElementById("about");

    window.addEventListener("scroll", () => {
      const triggerTop = trigger.getBoundingClientRect().top;
      const windowHeight = window.innerHeight;

      // Show if we've scrolled past the trigger element
      if (triggerTop <= windowHeight - 100) {
        button.style.display = "block";
      } else {
        button.style.display = "none";
      }

      if (triggerTop <= windowHeight - 100) {
        button.classList.add("visible");
        } else {
         button.classList.remove("visible");
        }
    });
  });
</script>

</body>
</html>