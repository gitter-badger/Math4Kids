if (!navigator.cookieEnabled)
	{
		window.location.replace("kb/cookies.php");
	}
$('.load_submit').click(function(){
	$(this).attr("value","...");
	$(this).css("animation", "load_bounce");
})
$('.load_').click(function(){
	$(this).css("animation-name", "load_bounce")
});
$('.i4n').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    }
});
