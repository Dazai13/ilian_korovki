const menuLinks = document.querySelectorAll('.category-link');
const katalogWindows = document.querySelectorAll('.katalog');
const helloWindow = document.querySelector('.hello-window');

function switchKatalog(targetId) {
  katalogWindows.forEach(window => {
    window.style.display = 'none';
    if (window.id === targetId) {
      window.style.display = 'block';
    }
  });
}

menuLinks.forEach(link => {
  link.addEventListener('click', (event) => {
    event.preventDefault();
    const targetId = link.getAttribute('data-target');

    if (helloWindow.style.display !== 'none') {
      helloWindow.style.display = 'none';
    }

    switchKatalog(targetId);
  });
});

helloWindow.style.display = 'block';
katalogWindows.forEach(window => {
  window.style.display = 'none';
});

document.addEventListener('DOMContentLoaded', () => {
  const allStarContainers = document.querySelectorAll('.stars');

  allStarContainers.forEach(starContainer => {
      const stars = starContainer.querySelectorAll('.fa-star');
      let currentRating = 0;

      stars.forEach(star => {
          star.addEventListener('mouseover', () => {
              const rating = star.dataset.value;
              resetStars(starContainer);
              highlightStars(starContainer, rating);
          });

          star.addEventListener('mouseout', () => {
              resetStars(starContainer);
              highlightStars(starContainer, currentRating);
          });

          star.addEventListener('click', () => {
              currentRating = star.dataset.value;
              highlightStars(starContainer, currentRating);
          });
      });
  });

  function highlightStars(container, rating) {
      const stars = container.querySelectorAll('.fa-star');
      stars.forEach(star => {
          if (star.dataset.value <= rating) {
              star.classList.add('filled');
          }
      });
  }

  function resetStars(container) {
      const stars = container.querySelectorAll('.fa-star');
      stars.forEach(star => {
          star.classList.remove('filled');
      });
  }
});

