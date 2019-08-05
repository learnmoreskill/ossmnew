// Initialize Firebase
      var config = {
        apiKey: "AIzaSyBkNwU91Kit-yI0gZDupb2Eg6gRtsb8-_c",
        authDomain: "a1pathshalateachers.firebaseapp.com",
        databaseURL: "https://a1pathshalateachers.firebaseio.com",
        projectId: "a1pathshalateachers",
        storageBucket: "a1pathshalateachers.appspot.com",
        messagingSenderId: "758691218608"
      };
      firebase.initializeApp(config);


        // Use the shorthand notation to retrieve the default app's services
      //var defaultStorage = firebase.storage();
      var defaultDatabase = firebase.database();

      


      /*ref.once('value', function(snapshot) {
        snapshot.forEach(function(childSnapshot) {
          var childKey = childSnapshot.key;
          var childData = childSnapshot.val();
          // ...
        });
      });*/ 
