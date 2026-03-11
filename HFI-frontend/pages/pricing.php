<?php
$page_title = "Pricing";
include '../global/header.php';
?>



<section class="pricing-hero">
  <h1><span class="count">19,019</span> employers upgraded this month.</h1>
  <p>Hire direct. <strong>No salary markups or ongoing fees.</strong></p>
  <p><a href="#">Cancel when done recruiting.</a></p>
  <p>Hire great talent or <a href="#">we'll give your money back. It's better than a "free trial."</a></p>
</section>



<!-- ── Pricing Cards ── -->
<section class="pricing-cards">
  <div class="container" style="max-width:1000px;">
    <div class="row g-3 align-items-stretch">

      <!-- FREE -->
      <div class="col-12 col-md-4">
        <div class="plan-card free">
          <div class="plan-header">
            <span class="plan-label">Free</span>
            <span class="plan-sublabel">WHY NO FREE TRIAL?</span>
            <div class="plan-price">FREE <span style="font-size:1rem;color:#aaa;">ⓘ</span></div>
          </div>
          <ul class="feature-list">
            <li><span class="icon icon-x">✕</span><span><strong>Hire &amp; Communicate</strong> with Workers</span></li>
            <li><span class="icon icon-check">✔</span><span>Up to <strong>3</strong> Job Posts</span></li>
            <li><span class="icon icon-check">✔</span><span>Max <strong>15 applications</strong> per job</span></li>
            <li><span class="icon icon-check">✔</span><span><strong>2 days</strong> Job Post approval</span></li>
            <li><span class="icon icon-check">✔</span><span>View Job Applications</span></li>
            <li><span class="icon icon-check">✔</span><span><a href="#">Use Timeproof</a></span></li>
            <li><span class="icon icon-check">✔</span><span><strong>Bookmark</strong> Workers</span></li>
            <li><span class="icon icon-check">✔</span><span><a href="#">Easypay</a></span></li>
          </ul>
          <div class="plan-footer">
            <button class="btn-register">
              REGISTER
              <small>no credit card required</small>
            </button>
          </div>
        </div>
      </div>

      <!-- PRO -->
      <div class="col-12 col-md-4">
        <div class="plan-card pro show-monthly" id="proCard">
          <div class="plan-header">
            <span class="plan-label">Pro</span>
            <div class="plan-price">
              $<span class="price-monthly">69</span><span class="price-annually" style="display:none;">42</span><span class="currency-badge">USD</span>
            </div>
            <div class="plan-cancel">Cancel anytime.</div>
            <div class="billing-toggle">
              <button class="active" onclick="setBilling('pro','monthly')">Monthly</button>
              <button onclick="setBilling('pro','annually')">Annually<small>64% Savings!</small></button>
            </div>
          </div>
          <ul class="feature-list">
            <li><span class="icon icon-check">✔</span><span><strong>Hire &amp; Communicate</strong> with Workers</span></li>
            <li><span class="icon icon-check">✔</span><span>Up to <strong>3</strong> Job Posts</span></li>
            <li><span class="icon icon-check">✔</span><span>Max <strong>200 applications</strong> per job</span></li>
            <li><span class="icon icon-check">✔</span><span><strong>Instant</strong> Job Post approval</span></li>
            <li><span class="icon icon-check">✔</span><span>View Job Applications</span></li>
            <li><span class="icon icon-check">✔</span><span><a href="#">Use Timeproof</a></span></li>
            <li><span class="icon icon-check">✔</span><span><strong>Bookmark</strong> Workers</span></li>
            <li><span class="icon icon-check">✔</span><span><a href="#">Easypay</a></span></li>
            <li><span class="icon icon-check">✔</span><span>Contact <strong>75 workers</strong> / month <span class="info-icon">ⓘ</span></span></li>
            <li><span class="icon icon-check">✔</span><span>Read <strong>Worker Reviews</strong></span></li>
          </ul>
          <div class="plan-footer">
            <a href="#" class="btn-cancel-link"><span class="dot">●</span> Cancel Anytime Easily</a>
            <button class="btn-register">UPGRADE</button>
          </div>
        </div>
      </div>

      <!-- PREMIUM -->
      <div class="col-12 col-md-4">
        <div class="plan-card premium show-monthly" id="premiumCard">
          <span class="most-popular-badge">Most Popular!</span>
          <div class="plan-header" style="padding-top:1.8rem;">
            <span class="plan-label">Premium</span>
            <div class="plan-price">
              $<span class="price-monthly">99</span><span class="price-annually" style="display:none;">59</span><span class="currency-badge">USD</span>
            </div>
            <div class="plan-cancel">Cancel anytime.</div>
            <div class="billing-toggle">
              <button class="active" onclick="setBilling('premium','monthly')">Monthly</button>
              <button onclick="setBilling('premium','annually')">Annually<small>71% Savings!</small></button>
            </div>
          </div>
          <div class="ai-badge">
            <div>
              <div>AI Matching</div>
              <div class="sub-text">Tell me who to hire</div>
            </div>
            <span class="new-tag">NEW!</span>
          </div>
          <ul class="feature-list">
            <li><span class="icon icon-check">✔</span><span><strong>Hire &amp; Communicate</strong> with Workers</span></li>
            <li><span class="icon icon-check">✔</span><span>Up to <strong>10</strong> Job Posts</span></li>
            <li><span class="icon icon-check">✔</span><span>Max <strong>200 applications</strong> per job</span></li>
            <li><span class="icon icon-check">✔</span><span><strong>Instant</strong> Job Post approval</span></li>
            <li><span class="icon icon-check">✔</span><span>View Job Applications</span></li>
            <li><span class="icon icon-check">✔</span><span><a href="#">Use Timeproof</a></span></li>
            <li><span class="icon icon-check">✔</span><span><strong>Bookmark</strong> Workers</span></li>
            <li><span class="icon icon-check">✔</span><span><a href="#">Easypay</a></span></li>
            <li><span class="icon icon-check">✔</span><span>Contact <strong>500 workers</strong> / month <span class="info-icon">ⓘ</span></span></li>
            <li><span class="icon icon-check">✔</span><span>Read <strong>Worker Reviews</strong></span></li>
            <li><span class="icon icon-check">✔</span><span>Unlimited <a href="#">Background Data Checks</a></span></li>
            <li><span class="icon icon-check">✔</span><span><a href="#">Worker Mentoring Service</a></span></li>
            <li><span class="icon icon-check">✔</span>
              <span style="display:flex;align-items:center;gap:0.4rem;flex-wrap:wrap;">
                <a href="#">AI Matching</a>
                <span class="new-tag" style="font-size:0.6rem;">NEW!</span>
                <span class="info-icon">ⓘ</span>
                <span style="font-size:0.65rem;color:#888;display:block;width:100%;">Tell me who to hire</span>
              </span>
            </li>
          </ul>
          <div class="plan-footer">
            <a href="#" class="btn-cancel-link"><span class="dot">●</span> Cancel Anytime Easily</a>
            <button class="btn-register">UPGRADE</button>
          </div>
        </div>
      </div>

    </div><!-- /row -->
  </div>
</section>


<!-- ── Money Back ── -->
<section class="certificate">
    <div class="container">
        <div class="money-back">
            <!-- Satisfaction seal SVG -->
            <svg width="80" height="80" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <circle cx="50" cy="50" r="46" fill="#f5c518" stroke="#e6a817" stroke-width="3"/>
            <circle cx="50" cy="50" r="36" fill="#fff" stroke="#e6a817" stroke-width="1.5"/>
            <text x="50" y="38" text-anchor="middle" font-size="11" font-weight="900" fill="#c8900a" font-family="Nunito,sans-serif">100%</text>
            <text x="50" y="52" text-anchor="middle" font-size="8.5" font-weight="800" fill="#c8900a" font-family="Nunito,sans-serif">MONEY</text>
            <text x="50" y="63" text-anchor="middle" font-size="8.5" font-weight="800" fill="#c8900a" font-family="Nunito,sans-serif">BACK</text>
            <text x="50" y="74" text-anchor="middle" font-size="7" font-weight="700" fill="#c8900a" font-family="Nunito,sans-serif">GUARANTEE</text>
            <!-- star decorations -->
            <text x="50" y="20" text-anchor="middle" font-size="10" fill="#e6a817">★ ★ ★</text>
            </svg>
            <div>
            <h5>100% Money Back Guarantee.</h5>
            <p><strong>If you don't find someone great, we'll give you your money back.</strong></p>
            <p class="terms">NO CONTRACTS. NO COMMITMENTS. NO EXTRA FEES. NO SALARY MARKUPS.<br/>CANCEL SUBSCRIPTION AT ANYTIME.</p>
            <a href="#">Find A Great Worker!</a>

            <p class="fs-16 fw-600 mb-0">
              <a href="/money-back-guarantee">Learn more about our satisfaction guarantees <i class="icon icon-small-right align-middle fs-28"></i></a>
            </p>
            </div>
        </div>
    </div>
</section>


<section class="faq">
  <div class="container">
            <h2 class="title">Frequently Asked Questions</h2>
            <div class="title-underline"></div>

    <!-- ── ACCOUNT AND PRICING ── -->
    <div class="faq-group">
      <p class="faq-category">ACCOUNT AND PRICING</p>
      <div class="accordion" id="accordionPricing">

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#p1" data-bs-parent="#accordionPricing">
            What does the free account get me?
            </button>
          </h2>
          <div id="p1" class="accordion-collapse collapse">
            <div class="accordion-body">
              The free account lets you browse job seekers and view limited profile information. You can post a job and receive applications, but you'll need a paid plan to contact workers directly.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#p2" data-bs-parent="#accordionPricing">
            Why can't I contact workers with the free account?
            </button>
          </h2>
          <div id="p2" class="accordion-collapse collapse">
            <div class="accordion-body">
              Contacting workers requires a paid subscription to maintain the quality of our platform and ensure serious employers reach out to job seekers. Upgrade to a Pro or Premium plan to unlock messaging.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#p3" data-bs-parent="#accordionPricing">
            Why do I have to pay up front? Seems more expensive and risky for me.
            </button>
          </h2>
          <div id="p3" class="accordion-collapse collapse">
            <div class="accordion-body">
              Paying up front ensures you have uninterrupted access to our platform. We offer a satisfaction guarantee — if you're not happy within the first 30 days, we'll refund your subscription.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#p4" data-bs-parent="#accordionPricing">
            Why don't you offer a lower priced option?
            </button>
          </h2>
          <div id="p4" class="accordion-collapse collapse">
            <div class="accordion-body">
              Our pricing reflects the value of connecting you with highly qualified Filipino professionals. We continually invest in improving the platform to make your hiring experience fast and effective.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#p5" data-bs-parent="#accordionPricing">
            Can I upgrade to Premium later?
            </button>
          </h2>
          <div id="p5" class="accordion-collapse collapse">
            <div class="accordion-body">
              Yes! You can upgrade or switch your billing cycle at any time from your account settings. Annual plans offer a significant discount compared to month-to-month billing.
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- ── CANCELLING YOUR SUBSCRIPTION ── -->
    <div class="faq-group">
      <p class="faq-category">CANCELLING YOUR SUBSCRIPTION</p>
      <div class="accordion" id="accordionWorkers">

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#w1" data-bs-parent="#accordionWorkers">
            Do I have to keep my subscription after I hire someone?
            </button>
          </h2>
          <div id="w1" class="accordion-collapse collapse">
            <div class="accordion-body">
              You can pay workers directly via bank transfer, PayPal, Wise, or through our built-in EasyPay system. Payments are made after the worker has completed a week of work.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#w2" data-bs-parent="#accordionWorkers">
            How do I cancel?
            </button>
          </h2>
          <div id="w2" class="accordion-collapse collapse">
            <div class="accordion-body">
              EasyPay is our integrated payment solution that lets you pay your Filipino workers quickly and securely. Payments are processed in USD and converted to PHP for the worker, with low fees and fast delivery.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#w3" data-bs-parent="#accordionWorkers">
            Can I still use EasyPay and Timeproof after I cancel?
            </button>
          </h2>
          <div id="w3" class="accordion-collapse collapse">
            <div class="accordion-body">
              Costs vary depending on the worker's skills and experience. Full-time Filipino VAs typically earn $400–$800/month. Part-time and hourly arrangements can be negotiated directly with the worker.
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- ── TRUST ── -->
    <div class="faq-group">
      <p class="faq-category">TRUST</p>
      <div class="accordion" id="accordionCancel">

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c1" data-bs-parent="#accordionCancel">
            How do I Trust a Virtual Assistant With My Business Info?
            </button>
          </h2>
          <div id="c1" class="accordion-collapse collapse">
            <div class="accordion-body">
              No! Once you've hired a worker, you don't need to maintain your subscription. You only need a subscription to search resumes and contact new workers.
            </div>
          </div>
        </div>

        <button class="border-btn mt-4">MORE GREAT FAQ</button>
  </div>
</section>


<section class="testimonials">
  <h2 class="title">Our Employers Love OnlineJobs</h2>
  <div class="title-underline"></div>

  <!-- Slider -->
  <div class="slider-outer">
    <div class="slider-track" id="sliderTrack">

      <!-- Card 1 -->
      <div class="testimonial-card">
        <div>
          <span class="quote-icon">"</span>
          <p class="testimonial-text">@OnlinejobsdotPH @TheSocialQuant Thanks for sharing this. Loved working with your service for our company. Have 2 rockstars from you.</p>
        </div>
        <div class="author">
          <div class="author-avatar av-1">MK</div>
          <div class="author-info">
            <p class="name">Mike Kawula</p>
            <p class="role">CEO, <a href="#">The Social Quant</a></p>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="testimonial-card">
        <div>
          <span class="quote-icon">"</span>
          <p class="testimonial-text">I wanted to let you know how incredible my Virtual Assistant is that I found through OnlineJobs.Ph.</p>
        </div>
        <div class="author">
          <div class="author-avatar av-2">MS</div>
          <div class="author-info">
            <p class="name">Mariah Secrest-Comer</p>
            <p class="role"></p>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="testimonial-card">
        <div>
          <span class="quote-icon">"</span>
          <p class="testimonial-text">I've employed a number of people from here over the years, my last was a husband and wife comb for about 3.5 years. Best decision I have made. Well worth it.</p>
        </div>
        <div class="author">
          <div class="author-avatar av-3">CV</div>
          <div class="author-info">
            <p class="name">Carl Vanderpal</p>
            <p class="role">CEO, <a href="#">Organic Health Foods</a></p>
          </div>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="testimonial-card">
        <div>
          <span class="quote-icon">"</span>
          <p class="testimonial-text">OnlineJobs.ph has completely transformed how I hire remote talent. The quality of candidates is unmatched and the process is seamless from start to finish.</p>
        </div>
        <div class="author">
          <div class="author-avatar av-4">JL</div>
          <div class="author-info">
            <p class="name">Jessica Lane</p>
            <p class="role">Founder, <a href="#">DigitalEdge Co.</a></p>
          </div>
        </div>
      </div>

      <!-- Card 5 -->
      <div class="testimonial-card">
        <div>
          <span class="quote-icon">"</span>
          <p class="testimonial-text">I hired my first VA through OnlineJobs and within a week she was handling tasks that used to take me half my day. I wish I had found this platform sooner!</p>
        </div>
        <div class="author">
          <div class="author-avatar av-5">TR</div>
          <div class="author-info">
            <p class="name">Tom Richards</p>
            <p class="role">CEO, <a href="#">Richards Media Group</a></p>
          </div>
        </div>
      </div>

    </div><!-- /slider-track -->
  </div><!-- /slider-outer -->

  <!-- Dots -->
  <div class="slider-dots" id="sliderDots"></div>

  <!-- Nav arrows -->
  <div class="slider-nav">
    <button class="nav-arrow" id="prevBtn" aria-label="Previous">&#8592;</button>
    <button class="nav-arrow" id="nextBtn" aria-label="Next">&#8594;</button>
  </div>

  <!-- CTA -->
  <button class="border-btn mt-4">SEE MORE REAL RESULTS</button>
</section>


<section class="companies">
  <div class="container">
    <h2 class="title">Companies using OnlineJobs</h2>
    <div class="title-underline"></div>

    <div class="logos-row">

      <!-- Unilever -->
      <div class="logo-item">
        <img src="../assets/imgs/logo1.webp" alt="Unilever"/>
      </div>

      <!-- Speedo -->
      <div class="logo-item">
        <img src="../assets/imgs/logo2.webp" alt="Speedo"/>
      </div>

      <!-- Newsweek -->
      <div class="logo-item">
        <img src="../assets/imgs/logo3.webp" alt="Newsweek"/>
      </div>

      <!-- Google -->
      <div class="logo-item">
        <img src="../assets/imgs/logo4.webp" alt="Google"/>
      </div>

      <!-- UBER -->
      <div class="logo-item">
        <img src="../assets/imgs/logo5.webp" alt="Uber"/>
      </div>

      <!-- Canva -->
      <div class="logo-item">
        <img src="../assets/imgs/logo6.webp" alt="Canva"/>
      </div>

      <!-- ABS-CBN -->
      <div class="logo-item">
        <img src="../assets/imgs/logo7.png" alt="ABS-CBN"/>
      </div>

    </div>
  </div>
</section>


<section class="got-questions">
    <h2 class="title">Got questions?</h2>
    <div class="title-underline mb-2"></div>

  <button class="border-btn mt-4 mb-5">VIEW FAQ</button>


  <div class="container">
    <div class="row g-3">
      <div class="col-12 col-md-4">
        <a href="#" class="question-card">
          <span>Still confused?</span>
        </a>
      </div>
      <div class="col-12 col-md-4">
        <a href="#" class="question-card">
          <span>Concerned about the cost?</span>
        </a>
      </div>
      <div class="col-12 col-md-4">
        <a href="#" class="question-card">
          <span>Why pay when other sites are "free"?</span>
        </a>
      </div>
    </div>
  </div>
</section>



<?php
include '../global/footer.php';
?>