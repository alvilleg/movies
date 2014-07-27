<html ng-app="myApp">
	<head>
    <script src="./js/angular.js"></script>
    <script src="./js/ui-bootstrap-tpls.min.js"></script>
    <script src="./js/dropdown-controller.js"></script>
    <link href="./css/bootstrap.min.css" rel="stylesheet" />
    <link href="./css/sg.css" rel="stylesheet">

    </head>
<body>
    
	<div class="container"  ng-controller="myController">
	  <div class="row header">
	    <h1>AngularJS HTML5 Autocomplete</h1>
	    <h3>Type out a flight destination</h3>
	  </div>
	  <div class="row body">
	    <form action="#">
	      <ul>
	        <li>
	          <p class="left">
	            <input type="text" keyboard-poster post-function="searchFlight" name="first_name" placeholder="Zurich, Switzerland" 
	            list="_countries" style='margin-bottom: 100px'>
	            <datalist id="_countries">
	             	<select style="display: none;" id="_select" name="_select" 
	             	ng-model='selectedCountry' 
	             	ng-options='k as v for (k,v) in countries'></select>
				</datalist>
	          </p>
	         
	        </li>        
	      </ul>
	    </form>  
	  </div>
	</div>
</body>
</html>