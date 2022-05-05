<?php
//Written by Dylan Baker 1901368

//NOTE: Some code for the maze game was taken from the below link:
//https://html5.litten.com/make-a-maze-game-on-an-html5-canvas

$AI = $_GET["AI"];
$Embed = $_GET["Embed"];

if ($Embed == 0){
    include("header.php");
}
else{
    echo"<link href=\"../styles/styles1.css\" rel=\"stylesheet\">
<style>
.st-sidebar a {font-family: \"Roboto\", sans-serif}
body,h1,h2,h3,h4,h5,h6,.st-wide {font-family: \"Montserrat\", sans-serif;}
</style>";
}

//Set the title of the page based upon the selected AI
if ($AI === "RBS"){
    echo "<div class=\"st-xlarge st-text-grey\">
   Rule-Based System AI
</div>
<br>
<p id=\"currentDirection\"></p>";
}
if ($AI === "DFS"){
    echo "<div class=\"st-xlarge st-text-grey\">
   Depth-First Search AI
</div>
<br>
<p id=\"currentDirection\"></p>";
}

echo'<section>	
			<div>	
				<canvas id="canvas" width="400" height="400">	
					If you see this the browser does not support HTML5 canvas :)
				</canvas>
				
			</div>	
		
			<script type="text/javascript">	
				
				//Declare variables for the canvas maze game
				var canvas;	
				var ctx;	
		
				//Declare variables for X & Y axis and set starting location.
				var XAxis = 100;	
				var YAxis = 22;
				var newXAxis = 100;	
				var newYAxis = 22;
		
				//Set the weight for each axis
				var XAxisWeight = 1;	
				var YAxisWeight = 1;
		
				//Set the canvas size and image variables	
				var WIDTH = 300;	
				var HEIGHT = 300;	
				var img = new Image();	
		
				//Set variable to track collisions	
				var collisionStatus = 0;	
		
				//Set variables for direction tracking
				var currentDirection = \'left\';	
				var previousDirection = \'left\';	
				var availableDirections = 0;
				
				//Place the current direction on the front-end
				document.getElementById("currentDirection").innerHTML = " The current direction is " + currentDirection;	
		        
				//The below array will be used to track the state of all directions
				//[0] - Up
				//[1] - Down
				//[2] - Left
				//[3] - Right
				var directionsArray = [0,0,0,0];
				
				//Draw a rectangle for the maze
				function rect(x, y, w, h) {
					ctx.beginPath();
					ctx.rect(x, y, w, h);
					ctx.closePath();
					ctx.fill();
				}
	
				//Clear the maze, then re-draw the maze
				function clear() {
					ctx.clearRect(0, 0, WIDTH, HEIGHT);
					ctx.drawImage(img, 0, 0);
				}
	
				//Initialise the canvas, take the canvas from the DOM
				function init() {
					canvas = document.getElementById("canvas");
					ctx = canvas.getContext("2d");
					//Select the image of the maze
					img.src = "maze.gif";
					//Begin the draw function and loop through every 40 milliseconds
					return setInterval(draw, 40);
				}
	
		        //This function modifies the current direction, ensuring that the cube does not backtrack.
				function modifyDirection() {
	                //Use this variable for counting the amount of loops
					var count = 0;
					do {
					    //Make a temporary variable to store a random number
					    var temporaryVariable = Math.floor(Math.random() * 4);
						
					    //Go through the loop until we have a direction that is traversable whilst also not being a direction from out previous path 
						do {	
							temporaryVariable = Math.floor(Math.random() * 4);
						}
						while ((temporaryVariable == 0 && directionsArray[0] == 1 && previousDirection != \'down\') 
						|| (temporaryVariable == 1 && directionsArray[1] == 1 && previousDirection != \'up\') 
						|| (temporaryVariable == 2 && directionsArray[2] == 1 && previousDirection != \'right\') 
						|| (temporaryVariable == 3 && directionsArray[3] == 1 && previousDirection != \'left\'));
	
	
						//Once we have a direction in number form, convert that number into a character for the currentDirection variable
						//after conversion display the current direction on the front-end and return 0 to move on.
						if (temporaryVariable == 0 && previousDirection != \'down\') {
							currentDirection = \'up\';
							document.getElementById("currentDirection").innerHTML = " The current direction is " + currentDirection;
							return 0;
						}
						else if (temporaryVariable == 1 && previousDirection != \'up\') {
							currentDirection = \'down\';
							document.getElementById("currentDirection").innerHTML = " The current direction is " + currentDirection;
							return 0;
						}
						else if (temporaryVariable == 2 && previousDirection != \'right\') {
							currentDirection = \'left\';
							document.getElementById("currentDirection").innerHTML = " The current direction is " + currentDirection;
							return 0;
						}
						else if (temporaryVariable == 3 && previousDirection != \'left\') {
							currentDirection = \'right\';
							document.getElementById("currentDirection").innerHTML = " The current direction is " + currentDirection;
							return 0;
						}
						else {
							count++;
						}
						
					//If the direction cannot be ascertained in 50 loops, return 1 to indicate failure. 
					} while (count != 50);
					return 1;
                }
                
				//This function modifies the current direction, and allows the cube to backtrack. This is only used when the initial function fails
				function modifyDirectionWithBacktracking() {
		            //Make a temporary variable to store a random number
					var temporaryVariable = Math.floor(Math.random() * 4);
					
					//Check the temporary variable with all current directions until a traversable direction is found
					while ((temporaryVariable == 0 && directionsArray[0] != 0) ||
						(temporaryVariable == 1 && directionsArray[1] != 0) ||
						(temporaryVariable == 2 && directionsArray[2] != 0) ||
						(temporaryVariable == 3 && directionsArray[3] != 0)) {
	
						temporaryVariable = Math.floor(Math.random() * 4);
					}
					
					//Once we have a direction in number form, convert that number into a character for the currentDirection variable
					//after conversion display the current direction on the front-end and return 0 to move on.
					if (temporaryVariable == 0 && directionsArray[0] == 0) {
						currentDirection = \'up\';
						document.getElementById("currentDirection").innerHTML = " The current direction is " + currentDirection;
						return 0;
					}
					else if (temporaryVariable == 1 && directionsArray[1] == 0) {
						currentDirection = \'down\';
						document.getElementById("currentDirection").innerHTML = " The current direction is " + currentDirection;
						return 0;
					}
					else if (temporaryVariable == 2 && directionsArray[2] == 0) {
						currentDirection = \'left\';
						document.getElementById("currentDirection").innerHTML = " The current direction is " + currentDirection;
						return 0;
					}
					else if (temporaryVariable == 3 && directionsArray[3] == 0) {
						currentDirection = \'right\';
						document.getElementById("currentDirection").innerHTML = " The current direction is " + currentDirection;
						return 0;
					}
					else {
						return 1;
					}
				}';

if ($AI === "DFS"){
    echo /** @lang JavaScript */"
    //Variables used to track direction in a node tree
	var root = null;
    var activeNode = null;
    var activePath = null;
    
    function DepthFirstSearchDirectionModification() {
        //Use this variable for counting the amount of loops
        var count = 0;
        do {
            //Make a temporary variable to store a random number
            var temporaryVariable = Math.floor(Math.random() * 4);
            
                //Go through the loop until we have a direction that is traversable whilst also not being a direction from out previous path 
				do {
				    temporaryVariable = Math.floor(Math.random() * 4);
				} 
				while ((temporaryVariable == 0 && activeNode.Up == 4 && previousDirection != 'down') 
						|| (temporaryVariable == 1 && activeNode.Down == 4 && previousDirection != 'up') 
						|| (temporaryVariable == 2 && activeNode.Left == 4 && previousDirection != 'right') 
						|| (temporaryVariable == 3 && activeNode.Right == 4 && previousDirection != 'left'));
	
				//Once we have a direction in number form, convert that number into a character for the currentDirection variable
				//after conversion display the current direction on the front-end and return 0 to move on.
				if (temporaryVariable == 0 && previousDirection != 'down') {
				    previousDirection = currentDirection;
				    currentDirection = 'up';
				    document.getElementById(\"currentDirection\").innerHTML = \" The current direction is \" + currentDirection;
					return 0;
				}
				
				else if (temporaryVariable == 1 && previousDirection != 'up') {
				    previousDirection = currentDirection;
				    currentDirection = 'down';
				    document.getElementById(\"currentDirection\").innerHTML = \" The current direction is \" + currentDirection;
					return 0;
				}
				
				else if (temporaryVariable == 2 && previousDirection != 'right') {
				    previousDirection = currentDirection;
				    currentDirection = 'left';
				    document.getElementById(\"currentDirection\").innerHTML = \" The current direction is \" + currentDirection;
					return 0;
				}
				
				else if (temporaryVariable == 3 && previousDirection != 'left') {
				    previousDirection = currentDirection;
				    currentDirection = 'right';
				    document.getElementById(\"currentDirection\").innerHTML = \" The current direction is \" + currentDirection;
					return 0;
				}
				
				else {
				    count++;
				}
				
        } 
        //If the direction cannot be ascertained in 50 loops, return 1 to indicate failure. 
        while (count != 50);
        return 1;
    }";
}

echo /** @lang JavaScript */
"				//This function checks for possible collisions in the direction ahead of the cube
				function checkForCollisions() {
					//get image and pixel data from the maze canvas
                    var imageData = ctx.getImageData(newXAxis, newYAxis, 20, 20);
					var pixelData = imageData.data;
					
					//loop through pixel data to see if there is a black pixel, which would signify a collision
					for (var i = 0; n = pixelData.length, i < n; i += 4) {
						if (pixelData[i] == 0) {
							collisionStatus = 1;
							newXAxis = XAxis;
							newYAxis = YAxis;
						}
					}
				}
				
				//This function checks all directions to see if the cube an move in a particular direction without a collision
				function checkPossibleDirections() {
					availableDirections = 0;
					directionsArray = [0, 0, 0, 0];
					
					//Get image and pixel data for the direction above, check to see if you can traverse upwards
					var imageData = ctx.getImageData(newXAxis, newYAxis - 1, 20, 1);
					var pixelData = imageData.data;
					for (var i = 0; n = pixelData.length, i < n; i += 4) {
						if (pixelData[i] == 0) {
							directionsArray[0] = 1;
						}
					}
	
					//Get image and pixel data for the direction below, check to see if you can traverse downwards
					imageData = ctx.getImageData(newXAxis, newYAxis + 20, 20, 1);
					pixelData = imageData.data;
					for (var i = 0; n = pixelData.length, i < n; i += 4) {
						if (pixelData[i] == 0) {
							directionsArray[1] = 1
						}
					}
	
					//Get image and pixel data for the direction to the left, check to see if you can traverse left
					imageData = ctx.getImageData(newXAxis - 1, newYAxis, 1, 20);
					pixelData = imageData.data;
					for (var i = 0; n = pixelData.length, i < n; i += 4) {
						if (pixelData[i] == 0) {
							directionsArray[2] = 1
						}
					}
	
					//Get image and pixel data for the direction to the right, check to see if you can traverse right
					imageData = ctx.getImageData(newXAxis + 20, newYAxis, 1, 20);
					pixelData = imageData.data;
					for (var i = 0; n = pixelData.length, i < n; i += 4) {
						if (pixelData[i] == 0) {
							directionsArray[3] = 1;
						}
					}
	
					//Check to see what directions are currently available to traverse
					for (var i = 0; i < 4; i++) {
						if (directionsArray[i] == 0) {
							availableDirections = availableDirections + 1;
						}
					}
				}
	
				//begin drawing the cube and start the game
				function draw() {
					clear();
					ctx.fillStyle = \"orange\";
					rect(XAxis, YAxis, 20, 20);
					beginGame();
				}
	";

echo /** @lang JavaScript */"
                init();	
                //This function starts the game
				function beginGame() {	
		
					var success = 0;	
						
					//Reset collisionStatus	variable
					collisionStatus = 0;	
		
					//Update the new XAxis and YAxis	
					newYAxis = YAxis;	
					newXAxis = XAxis;";

if ($AI === "RBS"){
echo /** @lang JavaScript */
"                   switch (currentDirection) {	
						case 'up':  	
							if (YAxis > 0){	
							newYAxis -= YAxisWeight;	
							}	
							break;	
						case 'down':  	
							if (YAxis < HEIGHT ){	
								newYAxis += YAxisWeight;	
							}	
							break;	
						case 'left':  	
							if (XAxis > 0){	
								newXAxis -= XAxisWeight;	
							}	
							break;	
						case 'right':  	
							if ((XAxis < WIDTH)){	
								newXAxis += XAxisWeight;	
							}	
							break;	
					}";
}

if ($AI === "DFS"){
echo /** @lang JavaScript */
"					switch (currentDirection) {
						case 'up':  
							if (YAxis - 0 > 0) {
								newYAxis -= YAxisWeight;
							}
							break;
						case 'down':  
							if (YAxis + 0 < HEIGHT) {
								newYAxis += YAxisWeight;
							}
							break;
						case 'left':  
							if (XAxis - 0 > 0) {
								newXAxis -= XAxisWeight;
							}
							break;
						case 'right':  
							if ((XAxis + 0 < WIDTH)) {
								newXAxis += XAxisWeight;
							}
							break;
					}";
}
echo /** @lang JavaScript */"
checkForCollisions(); 
checkPossibleDirections();
";

if ($AI === "RBS"){
    echo/** @lang JavaScript */"if (collisionStatus == 1){
    ";
}

if ($AI === "DFS"){
    echo/** @lang JavaScript */
    "if (availableDirections > 2 && collisionStatus !=1 ) {
						//Update XAxis and YAxis with new data
						XAxis = newXAxis;
						YAxis = newYAxis;
						checkPossibleDirections();
	
						//The root node will contain information from a tree, if this tree is empty one will need to be made
						if (root == null)
						{
							root = {
								//Set the current position variables
								XAxis: newXAxis,
								YAxis: newYAxis,
	
								//Child Nodes 
								//0 = Chosen direction is traversable, 4 = Chosen direction is blocked by a wall 
                                //These child nodes will be updated if nodes exist in the activePath								
								Up: null,
								Down: null,
								Left: null,
								Right: null,
							}
							
							//Update the child nodes based upon the status of each direction inside the directionsArray
							if (directionsArray[0] == 0) {root.Up = 0;} 
							if (directionsArray[1] == 0) {root.Down = 0;}
							if (directionsArray[2] == 0) {root.Left = 0;}
							if (directionsArray[3] == 0) {root.Right = 0;}
	
							if (directionsArray[0] != 0) {root.Up = 4;} 
							if (directionsArray[1] != 0) {root.Down = 4;}
							if (directionsArray[2] != 0) {root.Left = 4;}
							if (directionsArray[3] != 0) {root.Right = 4;}
							
							//Set the active node to root
							activeNode = root;
							
							//Use the DF search direction modification function to find a traversable direction
							DepthFirstSearchDirectionModification();
							//Set the active path based upon the data from the current direction
							activePath = currentDirection;
						}
						//Check to see if a node exists within the current X and Y axis, then update the activePath accordingly.
						else if ( activeNode.XAxis == XAxis && activeNode.YAxis == YAxis )
						{
							if (activePath == 'up'){activeNode.Up = 4;}
							else if (activePath == 'down'){activeNode.Down = 4;}
							else if (activePath == 'left'){activeNode.Left = 4;}
							else if (activePath == 'right'){activeNode.Right = 4;}
							activePath = currentDirection;
						}
						//If a node does not exist a temporary one is made and added to the tree
						else
						{
							var temporaryNode = {
								parentNode: null,
	
								XAxis: XAxis,
								YAxis: YAxis,

								Up: null,
								Down: null,
								Left: null,
								Right: null,
							}
							//Update the child nodes based upon the status of each direction inside the directionsArray
							if (directionsArray[0] == 0) {temporaryNode.Up = 0;} 
							if (directionsArray[1] == 0) {temporaryNode.Down = 0;}
							if (directionsArray[2] == 0) {temporaryNode.Left = 0;}
							if (directionsArray[3] == 0) {temporaryNode.Right = 0;}
	
							if (directionsArray[0] != 0) {temporaryNode.Up = 4;} 
							if (directionsArray[1] != 0) {temporaryNode.Down = 4;}
							if (directionsArray[2] != 0) {temporaryNode.Left = 4;}
							if (directionsArray[3] != 0) {temporaryNode.Right = 4;}
							
	
							//Set the directional status of the parent node within the temporary node based upon the cubes current direction
							if (currentDirection == 'up'){temporaryNode.parentNode = 'down';}
							if (currentDirection == 'down'){temporaryNode.parentNode = 'up';}
							if (currentDirection == 'left'){temporaryNode.parentNode = 'right';}
							if (currentDirection == 'right'){temporaryNode.parentNode = 'left';}
	
							//Set the temporary node to be a child node of the active node (updating it) 
							// based upon the active path (current direction).
							if (activePath == 'up'){activeNode.Up = temporaryNode;}
							else if (activePath == 'down'){activeNode.Down = temporaryNode;}
							else if (activePath == 'left'){activeNode.Left = temporaryNode;}
							else if (activePath == 'right'){activeNode.Right = temporaryNode;}
							
							//Use the DF search direction modification function to find a traversable direction
							success = DepthFirstSearchDirectionModification();
							//Set the active path based upon the data from the current direction
							activePath = currentDirection;
							
							//Set the temporary node as the new active node and update the front-end with current direction
							activeNode = temporaryNode;
							document.getElementById(\"currentDirection\").innerHTML = \" The current direction is \" + currentDirection;
							
						}
						
					}
					//If a collision occurs do the following.
					else if (collisionStatus == 1) {";
}

echo/** @lang JavaScript */"//Use the standard modify direction function to find a traversable direction	
					    success = modifyDirection();	
						checkPossibleDirections();	
						//If a traversable direction is unable to be found without backtracking, use the next function to go backwards
						if (success == 1){	
							success = modifyDirectionWithBacktracking();	
							checkPossibleDirections();	
						}
}";
if ($AI === "RBS"){
    echo/** @lang JavaScript */"
else if (availableDirections > 2 ){	
			success = modifyDirection();	
}";
}

echo/** @lang JavaScript */"   
					XAxis = newXAxis;	
					YAxis = newYAxis;	
					previousDirection = currentDirection;	
				}</script>";

if ($Embed == 0){
    include("footer.php");
}
