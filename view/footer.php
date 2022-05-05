<!-- Footer -->
<br><br>
<footer class="st-padding-64 st-light-grey st-small st-center" id="footer">
    <div class="st-row-padding">
        <div class="st-col s4">
            <h4>Other Links</h4>
            <p><a class="st-text-black" href="https://www.abertay.ac.uk">Abertay University</a> </p>
        </div>

        <div class="st-col s4">
            <h4>About</h4>
            <p><a class="st-text-black" href="about.php">About Me</a></p>
            <p><a class="st-text-black" href="privacy_policy.php">Privacy Policy</a></p>
        </div>

        <div class="st-col s4 st-justify">
            <h4>Contact Me</h4>
            <p><i class="fa fa-fw fa-map-marker"></i> Abertay University</p>
                
            <p><i class="fa fa-fw fa-user"></i> Dylan Baker</p>
            <p><i class="fa fa-fw fa-envelope"></i> 1901368@uad.ac.uk</p>
        </div>
    </div>
</footer>

<div class="st-black st-center st-padding-16"><p>Site design by Dylan Baker.</p> </div>

<!-- End page content -->
</div>


<script>
    // Accordion
    function maze() {
        var x = document.getElementById("maze");
        if (x.className.indexOf("st-show") == -1) {
            x.className += " st-show";
        } else {
            x.className = x.className.replace(" st-show", "");
        }
    }


    // Click on the "Jeans" link on page load to open the accordion for demo purposes
    document.getElementById("myBtn").click();


    // Open and close sidebar
    function js_open() {
        document.getElementById("mySidebar").style.display = "block";
        document.getElementById("myOverlay").style.display = "block";
    }

    function js_close() {
        document.getElementById("mySidebar").style.display = "none";
        document.getElementById("myOverlay").style.display = "none";
    }
</script>

</body>
</html>