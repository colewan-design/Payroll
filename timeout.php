<!-- Auto logout script -->
	<script>
	    var mouseTimer;
	    function resetMouseTimer() {
	        clearTimeout(mouseTimer);
	        mouseTimer = setTimeout(function() {
	            document.cookie = "PHPSESSID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	            window.location.href = "https://cps.bsu-info.tech/login.php?logout=true";
	        }, 600000); // 15 seconds
	    }
	    resetMouseTimer();
	    window.addEventListener('mousemove', resetMouseTimer);
	</script>