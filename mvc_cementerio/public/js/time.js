function updateTime() {
  const now = new Date();

  // Opciones para fecha completa
  const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit' };

  const formattedDate = now.toLocaleDateString('es-AR', dateOptions);
  const formattedTime = now.toLocaleTimeString('es-AR', timeOptions);

  document.getElementById('footerCurrentTime').textContent = `${formattedDate}, ${formattedTime}`;
}

// Actualiza inmediatamente y cada segundo
updateTime();
setInterval(updateTime, 1000);
