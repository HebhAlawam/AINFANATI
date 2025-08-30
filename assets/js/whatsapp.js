 // Toggle popup visibility
 function togglePopup() {
    const popup = document.getElementById('whatsapp-popup');
    if (popup.style.display === 'none' || popup.style.display === '') {
       popup.style.display = 'block';
    } else {
       popup.style.display = 'none';
    }
 }

 // Start WhatsApp Chat
 function startChat() {
    window.open('https://wa.me/963959869575?text=Hello%2C%20I%20need%20assistance!', '_blank');
 }