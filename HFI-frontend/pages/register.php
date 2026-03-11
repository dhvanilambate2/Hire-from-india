<?php
$page_title = "Register";
include '../global/header.php';
?>


<section class="split-hero">

<!-- ── LEFT: Employer ── -->
<div class="panel panel-left">
  <div class="panel-content">
    <h2>I'm an Employer</h2>
    <p>Looking for amazing hires</p>
    <button class="primary-btn btn-employer">START HIRING WORKERS</button>


    <!-- Curved gold arrow pointing down-right toward button area -->
    <div class="arrow-wrap">
      <svg class="arrow-left" width="70" height="55" viewBox="0 0 70 55" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M10 5 C10 5 55 8 60 45" stroke="#f0b429" stroke-width="2.5" stroke-linecap="round" fill="none"/>
        <path d="M54 42 L62 48 L56 38" stroke="#f0b429" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
      </svg>
    </div>
  </div>

  <!-- Chat bubbles -->
  <div class="bubble bubble-left-1">Looking for<br/>amazing hires!</div>
  <div class="bubble bubble-left-2">Looking to grow<br/>my business.</div>

  <!-- Person image -->
  <div class="panel-image">
    <img
      src="../assets/imgs/employer-img.png"
      alt="Professional employer"
    />
  </div>
</div>

<!-- ── RIGHT: Worker ── -->
<div class="panel panel-right">
  <div class="panel-content">
    <h2>I'm a Indian online worker</h2>
    <p>Looking for a remote job</p>
    <button class="primary-btn btn-worker">START FINDING JOBS</button>


    <!-- Curved dark arrow -->
    <div class="arrow-wrap">
      <svg class="arrow-right" width="70" height="55" viewBox="0 0 70 55" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M60 5 C60 5 15 8 10 45" stroke="#1a2a3a" stroke-width="2.5" stroke-linecap="round" fill="none"/>
        <path d="M16 42 L8 48 L14 38" stroke="#1a2a3a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
      </svg>
    </div>
  </div>

  <!-- Chat bubbles -->
  <div class="bubble bubble-right-1">Naghahanap ng<br/>trabaho online.</div>
  <div class="bubble bubble-right-2">Looking to make<br/>additional income.</div>

  <!-- Person image -->
  <div class="panel-image">
    <img
      src="../assets/imgs/worker-img.png"
      alt="Filipino online worker"
    />
  </div>
</div>

</section>







<?php
include '../global/footer.php';
?>