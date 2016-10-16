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
			image: "",
		  	// time: Firebase.ServerValue.TIMESTAMP,
		  	comments: 0
		});
	};

	//IMAGES
	var storageRef = firebase.storage().ref();
	var imagesRef = storageRef.child('images');
	var imgUrl; 

	$scope.previewFile = function(){
	    var file =document.querySelector('input[type=file]').files[0];
	    var metadata = {
	    	contentType: 'image/jpeg'
	};

var uploadTask = storageRef.child('images/' + file.name).put(file, metadata);
	uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
	function(snapshot) {
	    var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
	    console.log('Upload is ' + progress + '% done');
	    switch (snapshot.state) {
	        case firebase.storage.TaskState.PAUSED: 
	            console.log('Upload is paused');
	            break;
	        case firebase.storage.TaskState.RUNNING:
	            console.log('Upload is running');
	            break;
	    }
	    }, function(error) {
	        console.log('error while uploading')
	    }, function() {
	        var starsRef = storageRef.child('images/'+ file.name);
	        starsRef.getDownloadURL().then(function(url) {
	            document.querySelector('#preview').src=url;
	            imgUrl = url; 
	            //var t=document.querySelector('p')
	            //t.innerHTML ='firebase storage path URL: '+url
	        }).catch(function(error) {
	            console.log('error while downloading file');
	        });
	    });
	}
}

	

	$scope.addImage = function() {
		console.log(imgUrl);
		// $scope.posts.$add({
		// 	user: user, 
		//   	text: $scope.newPostText,
		//   	cents: 0,
		//   	image: 
		//   	// time: Firebase.ServerValue.TIMESTAMP,
		//   	comments: 0
		// });
	};

	$scope.addComment = function(post, comment) {
		if (post.comments == 0) {
			console.log(post.$id);
			post.comments = [comment]; 
		    $scope.posts.$save(post); 
		} else {
		    console.log(post.comments);
		    post.comments.push(comment);
		    $scope.posts.$save(post); 
		}
	}

	$scope.likePost = function(post) {
		post.cents++;
		$scope.posts.$save(post); 
	}

});







