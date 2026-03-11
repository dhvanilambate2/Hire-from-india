<?php
$page_title = "Jobsearch";
include '../../global/header.php';
?>





<section class="jobs-page">
  <div class="container">

      <!-- ── Search Bar ── -->
      <div class="search-bar-wrap">
        <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" id="searchInput" placeholder="Search for a job title or company" oninput="filterJobs()"/>
        <button class="btn-search" onclick="filterJobs()">SEARCH</button>
      </div>

      <div class="jobs-layout">

        <!-- ── Sidebar ── -->
        <aside class="sidebar">
          <h5>Filter by skills:</h5>
          <span class="select-label">SELECT UP TO 3 SKILLS</span>

          <div class="skill-search-wrap">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" color="#2a7fc1">
              <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" placeholder="Search for skills" oninput="filterJobs()"/>
          </div>

          <hr/>

          <span class="emp-label">Employment Type</span>

          <div class="check-item">
            <input type="checkbox" id="chkGig" checked onchange="filterJobs()"/>
            <label for="chkGig">GIG</label>
          </div>
          <div class="check-item">
            <input type="checkbox" id="chkPart" checked onchange="filterJobs()"/>
            <label for="chkPart">PART-TIME</label>
          </div>
          <div class="check-item">
            <input type="checkbox" id="chkFull" checked onchange="filterJobs()"/>
            <label for="chkFull">FULL-TIME</label>
          </div>

          <button class="btn-refine" onclick="filterJobs()">REFINE SEARCH RESULTS</button>
        </aside>

        <!-- ── Results ── -->
        <div class="results-col">
          <p class="results-count" id="resultsCount">Displaying 30 out of 257 jobs</p>

          <div id="jobList">

            <!-- Job 1 -->
            <div class="job-card" data-type="fulltime" data-title="Supply Chain Coordinator B2B Specialist Offshore Heroes" data-skills="b2b order management supply chain">
              <div class="job-card-inner">
                <img class="company-logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Amazon_logo.svg/200px-Amazon_logo.svg.png" alt="Heroes"/>
                <div class="job-info">
                  <div class="job-title-row">
                    <h3 class="job-title">Supply Chain Coordinator (B2B Specialist) – Offshore</h3>
                    <span class="badge-type badge-fulltime">Full Time</span>
                  </div>
                  <p class="job-meta">Posted on 2026-03-04 19:17:28</p>
                  <p class="job-salary">$1800/Month</p>
                  <p class="job-company-name">About Heroes</p>
                  <p class="job-desc">
                    Heroes buys, operates, and scales baby and juvenile brands.<br/>
                    We are ambitious multi-brand developers combining operational excellence with customer-centricity to support parents and children through every milestone of their journey. Built by a team with a background in... <a href="#">See More</a>
                  </p>
                  <div class="skill-tags">
                    <span class="skill-tag">B2B</span>
                    <span class="skill-tag">Order Management</span>
                    <span class="skill-tag">Supply Chain Management</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Job 2 -->
            <div class="job-card" data-type="fulltime" data-title="Marketing Social Media Executive Boba Brands" data-skills="social media marketing content creation">
              <div class="job-card-inner">
                <img class="company-logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Amazon_logo.svg/200px-Amazon_logo.svg.png" alt="Boba"/>
                <div class="job-info">
                  <div class="job-title-row">
                    <h3 class="job-title">Marketing &amp; Social Media Executive - Boba Brands</h3>
                    <span class="badge-type badge-fulltime">Full Time</span>
                  </div>
                  <p class="job-meta">Posted on 2026-03-04 19:17:25</p>
                  <p class="job-salary">$8/hr</p>
                  <p class="job-company-name">About Boba</p>
                  <p class="job-desc">
                    Over 2.5 million babies have been worn in our carriers. The original design of the wrap has not changed in 15 years— proof of a great concept. When we see a parent wearing their babe in one of... <a href="#">See More</a>
                  </p>
                  <div class="skill-tags">
                    <span class="skill-tag">Social Media</span>
                    <span class="skill-tag">Marketing</span>
                    <span class="skill-tag">Content Creation</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Job 3 -->
            <div class="job-card" data-type="parttime" data-title="Virtual Assistant Admin Support Remote" data-skills="admin email management calendar">
              <div class="job-card-inner">
                <img class="company-logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Google_2015_logo.svg/200px-Google_2015_logo.svg.png" alt="Company"/>
                <div class="job-info">
                  <div class="job-title-row">
                    <h3 class="job-title">Virtual Assistant – Admin Support (Remote)</h3>
                    <span class="badge-type badge-parttime">Part Time</span>
                  </div>
                  <p class="job-meta">Posted on 2026-03-04 18:55:10</p>
                  <p class="job-salary">$600/Month</p>
                  <p class="job-company-name">About TechFlow</p>
                  <p class="job-desc">
                    We are a fast-growing SaaS startup looking for a reliable virtual assistant to handle scheduling, email management, and day-to-day administrative tasks. Prior experience with remote teams is a plus... <a href="#">See More</a>
                  </p>
                  <div class="skill-tags">
                    <span class="skill-tag">Admin</span>
                    <span class="skill-tag">Email Management</span>
                    <span class="skill-tag">Calendar</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Job 4 -->
            <div class="job-card" data-type="gig" data-title="Graphic Designer Logo Branding Freelance" data-skills="design photoshop illustrator branding">
              <div class="job-card-inner">
                <img class="company-logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bb/Canva_Logo.svg/200px-Canva_Logo.svg.png" alt="Company"/>
                <div class="job-info">
                  <div class="job-title-row">
                    <h3 class="job-title">Graphic Designer – Logo &amp; Branding (Freelance)</h3>
                    <span class="badge-type badge-gig">Gig</span>
                  </div>
                  <p class="job-meta">Posted on 2026-03-04 17:30:00</p>
                  <p class="job-salary">$15/hr</p>
                  <p class="job-company-name">About CreativeHub</p>
                  <p class="job-desc">
                    CreativeHub is a boutique design agency that works with startups and established brands to craft memorable visual identities. We're looking for a talented freelance designer for ongoing gig projects... <a href="#">See More</a>
                  </p>
                  <div class="skill-tags">
                    <span class="skill-tag">Design</span>
                    <span class="skill-tag">Photoshop</span>
                    <span class="skill-tag">Branding</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Job 5 -->
            <div class="job-card" data-type="fulltime" data-title="SEO Specialist Content Writer Digital Marketing" data-skills="seo content writing wordpress">
              <div class="job-card-inner">
                <img class="company-logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/58/Uber_logo_2018.svg/200px-Uber_logo_2018.svg.png" alt="Company"/>
                <div class="job-info">
                  <div class="job-title-row">
                    <h3 class="job-title">SEO Specialist &amp; Content Writer – Digital Marketing</h3>
                    <span class="badge-type badge-fulltime">Full Time</span>
                  </div>
                  <p class="job-meta">Posted on 2026-03-04 16:00:00</p>
                  <p class="job-salary">$900/Month</p>
                  <p class="job-company-name">About GrowthLab</p>
                  <p class="job-desc">
                    GrowthLab is a performance marketing agency helping e-commerce brands scale through organic search and content. Join our remote team and own the content strategy for multiple client accounts... <a href="#">See More</a>
                  </p>
                  <div class="skill-tags">
                    <span class="skill-tag">SEO</span>
                    <span class="skill-tag">Content Writing</span>
                    <span class="skill-tag">WordPress</span>
                  </div>
                </div>
              </div>
            </div>

          </div><!-- /jobList -->
        </div><!-- /results-col -->

      </div><!-- /jobs-layout -->

  </div>
</section><!-- /jobs-page -->



<?php
include '../../global/footer.php';
?>