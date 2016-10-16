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

				<?php
				  if (isset($_GET['code'])) { // Redirect w/ code
				      $code = $_GET['code'];
				      $form_url = "https://connect.stripe.com/oauth/token";
				      // This is the data to POST to the form. The KEY of the array is the name of the field. The value is the value posted.
				      $data_to_post = array();
				      $data_to_post['client_secret'] = 'sk_test_XoQIPeA6WbJQomV7yMJ8K7F8';
				      $data_to_post['code'] = $code;
				      $data_to_post['grant_type'] = 'authorization_code';
				      // Initialize cURL
				      $curl = curl_init();
				      // Set the options
				      curl_setopt($curl,CURLOPT_URL, $form_url);
				      // This sets the number of fields to post
				      curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
				      // This is the fields to post in the form of an array.
				      curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
				      //execute the post
				      $result = curl_exec($curl);

				     $userID =  $result["stripe_user_id"];

				      //close the connection
				      curl_close($curl);
				  }
				?>

	</head>

	<!-- Initiate app and controller on body -->
	<body ng-app="myApp" ng-controller="myCtrl" ng-init="load()">
	<?php $count = 0; ?> 
	<div class="container">
		<nav>
			<button class="md-button" ng-click="signOut()" ng-show="handle">Sign Out</button>
			<div style="float: left; font-size: 25px; color: #BDBDBD;">Penny-fyt</div>	
			<p ng-show="handle">Logged in: {{userName}} Credits: {{credits}}</p>
			 <!-- <div class="dropdown">
  				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">My Account</button>
 				 <ul class="dropdown-menu">
				    <li><a href="#">Credits: {{credits}}</a></li>
				    <li><a href="#">Log Out</a></li>
				    
  				</ul>
			</div> -->
		</nav>

		
		


		<!-- sign in -->
		<form ng-submit="signIn()" ng-show="!handle" id="signInForm">
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
		      <li ng-repeat="post in posts | orderBy : 'cents' : true" class="mt4 br3 ba b--orange pa0 bg-white w-80 ml6 posts">

		       <!-- | orderBy : 'cents' : true -->
				<div class="dib w3 tc absolute">
					<!-- Profile pic -->
					<img src="{{post.userImage}}" alt="user image" class="postAvatar br-100 mw4 ba b--orange db" />
					<!-- Like -->
					<a href="" ng-click="likePost(post)"><div class="like buttons"></div></a>					 

		       </div>

				<div class="postContent dib v-top pl3 w-100">
				<div class="name mt0 mb3 w-100 db b">
		        	<h1 class="name mt0 mb0 white">{{post.user}}</h1>
	        	</div>
		        <p class="f3 black-70 lh-copy postpara">{{post.text}}</p>
		        <p style="margin-left: 20px;"><i class="fa fa-money" aria-hidden="true"></i>{{post.cents}} cents</p>
		        <img ng-show="post.image != ''" src="{{post.image}}" alt="image" width="500px" class="pl5" />
		        </div>
		           <div class="commentSection pb2 pt2">
		        	<div class="writeComment ma3 pa4 br3 ba b--orange f3">
						<p class="worksans orange">Write a comment:</p>
						<textarea class="addComm" ng-model="comment" placeholder="Leave your two cents..." class="form-control w-90" rows="1"></textarea>
						<button ng-click="addComment(post, comment); comment = ''" class="mt0 fr cf postComment br3 f4 pa2 ph3 bg-orange">Post</button>
					</div>
					<p ng-show="post.comments != 0" class="tc orange f4 center"><a href="" ng-click="displayComments(post)" class="orange hoverNone">Show all comments</a></p>
		       
	           <div id="comments" ng-show="post.showComments">
		        	<div ng-repeat="comment in post.comments" class="writeComment w-90 center pa3 pl4 br3 ba b--black-70 f3 mb2">
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

		<a ng-show="handle" href="https://connect.stripe.com/oauth/authorize?response_type=code&client_id=ca_9NxjcPclGzMJ1JtofXOlbevGGglpwRZa&scope=read_write"><input type="image" src="connect.png"></input></a>
    </div>
	</body>
</html>






