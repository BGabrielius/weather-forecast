document.querySelectorAll('.card').forEach((button) => {
  button.addEventListener('click', () => {
    const param = button.getAttribute('data-param');

    document.querySelectorAll('.card').forEach((card) => {
      card.classList.remove('card-active');
    });

    let activeCard = document.getElementById('day-' + param);

    if (activeCard) {
      activeCard.classList.add('card-active');
    }
    fetch('includes/eventHandler/eventHandler.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `action=handleDayChange&param=${encodeURIComponent(param)}`,
    })
      .then((response) => response.text())
      .catch((error) => {
        console.log(error);
      });
  });
});
