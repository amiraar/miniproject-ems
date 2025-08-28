(function(){
  const html = document.documentElement;
  const themeToggle = document.getElementById('themeToggle');
  const themeIcon = document.getElementById('themeIcon');
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebar = document.querySelector('.sidebar');

  // Theme init
  try {
    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-bs-theme', savedTheme);
    updateThemeIcon(savedTheme);
  } catch(e) { console.warn('Theme init failed:', e); }

  if (themeToggle) {
    themeToggle.addEventListener('click', function(){
      const currentTheme = html.getAttribute('data-bs-theme');
      const newTheme = currentTheme === 'light' ? 'dark' : 'light';
      html.setAttribute('data-bs-theme', newTheme);
  try { localStorage.setItem('theme', newTheme); } catch(e) { console.warn('Theme persist failed:', e); }
      updateThemeIcon(newTheme);
    });
  }

  function updateThemeIcon(theme){
    if (!themeIcon) return;
    themeIcon.className = (theme === 'dark') ? 'fas fa-sun' : 'fas fa-moon';
  }

  // Clock
  function updateClock(){
    const now = new Date();
    const timeString = now.toLocaleTimeString();
    const clockElement = document.getElementById('digitalClock');
    const welcomeClockElement = document.getElementById('welcomeClock');
    if (clockElement) clockElement.textContent = timeString;
    if (welcomeClockElement) welcomeClockElement.textContent = timeString;
  }
  updateClock();
  setInterval(updateClock, 1000);

  // Sidebar toggle (mobile)
  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', function(e){
      e.stopPropagation();
      sidebar.classList.toggle('show');
    });
  }
  document.addEventListener('click', function(event){
    if (window.innerWidth <= 768 && sidebar && sidebar.classList.contains('show')) {
      if (!sidebar.contains(event.target)) {
        sidebar.classList.remove('show');
      }
    }
  });

  // Tooltips
  try {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  } catch(e) { console.warn('Tooltip init failed:', e); }
})();
