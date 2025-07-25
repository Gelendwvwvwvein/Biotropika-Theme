/**
 * Открываем по одному скрытому отзыву при каждом клике
 */
export default function initReviewsCards() {
  const container = document.querySelector('.biotropika-reviews-cards-block');
  if (!container) return;

  container.addEventListener('click', () => {
    const next = container.querySelector('.review.hidden');
    if (next) {
      next.classList.remove('hidden');
      next.classList.add('visible');
      // сбрасываем inline display:none
      next.style.display = '';
    }
  });
}

window.addEventListener('DOMContentLoaded', initReviewsCards);
