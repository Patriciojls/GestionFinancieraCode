document.addEventListener('DOMContentLoaded', function () {
 
  // ===== GRÁFICA =====
  const ctx = document.getElementById('heroChart');
  if (ctx) {
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
        datasets: [
          {
            label: 'Ingresos',
            data: [65000, 78000, 72000, 95000, 110000, 124500],
            borderColor: '#F4A820',
            backgroundColor: 'rgba(244,168,32,.08)',
            borderWidth: 2,
            pointRadius: 3,
            pointBackgroundColor: '#F4A820',
            fill: true,
            tension: 0.4
          },
          {
            label: 'Gastos',
            data: [42000, 38000, 45000, 35000, 40000, 38200],
            borderColor: '#e74c3c',
            backgroundColor: 'rgba(231,76,60,.05)',
            borderWidth: 2,
            pointRadius: 3,
            pointBackgroundColor: '#e74c3c',
            fill: true,
            tension: 0.4
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: { duration: 2000, easing: 'easeInOutQuart' },
        plugins: {
          legend: {
            labels: {
              color: '#888',
              font: { size: 10, family: 'Raleway' },
              boxWidth: 10
            }
          },
          tooltip: {
            backgroundColor: '#1a1a1a',
            titleColor: '#F4A820',
            bodyColor: '#ccc',
            borderColor: 'rgba(244,168,32,.2)',
            borderWidth: 1,
            callbacks: {
              label: ctx => ' $' + ctx.raw.toLocaleString('es-MX')
            }
          }
        },
        scales: {
          x: {
            ticks: { color: '#555', font: { size: 9 } },
            grid:  { color: 'rgba(255,255,255,.04)' }
          },
          y: {
            ticks: {
              color: '#555',
              font: { size: 9 },
              callback: v => '$' + (v/1000).toFixed(0) + 'k'
            },
            grid: { color: 'rgba(255,255,255,.04)' }
          }
        }
      }
    });
  }
 
  // ===== CONTADORES =====
  function animateCounter(el) {
    const target = parseInt(el.dataset.target);
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;
    const timer = setInterval(() => {
      current += step;
      if (current >= target) {
        current = target;
        clearInterval(timer);
      }
      el.textContent = '$' + Math.floor(current).toLocaleString('es-MX');
    }, 16);
  }
 
  // Activa contadores cuando la card es visible
  const counters = document.querySelectorAll('.dc-stat-num[data-target]');
  const counterObserver = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        animateCounter(e.target);
        counterObserver.unobserve(e.target);
      }
    });
  }, { threshold: 0.5 });
  counters.forEach(c => counterObserver.observe(c));
 
  // ===== BARRAS DE PROGRESO =====
  const bars = document.querySelectorAll('.dc-bar-fill');
  const barObserver = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        setTimeout(() => {
          e.target.style.width = e.target.dataset.width + '%';
        }, 300);
        barObserver.unobserve(e.target);
      }
    });
  }, { threshold: 0.5 });
  bars.forEach(b => barObserver.observe(b));
 
});