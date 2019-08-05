firebase.auth().onAuthStateChanged(function(user) {
    
  if (user) {
    
    $(".login-cover").hide();

    var dialog = document.querySelector('#loginDailog');
    
    if (! dialog.showModal) {
      dialogPolyfill.registerDialog(dialog);
    }
    
    dialog.close();




      //check authority of admin to hide or show
      console.log(user.email);
      if (user.email.trim()==='krishnagek@gmail.com'.trim()) {

        $(".hacksterHide").show();

      } 
      



  } else {
    // No user is signed in.

    $(".login-cover").show();

    var dialog = document.querySelector('#loginDailog');
    
    if (! dialog.showModal) {
      dialogPolyfill.registerDialog(dialog);
    }
    
    dialog.showModal();
    
    $("#loginProgress").hide();
    $("#loginBtn").show();
    
  }
  
}); 


/* LOGIN PROCESS */

function loginBtnClicked(){

    var email = $("#loginEmail").val();
    var password = $("#loginPassword").val();

    if(email != "" && password != ""){
            
        $("#loginProgress").show();
        $("#loginBtn").hide();

        firebase.auth().signInWithEmailAndPassword(email, password).catch(function(error) {
          
          $("#loginError").show().text(error.message);

          $("#loginProgress").hide();
          $("#loginBtn").show();

        });

    }

}


/* LOGOUT PROCESS */

function logoutBtnClicked(){

    firebase.auth().signOut().then(function(){
      // Sign-out successful.

    },function(error){
      // An error happened 
      alert(error,message);
    });

}