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
      	// time: Firebase.ServerValue.TIMESTAMP,
      	comments: 0
    });
  };
  $scope.addComment = function(post, comment) {
    if (post.comments == 0) {
    	console.log(post.comments);
    	console.log(post.$id);
    	var foo = firebase.database().ref().child("posts").child(post.$id);
    	console.log(foo);
    	var newChildRef = foo.push([]);
	      post.comment = newChildRef.$keyAt();
	      $scope.posts.$save(post); 
      // var foo = new Firebase("https://penny-fyt-123.firebaseio.com/posts/" + post.$id);      
      // var newChildRef = foo.push([]);
      // post.comment = newChildRef.key();
      // $scope.posts.$save(post);  
    } 
    // $scope.songs = []; 
    // var baz = new Firebase("https://penny-fyt-123.firebaseio.com/posts/" + post.$id + "/" + post.comment);      
    // var newChild = baz.push(angular.copy(comment));
    // var playlist = $firebaseArray(baz); 
    // $scope.posts = playlist;
    // console.log(playlist);      
  }


});