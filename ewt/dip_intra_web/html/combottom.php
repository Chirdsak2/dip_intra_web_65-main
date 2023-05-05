<!-- Optional JavaScript; choose one of the two! -->
	
	<!-- jQuery JavaScript Library v3.5.1 -->
	<script src="assets/js/jquery.js"></script>
	
	<!-- Bootstrap v4.6.1 -->
	<script src="assets/js/bootstrap.js"></script>
	
	<!-- Popper version 1.16.1 -->
	<script src="assets/js/popper.js"></script>
		
	<!-- Font Awesome Free 5.15.4 -->
	<script src="assets/js/all.js"></script>
	
	<!-- FontSize JS -->
	<script src="assets/js/fontsize.js"></script>
	
	<!-- Search header JS -->
	<script src="assets/js/search_header.js"></script>
	
	<script>
		//Get the button
		var mybutton = document.getElementById("myBtn");

		// When the user scrolls down 20px from the top of the document, show the button
		window.onscroll = function() {scrollFunction()};

		function scrollFunction() {
		  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
			mybutton.style.display = "block";
		  } else {
			mybutton.style.display = "none";
		  }
		}

		// When the user clicks on the button, scroll to the top of the document
		function topFunction() {
		  document.body.scrollTop = 0;
		  document.documentElement.scrollTop = 0;
		}
	</script>
		
	</body>
</html>