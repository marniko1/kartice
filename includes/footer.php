<?php?>
		<?php
        $getElementById = substr(substr($_SERVER['PHP_SELF'], 0, -4), 9);
        echo $getElementById;
        ?></div>
		<div class="footer"></div>
<!-- 		<script>
            function stampaj() {
            	var myWindow = window.open("", "", "width=1000,height=700");
            	var stampaj = document.getElementById("otpremnica").innerHTML;
            	printDivCSS = new String ('<link href="css/stampa.css" rel="stylesheet" type="text/css">')	
                myWindow.document.write(printDivCSS + stampaj);
                myWindow.print();
            }
        </script> -->
        <?php
        $getElementById = substr(substr($_SERVER['PHP_SELF'], 0, -4), 9);
        echo $getElementById;
        ?>
        <script type="text/javascript">
            document.getElementById('<?php echo $getElementById ?>').style.backgroundColor = '#003A7F';
        </script>
	</body>
</html>