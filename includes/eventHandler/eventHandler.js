document.querySelectorAll('#currentDay').forEach((button) => {
  button.addEventListener('click', () => {
    const param = button.getAttribute('data-param');
    fetch('includes/eventHandler/eventHandler.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `action=myFunction&param=${encodeURIComponent(param)}`,
    })
      .then((response) => response.text())
      .then((data) => {
        console.log('Response: ' + data);
      })
      .catch((error) => {
        console.error('Error:', error);
      });
  });
});
