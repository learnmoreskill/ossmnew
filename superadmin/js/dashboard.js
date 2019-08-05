$(document).ready(function(){

	/*var rootRef = firebase.database().ref().child('users');

	rootRef.on("child_added",snap=> {

		//alert(snap.val());
		var name = snap.child("name").val();
		var email = snap.child("email").val();

		$("#table_body").append("<tr><td>" + name + "</td><td>" + email + 
			"</td><td><button>Remove</button></td></tr>");

	});*/

	var rootRef = firebase.database().ref().child('SchoolList');
	var sn = 1;
	rootRef.on("child_added",snap=> {

		//alert(snap.val());
		var schoolname = snap.key;
		var url = snap.val();
		
		$("#table_body").append("<tr><td>" + sn + "</td><td>" + schoolname + "</td><td>" + url + 
			"</td><td><button>Details</button></td></tr>");

		sn++;

	});
	/*var rootRef = firebase.database().ref().child('SchoolList');
	rootRef.once('value', function(snapshot) {
		  snapshot.forEach(function(childSnapshot) {

		    var childKey = childSnapshot.key;
		    var childData = childSnapshot.val();
		    $("#table_body").append("<tr><td>" + childKey + "</td><td>" + childData + 
			"</td><td><button>Details</button></td></tr>");

		  });
		});*/
});
