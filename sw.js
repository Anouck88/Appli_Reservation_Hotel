// Installation du service worker
self.addEventListener('install', (event) => {
    event.waitUntil(
      caches.open('reservation-hotel-v1').then((cache) => {
        return cache.addAll([
          '/',
          '/Hotel_reservation.html',
          '/Manifest.json',
          '/traitement_reservation.php',
          '/photo_hotel.jpg',
          // Ajoutez d'autres fichiers à mettre en cache selon votre besoin
        ]);
      })
    );
  });
  
  // Activation du service worker
  self.addEventListener('activate', (event) => {
    // Nettoyage des anciens caches si nécessaire
  });
  
  // Intercepter les requêtes réseau
  self.addEventListener('fetch', (event) => {
    event.respondWith(
      caches.match(event.request).then((response) => {
        return response || fetch(event.request);
      })
    );
  });
  
  // Gestion des notifications
  self.addEventListener('push', (event) => {
    const options = {
      body: event.data.text(),
      icon: '/icons/photo_hotel.jpg',
      badge: '/icons/photo_hotel.jpg',
    };
  
    event.waitUntil(self.registration.showNotification('Nouvelle notification', options));
  });
  
  // Gestion de la synchronisation en arrière-plan
  self.addEventListener('sync', (event) => {
    if (event.tag === 'sync-reservations') {
      event.waitUntil(syncReservations());
    }
  });
  
  function syncReservations() {
    // Récupérer les réservations en attente de synchronisation depuis l'IndexedDB
    // Envoyer les réservations au serveur
  }
  