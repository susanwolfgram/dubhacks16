var app = angular.module("myApp", ["firebase"]);

app.controller("myCtrl", function($scope, $firebaseObject, $firebaseArray, $firebaseAuth) {
	$scope.authObj.$signInWithEmailAndPassword("skwolf@uw.edu", "123456").then(function(firebaseUser) {
	  console.log("Signed in as:", firebaseUser.uid);
	}).catch(function(error) {
	  console.error("Authentication failed:", error);
	});


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
  var ref = firebase.database().ref().child("messages");
  // create a synchronized array
  $scope.messages = $firebaseArray(ref);
  // add new items to the array
  // the message is automatically added to our Firebase database!
  $scope.addMessage = function() {
    $scope.messages.$add({
      text: $scope.newMessageText
    });
  };


});