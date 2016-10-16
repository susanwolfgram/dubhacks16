var app = angular.module("myApp", ["firebase"]);

app.controller("myCtrl", function($scope, $firebaseObject, $firebaseArray, $firebaseAuth, $interval) {
	var user; 
	$scope.handle = false; 
	$scope.fileName = false; 
	var currentUser; 
	var usersFB = firebase.database().ref().child("users"); 
	var usersArr = $firebaseArray(usersFB); 
	var userObj;
	$scope.userName = false; 
	$scope.listClicked = false; 
	$scope.yesComments = false; 
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
	var setVariables;


	function myTimer() {
		console.log('hello from the timer');

	    $scope.credits = userObj.credit;
	    $scope.userName = userObj.handle; 
	    $scope.$digest();
	}

	$interval(myTimer, 1000, 3);
	
	$scope.load = function () {
        if (getCookie("user") != "") {
        	user = getCookie("user"); 
        	$scope.userEmail = $scope.email; 
	     	currentUser = firebase.database().ref().child("users").child(user);
			userObj = $firebaseObject(currentUser);
			console.log(userObj);
			$scope.handle = true; 
			ref = firebase.database().ref().child("posts");
	     	$scope.$digest();
	     	$scope.credits = userObj.credit; //not registering... need async function
	     	console.log(userObj.credit);
        }
    }

 //    function setCookie(cname, cvalue, exdays) {
	//     //var d = new Date();
	//     //d.setTime(d.getTime() + (exdays*24*60*60*1000));
	//     //var expires = "expires="+ d.toUTCString();
	//     document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	// }
	function setCookie(cname, cvalue) {
	    //var d = new Date();
	    //d.setTime(d.getTime() + (exdays*24*60*60*1000));
	    //var expires = "expires="+ d.toUTCString();
	    document.cookie = cname + "=" + cvalue + ";";
	}

	function getCookie(cname) {
	    var name = cname + "=";
	    var ca = document.cookie.split(';');
	    for(var i = 0; i <ca.length; i++) {
	        var c = ca[i];
	        while (c.charAt(0)==' ') {
	            c = c.substring(1);
	        }
	        if (c.indexOf(name) == 0) {
	            return c.substring(name.length,c.length);
	        }
	    }
	    return "";
	}
	
	$scope.signIn = function() {
		firebase.auth().signInWithEmailAndPassword($scope.email, $scope.password).then(function(firebaseUser) {
     	console.log("Signed in as:", firebaseUser.uid);
     	user = firebaseUser.uid; 
     	$scope.userEmail = $scope.email; 
     	currentUser = firebase.database().ref().child("users").child(user);
		userObj = $firebaseObject(currentUser);
		console.log(userObj);
		$scope.handle = true; 
		setCookie("user", user); 
     	$scope.$digest(); 	
     	myTimer(); 
     	var form2 = document.getElementById("signInForm");
		form2.reset();

   	}).catch(function(error) {
		  // Handle Errors here.
		  var errorCode = error.code;
		  var errorMessage = error.message;
		});
	}

	

	$scope.signOut = function() {
		firebase.auth().signOut().then(function() {
			// document.cookie = "user=;";
			//document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
			setCookie("user", "");
			$scope.handle = false; 
			$scope.$digest();
			$interval.cancel();
			//clearInterval(myVar);
		  // Sign-out successful.
		}, function(error) {
		  // An error happened.
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
    $scope.fileName = true; 
    $scope.$digest();
    }

	$scope.addPost = function() {
		$scope.posts.$add({
			showComments: false, 
			user: userObj.handle, 
			userImage: userObj.image,
		  	text: $scope.newPostText ? $scope.newPostText : "",
		  	cents: 0,
			image: imgUrl? imgUrl : "",
		  	time: firebase.database.ServerValue.TIMESTAMP,
		  	comments: 0
		});
		var form = document.getElementById("addingPost");
		form.reset();
		$scope.fileName = false; 
	};

	$scope.addComment = function(post, comment) {
		if (post.comments == 0) {
			console.log(post.$id);
			post.comments = [{"comment" : comment, "user" : userObj.handle}]; 
		} else {
		    console.log(post.comments);
		    post.comments.push({"comment": comment, "user": userObj.handle});
		}
		post.cents += 2; 
		$scope.posts.$save(post); 
		userObj.credit -= 2; 

		userObj.$save(); 
		myTimer();

		// var tarea = document.querySelectorAll(".addComm");
		// var i;
		// for (i = 0; i < tarea.length; i++) {
		//     tarea[i].value = " ";
		// }
	}

	//$scope.yesComments = false; 

	$scope.displayComments = function(post) {
		//$scope.yesComments = !$scope.yesComments; 
		post.showComments = !post.showComments; 

		$scope.$digest();
	}

	$scope.likePost = function(post) {
		post.cents++;
		$scope.posts.$save(post); 
		userObj.credit--; 

		userObj.$save(); 
		myTimer();
	}

	$scope.addOneDollar = function() {
		userObj.credit += 100; 
		userObj.$save(); 
	}

	function addOneDollar() {
		console.log(userObj);
		userObj.credit += 100; 
		userObj.$save(); 
	}

});







