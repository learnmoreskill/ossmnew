firebase.auth().onAuthStateChanged(function(user) {
    
  if (user) {
    
    document.getElementById("content_div").style.display = "block";



  } else {
    // No user is signed in.
    window.location.href = "hackster.php";
    
  }
  
}); 
