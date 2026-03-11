<?php
$page_title = "Contact Us";
include '../global/header.php';
?>


<section class="contact-hero hero">
  <h1>Contact Us</h1>
  <p>Need Help? Have a question? Let 'er rip!</p>
</section>

<!-- ── Body ── -->
<section class="contact-body">
  <div class="row g-5">

    <!-- ── Left: Form ── -->
    <div class="col-12 col-md-7">

      <label class="field-label" for="fullName">Full Name</label>
      <input class="form-input" type="text" id="fullName" autocomplete="name"/>

      <label class="field-label" for="emailAddr">Email Address</label>
      <input class="form-input" type="email" id="emailAddr" autocomplete="email"/>

      <label class="field-label" for="subject">Subject</label>
      <input class="form-input" type="text" id="subject"/>

      <label class="field-label" for="message">Message</label>
      <textarea class="form-input" id="message"></textarea>

      <!-- Captcha -->
      <div class="captcha-box">
        <input type="checkbox" id="captcha"/>
        <div>
          <label for="captcha">I'm not a robot</label>
          <span class="captcha-warning">
            This site is exceeding <a href="#">reCAPTCHA</a><br/>
            Enterprise free quota. <a href="#">Learn more</a>
          </span>
        </div>
        <div class="captcha-info">
          <!-- reCAPTCHA logo -->
          <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <circle cx="32" cy="32" r="30" fill="#4a90d9" opacity="0.12"/>
            <path d="M32 8 L56 22 L56 42 L32 56 L8 42 L8 22 Z" fill="none" stroke="#4a90d9" stroke-width="2.5"/>
            <circle cx="32" cy="32" r="10" fill="#4a90d9" opacity="0.5"/>
            <circle cx="32" cy="32" r="5" fill="#4a90d9"/>
          </svg>
          <span>reCAPTCHA</span>
          <span>Privacy · Terms</span>
        </div>
      </div>

      <!-- Send button -->
      <button class="btn-send" type="button">
        <!-- Envelope icon -->
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
          <polyline points="22,6 12,13 2,6"/>
        </svg>
        SEND MESSAGE
      </button>

      <p class="send-note"><em>We respond surprisingly fast.</em></p>
    </div>

    <!-- ── Right: Info ── -->
    <div class="col-12 col-md-5">
      <div class="contact-info">

        <!-- HQ -->
        <div class="info-row">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
            <circle cx="12" cy="10" r="3"/>
          </svg>
          <div>
            <strong>Headquarters:</strong>
            <p>Flowing Air Studios<br/>LLC, 770 E Main St.<br/>#250, Lehi, UT 84043</p>
          </div>
        </div>

        <!-- Email -->
        <div class="info-row">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
            <polyline points="22,6 12,13 2,6"/>
          </svg>
          <div>
            <strong>Email:</strong>
            <p>support@onlinejobs.ph</p>
          </div>
        </div>

        <!-- FAQ button -->
        <a href="#" class="btn-faq">
          <span class="faq-num">11</span>
          Most FAQ
          <span class="faq-q">?</span>
        </a>

        <!-- Messenger button -->
        <a href="https://m.me/245180852206318" target="_blank" class="btn-messenger">
          <!-- Messenger icon -->
          <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2C6.477 2 2 6.145 2 11.243c0 2.79 1.395 5.286 3.584 6.923V21l3.27-1.793A10.597 10.597 0 0 0 12 19.487c5.523 0 10-4.145 10-9.244C22 6.145 17.523 2 12 2zm1.033 12.428-2.548-2.714-4.97 2.714 5.468-5.8 2.614 2.714 4.904-2.714-5.468 5.8z"/>
          </svg>
          Message Us
        </a>

      </div>
    </div>

  </div>
</section>



<?php
include '../global/footer.php';
?>