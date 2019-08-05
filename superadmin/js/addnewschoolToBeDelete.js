function createFirebaseEntry(schoolName,dbName){

		var url = 'https://'+dbName+'.a1pathshala.com/manager/'

		// Get a reference to the database service
      	var firebaseRef = firebase.database().ref().child('SchoolList');

		firebaseRef.child(schoolName).set(url);
	
} 


function helloworld(){

		var a = 'hhh';
	
} 
