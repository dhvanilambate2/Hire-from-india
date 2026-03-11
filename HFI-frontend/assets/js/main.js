// ============================================================
// STICKY HEADER
// ============================================================
(function () {
  var header = document.getElementById('mainHeader');
  if (!header) return;
  window.addEventListener('scroll', function () {
    header.classList.toggle('sticky', window.scrollY > 50);
  });
})();


// ============================================================
// FAQ ACCORDION — one open at a time
// ============================================================
(function () {
  if (!document.querySelector('.accordion-collapse')) return;
  document.addEventListener('show.bs.collapse', function (e) {
    document.querySelectorAll('.accordion-collapse.show').forEach(function (openPanel) {
      if (openPanel !== e.target) {
        bootstrap.Collapse.getInstance(openPanel)?.hide();
      }
    });
  });
})();


// ============================================================
// PRICING — MONTHLY / ANNUALLY TOGGLE
// ============================================================
function setBilling(plan, type) {
  var cardId = plan === 'pro' ? 'proCard' : 'premiumCard';
  var card = document.getElementById(cardId);
  if (!card) return;
  var buttons = card.querySelectorAll('.billing-toggle button');
  card.querySelector('.price-monthly').style.display  = type === 'monthly'  ? 'inline' : 'none';
  card.querySelector('.price-annually').style.display = type === 'annually' ? 'inline' : 'none';
  buttons.forEach(function (btn) { btn.classList.remove('active'); });
  buttons[type === 'monthly' ? 0 : 1].classList.add('active');
}


// ============================================================
// TESTIMONIALS SLIDER
// ============================================================
(function () {
  var track = document.getElementById('sliderTrack');
  if (!track) return;
  var sliderCards = track.querySelectorAll('.testimonial-card');
  var dotsContainer = document.getElementById('sliderDots');
  var prevBtn = document.getElementById('prevBtn');
  var nextBtn = document.getElementById('nextBtn');
  if (!dotsContainer || !prevBtn || !nextBtn) return;

  var current = 0;
  var perView = getPerView();
  var total   = Math.ceil(sliderCards.length / perView);

  function getPerView() {
    if (window.innerWidth <= 600) return 1;
    if (window.innerWidth <= 991) return 2;
    return 3;
  }

  function buildDots() {
    dotsContainer.innerHTML = '';
    total = Math.ceil(sliderCards.length / perView);
    for (var i = 0; i < total; i++) {
      (function (idx) {
        var dot = document.createElement('div');
        dot.className = 'dot' + (idx === current ? ' active' : '');
        dot.addEventListener('click', function () { goTo(idx); });
        dotsContainer.appendChild(dot);
      })(i);
    }
  }

  function updateDots() {
    dotsContainer.querySelectorAll('.dot').forEach(function (d, i) {
      d.classList.toggle('active', i === current);
    });
  }

  function goTo(index) {
    current = Math.max(0, Math.min(index, total - 1));
    var containerWidth = track.parentElement.offsetWidth;
    var cardWidth      = containerWidth / perView;
    var maxOffset      = (sliderCards.length - perView) * cardWidth;
    var offset         = Math.min(current * cardWidth * perView, maxOffset);
    track.style.transform = 'translateX(-' + offset + 'px)';
    updateDots();
  }

  prevBtn.addEventListener('click', function () { goTo(current - 1); });
  nextBtn.addEventListener('click', function () { goTo(current + 1); });

  var autoplay = setInterval(function () {
    goTo(current < total - 1 ? current + 1 : 0);
  }, 4000);

  track.parentElement.addEventListener('mouseenter', function () { clearInterval(autoplay); });
  track.parentElement.addEventListener('mouseleave', function () {
    autoplay = setInterval(function () {
      goTo(current < total - 1 ? current + 1 : 0);
    }, 4000);
  });

  window.addEventListener('resize', function () {
    var newPer = getPerView();
    if (newPer !== perView) {
      perView = newPer;
      current = 0;
      buildDots();
      goTo(0);
    }
  });

  buildDots();
  goTo(0);
})();


// ============================================================
// EMPLOYERS / WORKERS TAB SWITCHER
// ============================================================
function switchTab(tab, btn) {
  document.querySelectorAll('.tab-pane-custom').forEach(function (p) { p.classList.remove('active'); });
  document.querySelectorAll('.tab-toggle button').forEach(function (b) { b.classList.remove('active'); });
  var pane = document.getElementById('tab-' + tab);
  if (pane) pane.classList.add('active');
  btn.classList.add('active');
}


// ============================================================
// LOGIN — PASSWORD VISIBILITY TOGGLE
// ============================================================
function togglePassword() {
  var input  = document.getElementById('password');
  var strike = document.getElementById('eyeStrike');
  if (!input) return;
  input.type = input.type === 'password' ? 'text' : 'password';
  if (strike) strike.style.display = input.type === 'text' ? 'inline' : 'none';
}


// ============================================================
// SIGN-UP DRAWER
// ============================================================
function openDrawer() {
  var drawer  = document.getElementById('signupDrawer');
  var overlay = document.getElementById('drawerOverlay');
  if (drawer)  drawer.classList.add('open');
  if (overlay) overlay.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeDrawer() {
  var drawer  = document.getElementById('signupDrawer');
  var overlay = document.getElementById('drawerOverlay');
  if (drawer)  drawer.classList.remove('open');
  if (overlay) overlay.classList.remove('open');
  document.body.style.overflow = '';
}

function togglePw() {
  var input  = document.getElementById('regPassword');
  var strike = document.getElementById('pwStrike');
  if (!input) return;
  input.type = input.type === 'password' ? 'text' : 'password';
  if (strike) strike.style.display = input.type === 'text' ? 'inline' : 'none';
}

document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') closeDrawer();
});


// ============================================================
// JOB LISTINGS — FILTER
// ============================================================
function filterJobs() {
  var searchInput = document.getElementById('searchInput');
  var chkGig      = document.getElementById('chkGig');
  var chkPart     = document.getElementById('chkPart');
  var chkFull     = document.getElementById('chkFull');
  if (!searchInput || !chkGig || !chkPart || !chkFull) return;

  var searchVal = searchInput.value.toLowerCase();
  var jobCards  = document.querySelectorAll('.job-card');
  var visible   = 0;

  jobCards.forEach(function (card) {
    var type   = card.dataset.type   || '';
    var title  = card.dataset.title  || '';
    var skills = card.dataset.skills || '';

    var typeMatch =
      (type === 'fulltime' && chkFull.checked) ||
      (type === 'parttime' && chkPart.checked) ||
      (type === 'gig'      && chkGig.checked);

    var textMatch =
      !searchVal ||
      title.toLowerCase().includes(searchVal) ||
      skills.toLowerCase().includes(searchVal);

    if (typeMatch && textMatch) {
      card.style.display = '';
      visible++;
    } else {
      card.style.display = 'none';
    }
  });

  var counter = document.getElementById('resultsCount');
  if (counter) {
    counter.textContent = 'Displaying ' + visible + ' out of ' + jobCards.length + ' jobs';
  }
}


// ============================================================
// PRIVACY PAGE — TOC ACTIVE HIGHLIGHT ON SCROLL
// ============================================================
(function () {
  var privacySections = Array.from(document.querySelectorAll('.privacy-section'));
  var privacyTocLinks = Array.from(document.querySelectorAll('.toc ul li a'));
  if (!privacySections.length || !privacyTocLinks.length) return;

  function updateToc() {
    var scrollBottom = window.scrollY + window.innerHeight;
    var pageHeight   = document.documentElement.scrollHeight;
    var activeId     = privacySections[0].id;

    if (scrollBottom >= pageHeight - 10) {
      activeId = privacySections[privacySections.length - 1].id;
    } else {
      for (var i = 0; i < privacySections.length; i++) {
        if (privacySections[i].getBoundingClientRect().top <= 140) {
          activeId = privacySections[i].id;
        }
      }
    }

    privacyTocLinks.forEach(function (link) {
      link.classList.toggle('active', link.getAttribute('href') === '#' + activeId);
    });
  }

  window.addEventListener('scroll', updateToc);
  updateToc();
})();





// ============================================================
// TERMS OF USE PAGE — TOC ACTIVE HIGHLIGHT ON SCROLL
// ============================================================
(function () {
  var termsSections = Array.from(document.querySelectorAll('.terms-section'));
  var termsTocLinks = Array.from(document.querySelectorAll('.toc ul li a'));
  if (!termsSections.length || !termsTocLinks.length) return;

  function updateToc() {
    var scrollBottom = window.scrollY + window.innerHeight;
    var pageHeight   = document.documentElement.scrollHeight;
    var activeId     = termsSections[0].id;

    if (scrollBottom >= pageHeight - 10) {
      activeId = termsSections[termsSections.length - 1].id;
    } else {
      for (var i = 0; i < termsSections.length; i++) {
        if (termsSections[i].getBoundingClientRect().top <= 140) {
          activeId = termsSections[i].id;
        }
      }
    }

    termsTocLinks.forEach(function (link) {
      link.classList.toggle('active', link.getAttribute('href') === '#' + activeId);
    });
  }

  window.addEventListener('scroll', updateToc);
  updateToc();
})();