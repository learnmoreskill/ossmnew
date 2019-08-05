/*var firebaseKeyRef = firebaseRef.child('aaa');

firebaseKeyRef.on('value',function(datasnapshot){
	output.innerText = datasnapshot.val();
});*/

$(document).ready(function(){

	var rootRef = firebase.database().ref().child('users');

	rootRef.on("child_added",snap=> {

		//alert(snap.val());
		var name = snap.child("name").val();
		var email = snap.child("email").val();

		$("#table_body").append("<tr><td>" + name + "</td><td>" + email + 
			"</td><td><button>Remove</button></td></tr>");

	});
});






function submitClick(){
	var schoolName = document.getElementById('schoolName').value;
	var dbName = document.getElementById('dbName').value;


	if (schoolName==='' || dbName==='') {

		window.alert('Please fill the all the fields');
	
	}else{

		// Get a reference to the database service
      	var firebaseRef = firebase.database().ref();

		firebaseRef.child(schoolName).set(dbName);
	}

	

	
}