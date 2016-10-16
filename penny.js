// Create application with dependency 'firebase'
var myApp = angular.module('myApp', ['firebase']);

// Bind controller, passing in $scope, $firebaseAuth, $firebaseArray, $firebaseObject
myApp.controller('myCtrl', function($scope, $firebaseAuth, $firebaseArray, $firebaseObject){
	$scope.user = {}
	// $scope.submit = function() {
	// 	alert('Name: ' + $scope.user.handle + '   Email:' + $scope.user.email)
	// }
	    // Create a variable 'ref' to reference your firebase storage
	var ref = new Firebase("https://penny-fyt-123.firebaseio.com/");

	firebase.auth().signInWithEmailAndPassword($scope.email, $scope.password).catch(function(error) {
	  // Handle Errors here.
	  var errorCode = error.code;
	  var errorMessage = error.message;
	  // ...
	});


	    //Create references to store tweets and users
	// var dataPosts = ref.child('posts');
	// var dataUsers = ref.child('users'); 
	//    	// Create a firebaseArray of your tweets, and store this as part of $scope

 //    	// Create a firebaseObject of your users, and store this as part of $scope
	// $scope.posts = $firebaseArray(dataPosts);
	// $scope.users = $firebaseObject(dataUsers);

	// 	// Create authorization object that referes to firebase
	// $scope.authObj = $firebaseAuth(ref);

	// // Test if already logged in
	// var authData = $scope.authObj.$getAuth();
	// if (authData) {
	// 	$scope.userId = authData.uid;
	// } 

	// // SignUp function
	// $scope.signUp = function() {
	// 	// Create user
	// 	$scope.authObj.$createUser({
	// 		email: $scope.email,
	// 		password: $scope.password, 			
	// 	})

	// 	// Once the user is created, call the logIn function
	// 	.then($scope.logIn)

	// 	// Once logged in, set and save the user data
	// 	.then(function(authData) {
	// 		$scope.userId = authData.uid;
	// 		$scope.users[authData.uid] ={
	// 			handle:$scope.handle, 
	// 			userImage:$scope.userImage,
	// 		}
	// 		$scope.users.$save()
	// 	})

	// // Catch any errors
	// 	.catch(function(error) {
	// 		console.error("Error: ", error);
	// 	});
	// }

	// // SignIn function
	// $scope.signIn = function() {
	// 	$scope.logIn().then(function(authData){
	// 		$scope.userId = authData.uid;
	// 	})
	// }

	// // LogIn function
	// $scope.logIn = function() {
	// 	return $scope.authObj.$authWithPassword({
	// 		email: $scope.email,
	// 		password: $scope.password
	// 	})
	// }

	// // LogOut function
	// $scope.logOut = function() {
	// 	$scope.authObj.$unauth()
	// 	$scope.userId = false
	// }

	// $scope.tweet = function() {
	// 	$scope.posts.$add({
	// 		text: $scope.newPost,
	// 		userId: $scope.userId,
	// 		likes: 0,
	// 		time: Firebase.ServerValue.TIMESTAMP
	// 	}).then(function() {
	// 		$scope.newPost = ""; 
	// 		$scope.posts.$save(); 
	// 	})
	// }

	// $scope.like = function(tweet) {
	// 	tweet.likes++; 
	// 	console.log('test')
	// 	$scope.tweets.$save(tweet);
	// }
})





	
    /* 
		-- Insert authentication code here
    */
	
	// Write an accesible tweet function to save a tweet
		
		/* Add a new object to the tweets array using the firebaseArray .$add method. Inclue:
			text:text in textarea,
			userId:current user id,
			likes:0,
			time:Firebase.ServerValue.TIMESTAMP // tells firebase server to save timestamp
		*/
		

		// Once the tweet is saved, reset the value of $scope.newTweet to empty string


	// Function to like a tweet
	

