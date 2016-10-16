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
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:600|Work+Sans:600" rel="stylesheet">
		<link rel="stylesheet" href="https://unpkg.com/tachyons@4.5.3/css/tachyons.min.css"/>

		<!-- AngularJS -->
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>

		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">

		<!-- AngularFire -->
		<script src="https://cdn.firebase.com/libs/angularfire/2.0.2/angularfire.min.js"></script>
		
		<!-- Scripts -->
		<link href="penny1.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="penny.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
		<nav>
			<button class="md-button" ng-click="signOut()" ng-show="handle">Sign Out</button>
			<div class="head-circle" style="float: left;"></div>	
			<p ng-show="handle">Credits: {{credits}}</p>
			 <!-- <div class="dropdown">
  				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">My Account</button>
 				 <ul class="dropdown-menu">
				    <li><a href="#">Credits: {{credits}}</a></li>
				    <li><a href="#">Log Out</a></li>
				    
  				</ul>
			</div> -->
		</nav>

		
		


		<!-- sign in -->
		<form ng-submit="signIn()" ng-show="!handle" >
			<input class="form-control" type="text" placeholder="Email Address" ng-model="email"/>
			<input class="form-control" type="password" placeholder="Password" ng-model="password"/>
			<button class="form-control" type="submit">Sign In</button>
		</form>

		<!-- Add Post  -->
	    <div id="addPost" ng-show="handle">
				<!-- <div class="post"> -->
			    <form id="addingPost" ng-submit="addPost()" ng-show="handle">
			      <textarea ng-model="newPostText" placeholder="Compose a post..." class="form-control" rows="5"></textarea>

			      <!-- <input type="file" onchange="angular.element(this).scope().previewFile()" style="float:left;" class="filestyle" data-classButton="btn btn-primary" data-input="false" data-classIcon="icon-plus" data-buttonText="Upload an image" /> -->
			        <input type="file" onchange="angular.element(this).scope().previewFile()" style="float:left;" />
			        <br />
			        <img ng-show="fileName" src="" id="preview" height="200px" width="200px" alt="Image preview..." style="clear:both;">
			  		<br />
			      <button class="md-button" type="submit" style="display: block;clear: both;">Add Post</button>
			    </form>
			    
	    </div>
	
		<!-- Posts -->
		<div class="posts" ng-show="handle">
		    <ul >
		      <li ng-repeat="post in posts" class="mt4 br3 ba b--orange pa0 bg-white w-80 ml6">
		       <!-- | orderBy : 'cents' : true -->
				<div class="dib w3 tc">
					<!-- Profile pic -->
					<img src="{{post.userImage}}" alt="user image" class="postAvatar br-100 mw4 ba b--red db" />
					<!-- Like -->
					<div title="add 1 cent" ng-click="likePost(post)" class="like buttons"></div>
					 {{post.cents}} cents
		       </div>

				<div class="postContent dib v-top pl3 w-90">
				<div class="name mt0 w-100 db">
		        	<h1 class="name mt0 white">{{post.user}}</h1>
	        	</div>
		        <p>{{post.text}}</p>
		        <img ng-show="post.image != ''" src="{{post.image}}" alt="image" width="500px"  />
		        </div>
		           <div class="commentSection pb2 pt2">
		        	<div class="writeComment ma3 pa4 br3 ba b--orange f3">
						<p class="worksans orange">Write a comment:</p>
						<textarea ng-model="comment" placeholder="Leave your two cents..." class="form-control w-90" rows="1"></textarea>
						<button ng-click="addComment(post, comment)" class="mt0 fr cf postComment br3 f4 pa2 ph3 bg-orange">Post</button>
					</div>
					<p ng-show="post.comments != 0" class="tc orange f4 center"><a href="" ng-click="displayComments(post); showComments = !showComments;" class="orange hoverNone">Show all comments</a></p>
		       
	           <div id="comments" ng-class="{ 'hidden': ! showComments }">
		        	<div ng-repeat="comment in commentArr" class="writeComment w-90 center pa3 pl4 br3 ba b--black-70 f3 mb2">
						<p class="worksans black-70">{{comment.user}}</p>
						<p class="black-50 f4">{{comment.comment}}</p>
					</div>
				</div>

			
		        <!-- <input ng-model="comment"/> -->
		        <!-- <button ng-click="addComment(post, comment)">Add 2 cents</button> -->
		        <!-- <button ng-click="likePost(post)">+1 cent</button> -->
		        <!-- delete a message -->
		        <button ng-show="post.user == userName" ng-click="posts.$remove(post)">Delete Post</button>
		    
		    
		      </li>
		    </ul>
		</div>
		 
	    
    	
    	
    	<!-- Add Money -->
		<?php require_once('./config.php'); ?>
		<form action="charge.php" method="post" ng-show="handle">
		  <button ng-click="addOneDollar()"> <!-- not sure how to add one dollar after success --> 
		  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
		          data-key="pk_test_6TxN5xUdWFAeyDLbeHyoPJ6Q"
		          data-description="Access for a year"
		          data-amount="100"
		          data-locale="auto">  	
		  </script>
		  </button>
		</form>
    </div>
	</body>
</html>






