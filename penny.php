<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Set meta properties -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Penny-fyt</title>
		
		<!-- Styles -->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

		<!-- AngularJS -->
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>

		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">

		<!-- AngularFire -->
		<script src="https://cdn.firebase.com/libs/angularfire/2.0.2/angularfire.min.js"></script>
		
		<!-- Scripts -->
		<link href="penny1.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="penny.js"></script>

<script src="https://www.gstatic.com/firebasejs/3.5.0/firebase.js"></script>
<script>
	// Initialize Firebase
	var config = {
	apiKey: "AIzaSyDeKkdADM8ybE_etN7XwiyrA-tfSWVozi4",
	authDomain: "penny-fyt-123.firebaseapp.com",
	databaseURL: "https://penny-fyt-123.firebaseio.com",
	storageBucket: "penny-fyt-123.appspot.com",
	messagingSenderId: "370933887602"
	};
	firebase.initializeApp(config);
</script>
<!-- <script src="https://www.gstatic.com/firebasejs/3.5.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/3.5.0/firebase-auth.js"></script> -->

	</head>

	<!-- Initiate app and controller on body -->
	<body ng-app="myApp" ng-controller="myCtrl" ng-init="load()">
	<div class="container">
		<header>
			<div class="head-circle"></div>
		</header>

		<!-- Add Money -->
		<?php require_once('./config.php'); ?>
		<form action="charge.php" method="post" ng-show="handle">
		  <button ng-click="addOneDollar()"> <!-- not sure how to add one dollar after success --> 
		  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
		          data-key="<?php echo $stripe['publishable_key']; ?>"
		          data-description="Access for a year"
		          data-amount="100"
		          data-locale="auto">  	
		  </script>
		  </button>
		</form>
		<!-- <button ng-click="addOneDollar()">Test Add One Dollar</button> -->


		<!-- sign in -->
		<form ng-submit="signIn()" ng-show="!handle" >
			<input type="text" ng-model="email"/>
			<input type="text" ng-model="password"/>
			<button type="submit">Sign In</button>
		</form>

		<!-- Add Post  -->
	    <div ng-show="handle">
				<!-- <div class="post"> -->
			    <form ng-submit="addPost()" ng-show="handle">
			      <textarea ng-model="newPostText" placeholder="Compose a post..."></textarea>
			      <div class="top">
			        <input type="file" onchange="angular.element(this).scope().previewFile()" style="float:left;" />
			        <img ng-show="fileName" src="" id="preview" height="200px" width="200px" alt="Image preview..." style="float:right">
			        <!-- <button ng-click="addImage()">Add Post</button> -->
		    	<!-- </div> -->
			      <button class="md-button" type="submit">Add Post</button>
			    </form>
			    </div>
	    </div>
	
		<!-- Posts -->
		<div id="posts" ng-show="handle">
		    <ul >
		      <li ng-repeat="post in posts | orderBy : 'cents' : true">
		      <div>
		        <i class="material-icons">account_circle</i>
		        <p>{{post.text}}</p>
		        <img ng-show="post.image != ''" src="{{post.image}}" alt="image" height="200px" width="200px"  />
		        <br />
		        <div class="writeComment">
					<p>Write a comment:</p>
					<textarea ng-model="comment" placeholder="Type something..."></textarea>
					<button ng-click="addComment(post, comment)">Add 2 cents</button>
				</div>
		        <!-- <input ng-model="comment"/> -->
		        <!-- <button ng-click="addComment(post, comment)">Add 2 cents</button> -->
		        <button ng-click="likePost(post)">+1 cent</button>
		        <!-- delete a message -->
		        <button ng-click="posts.$remove(post)">Delete Post</button>
		     
		      </div>
		      </li>
		    </ul>
		    </div>
		 
	    


	    

	    
    	<button class="md-button" ng-click="signOut()" ng-show="handle">Sign Out</button>
    	</div>
    
	</body>
</html>






