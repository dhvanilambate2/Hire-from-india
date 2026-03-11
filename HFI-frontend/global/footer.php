<footer class="footer">
        <div class="container">
            <div class="row">
                <!-- Employers Column -->
                <div class="col-lg-2 col-md-4 col-sm-6 col-12 footer-column">
                    <h3>EMPLOYERS</h3>
                    <ul>
                        <li><a href="/hirefromindia/pages/how/employer.php">How it works</a></li>
                        <li><a href="#">Register</a></li>
                        <li><a href="#">Post a Job</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Real Results</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Timeproof</a></li>
                    </ul>
                </div>

                <!-- Workers Column -->
                <div class="col-lg-2 col-md-4 col-sm-6 col-12 footer-column">
                    <h3>WORKERS</h3>
                    <ul>
                        <li><a href="/hirefromindia/pages/how/jobseeker.php">How it works</a></li>
                        <li><a href="#">Register</a></li>
                        <li><a href="/hirefromindia/pages/jobseekers/jobsearch.php">Job Search</a></li>
                        <li><a href="#">Employer Search</a></li>
                        <li><a href="#">Behind the Screen</a></li>
                    </ul>
                </div>

                <!-- Talented VA's Column -->
                <div class="col-lg-2 col-md-4 col-sm-6 col-12 footer-column">
                    <h3>TALENTED VA'S</h3>
                    <ul>
                        <li><a href="#">Virtual Assistant</a></li>
                        <li><a href="#">SEO Experts</a></li>
                        <li><a href="#">WordPress Experts</a></li>
                        <li><a href="#">Social Media Managers</a></li>
                        <li><a href="#">Video Editors</a></li>
                        <li><a href="#">Real Estate Experts</a></li>
                        <li><a href="#">Article Writers</a></li>
                        <li><a href="#">Amazon Experts</a></li>
                        <li><a href="#">Graphic Designers</a></li>
                        <li><a href="#">Shopify Experts</a></li>
                        <li><a href="#">Advanced VA Search</a></li>
                    </ul>
                </div>

                <!-- Other Goods Column -->
                <div class="col-lg-2 col-md-4 col-sm-6 col-12 footer-column">
                    <h3>OTHER GOODS</h3>
                    <ul>
                        <li><a href="#">Press</a></li>
                        <li><a href="/hirefromindia/pages/affiliate.php">Affiliates</a></li>
                        <li><a href="/hirefromindia/pages/about-us.php">About Us</a></li>
                        <li><a href="/hirefromindia/pages/contact-us.php">Contact Us</a></li>
                        <li><a href="/hirefromindia/pages/privacy.php">Privacy Policy</a></li>
                        <li><a href="/hirefromindia/pages/terms.php">Terms of Use</a></li>
                        <li><a href="#" class="spread-word">SPREAD THE WORD</a></li>
                    </ul>
                </div>

                <!-- Contact Us Column -->
                <div class="col-lg-2 col-md-4 col-sm-6 col-12 footer-column">
                    <h3>CONTACT US</h3>
                    <ul>
                        <li>
                            <a href="mailto:support@onlinejobs.ph">
                                <i class="fa-solid fa-envelope"></i> support@onlinejobs.ph
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Connect With Us Column -->
                <div class="col-lg-2 col-md-4 col-sm-6 col-12 footer-column">
                    <h3>CONNECT WITH US</h3>
                    <ul>
                        <li>
                            <div class="social-links">
                                <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="row footer-bottom">
                <div class="col-lg-4 col-md-12 mb-3 mb-lg-0">
                    <div class="footer-logo">
                        <a class="logo" href="#">
                            <div class="logoMark">OJ</div>
                            <div>
                                OnlineJobs <span style="color:var(--secondary); font-weight:900">india</span>
                                <small>Hire &amp; find remote talent</small>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 d-flex justify-content-lg-end justify-content-center align-items-center">
                    <div class="copyright text-lg-end text-center">
                        Copyright © 2026 OnlineJobs.india. All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>





<!-- ════════════════════════════════════════
     ADD THIS RIGHT BEFORE </body>
════════════════════════════════════════ -->

<!-- ── Drawer Overlay ── -->
<div class="drawer-overlay" id="drawerOverlay" onclick="closeDrawer()"></div>

<!-- ── Sign Up Drawer ── -->
<div class="drawer" id="signupDrawer">
  <button class="drawer-close" onclick="closeDrawer()" aria-label="Close">&#x2715;</button>

  <h3>Sign up as an Employer</h3>
  <p class="sub-label">BEFORE POSTING A JOB, CREATE A <strong>FREE EMPLOYER ACCOUNT</strong></p>

  <!-- Full Name -->
  <label class="form-field-label" for="fullName">Full Name</label>
  <input class="form-input" type="text" id="fullName" autocomplete="name"/>

  <!-- Email -->
  <label class="form-field-label" for="regEmail">Email Address</label>
  <input class="form-input" type="email" id="regEmail" autocomplete="email"/>

  <!-- Password -->
  <label class="form-field-label" for="regPassword">Password</label>
  <div class="pw-wrap">
    <input class="form-input" type="password" id="regPassword" autocomplete="new-password"/>
    <button class="pw-toggle" type="button" onclick="togglePw()" aria-label="Toggle password">
      <svg id="pwEye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
        <circle cx="12" cy="12" r="3"/>
        <line id="pwStrike" x1="3" y1="3" x2="21" y2="21" style="display:none;"/>
      </svg>
    </button>
  </div>
  <p class="pw-hint">Must be at least 6 characters.</p>

  <!-- Checkboxes -->
  <div class="check-row">
    <input type="checkbox" id="chkEmail" checked/>
    <label for="chkEmail">Send me your free outsourcing education emails.</label>
  </div>
  <div class="check-row">
    <input type="checkbox" id="chkTerms"/>
    <label for="chkTerms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
  </div>

  <!-- Captcha (mock) -->
  <div class="captcha-box">
    <input type="checkbox" id="captcha"/>
    <label for="captcha">I'm not a robot</label>
    <div class="captcha-logo">
      <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
        <circle cx="32" cy="32" r="30" fill="#4a90d9" opacity="0.15"/>
        <path d="M32 10 L54 22 L54 42 L32 54 L10 42 L10 22 Z" fill="none" stroke="#4a90d9" stroke-width="2.5"/>
        <path d="M32 18 L46 26 L46 38 L32 46 L18 38 L18 26 Z" fill="#4a90d9" opacity="0.3"/>
        <circle cx="32" cy="32" r="6" fill="#4a90d9"/>
      </svg>
      <span>reCAPTCHA</span>
      <span>Privacy · Terms</span>
    </div>
  </div>

  <!-- Register button -->
  <button class="btn-register" type="button">REGISTER</button>
</div>



    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- Swiper.js -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- JS -->
    <script src="/hirefromindia/assets/js/main.js"></script>   
</body>
</html>