var app = angular.module("myApp", ["firebase"]);

app.controller("myCtrl", function($scope, $firebaseObject, $firebaseArray, $firebaseAuth) {
	var user; 
	$scope.handle = false; 
	var currentUser; 
	var usersFB = firebase.database().ref().child("users"); 
	var usersArr = $firebaseArray(usersFB); 
	//var userEmail; 
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
	var userObj;
	$scope.signIn = function() {
		firebase.auth().signInWithEmailAndPassword($scope.email, $scope.password).then(function(firebaseUser) {
     	console.log("Signed in as:", firebaseUser.uid);
     	user = firebaseUser.uid; 
     	$scope.userEmail = $scope.email; 
     	currentUser = firebase.database().ref().child("users").child(user);
		userObj = $firebaseObject(currentUser);
		console.log(userObj);
		$scope.handle = true; 
		//console.log(userObj["handle"]);
		// var currentUser = userArr.$indexFor("" + user);
		// console.log(userArr[currentUser]);
     	$scope.$digest();
   	}).catch(function(error) {
		  // Handle Errors here.
		  var errorCode = error.code;
		  var errorMessage = error.message;
		});
	}

	var ref = firebase.database().ref().child("posts");

	// create a synchronized array
	$scope.posts = $firebaseArray(ref);
	// add new items to the array
	// the message is automatically added to our Firebase database!
	

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
            }).catch(function(error) {
                console.log('error while downloading file');
            });
        });
    }

	$scope.addPost = function() {
		$scope.posts.$add({
			user: user, 
		  	text: $scope.newPostText,
		  	cents: 0,
			image: imgUrl? imgUrl : "",
		  	time: firebase.database.ServerValue.TIMESTAMP,
		  	comments: 0
		});
		console.log(userObj.handle);
	};

	$scope.addComment = function(post, comment) {
		if (post.comments == 0) {
			console.log(post.$id);
			post.comments = [comment]; 
		} else {
		    console.log(post.comments);
		    post.comments.push(comment);
		}
		post.cents += 2; 
		$scope.posts.$save(post); 
	}

	$scope.likePost = function(post) {
		post.cents++;
		$scope.posts.$save(post); 
	}

	function addOneDollar() {
		currentUser.credit += 100; 
		usersArr.$save(currentUser); 
	}

});







