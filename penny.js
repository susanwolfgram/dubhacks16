var app = angular.module("myApp", ["firebase"]);

app.controller("myCtrl", function($scope, $firebaseObject, $firebaseArray, $firebaseAuth) {
	var user; 
	var userEmail; 
	// $scope.addUser = function() {
	// 	firebase.auth().createUserWithEmailAndPassword($scope.email, $scope.password).then(function(firebaseUser) {
 //     	console.log("Signed in as:", firebaseUser.uid);
 //     	user = firebaseUser.uid; 
 //     	userEmail = $scope.email; 
 //   	}).catch(function(error) {
	// 	  // Handle Errors here.
	// 	  var errorCode = error.code;
	// 	  var errorMessage = error.message;
	// 	});
	// }
	$scope.signIn = function() {
		firebase.auth().signInWithEmailAndPassword($scope.email, $scope.password).then(function(firebaseUser) {
     	console.log("Signed in as:", firebaseUser.uid);
     	user = firebaseUser.uid; 
     	userEmail = $scope.email; 
   	}).catch(function(error) {
		  // Handle Errors here.
		  var errorCode = error.code;
		  var errorMessage = error.message;
		});
	}

	// var auth = $firebaseAuth();

 //  // login with Facebook
 //  auth.$signInWithPopup("facebook").then(function(firebaseUser) {
 //    console.log("Signed in as:", firebaseUser.uid);
 //  }).catch(function(error) {
 //    console.log("Authentication failed:", error);
 //  });
  //var ref = firebase.database().ref().child("data");
  //var syncObject = $firebaseObject(ref);
  // synchronize the object with a three-way data binding
  // click on `index.html` above to see it used in the DOM!
  //syncObject.$bindTo($scope, "data");
  // download the data into a local object
  //$scope.data = $firebaseObject(ref);
  // putting a console.log here won't work, see below
  var ref = firebase.database().ref().child("posts");
  // create a synchronized array
  $scope.posts = $firebaseArray(ref);
  // add new items to the array
  // the message is automatically added to our Firebase database!
  $scope.addPost = function() {
    $scope.posts.$add({
    	user: user, 
      	text: $scope.newPostText,
      	cents: 0,
      	time: Firebase.ServerValue.TIMESTAMP,
      	comments: ""
    });
  };


});