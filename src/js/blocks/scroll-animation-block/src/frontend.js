import '../style/frontend.scss';

export default function initScrollAnimation() {
  const blocks = document.querySelectorAll('.biotropika-scroll-animation-block');
  if (!blocks.length) return;
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('in-view');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });
  blocks.forEach(el => observer.observe(el));
}

// Инициализируем только на фронте
document.addEventListener('DOMContentLoaded', initScrollAnimation);
