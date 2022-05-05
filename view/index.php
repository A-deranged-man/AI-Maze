<?php
//This adds information from the header.php file
include("header.php");
?>
<div class="st-xlarge st-text-grey">
    Home Page
</div><br>

<div class="st-row">
    <h4>Hello there!</h4>

    <p>This website is used to showcase a comparison between a Depth-First Search AI and a Rule-Based System AI</p>
    <p>You can also find additional information about me in the website footer, and a detailed comparison of the AI in the report.</p>
    <p>Please note that some code used for the "Maze Game" itself was taken from <a href="https://html5.litten.com/make-a-maze-game-on-an-html5-canvas">html5.litten.com</a> and was then adapted for the needs of this website.</p>


    <iframe width=300 height=400 scrolling=no frameBorder="0" src="maze.php?AI=DFS&Embed=1"></iframe>
    <iframe width=300 height=400 scrolling=no frameBorder="0" src="maze.php?AI=RBS&Embed=1"></iframe>


</div>
<?PHP
//This adds information from the file footer.php
include("footer.php");
?>
