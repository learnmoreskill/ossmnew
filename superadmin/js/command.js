$(document).ready(function(){

	var urls = [];
	var rootRef = firebase.database().ref().child('SchoolList');
/*
	rootRef.on("child_added",snap=> {

		var url = snap.val();
		urls.push(url);
		//$("#output").append(  urls );
		
	});
	console.log(urls);*/

	/*for (var i = 0; i < arr.length; i++) {
    	console.log(arr[i]);
	}*/

	var schoolList = document.getElementById("schoolList");

	rootRef.once('value', function(snapshot) {
		  snapshot.forEach(function(childSnapshot) {

		    var childData = childSnapshot.val();

		    //console.log(childData);

		    urls.push(childData);

		    $("#url_table_body").append("<tr><td>" + childData + "</td></tr>");


		  });

		  console.log(urls);
		  schoolList.value = JSON.stringify(urls);
		  



		});



});

