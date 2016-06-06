var items = '{"add":[{"add":"1", "to":"2", "equal":"3"},{"add":"2", "to":"4", "equal":"6"},{"add":"3", "to":"6", "equal":"9"},{"add":"4", "to":"3", "equal":"7"},{"add":"5", "to":"0", "equal":"5"}]}';
var item = JSON.parse(items);
var no = 0;
$('#add').val(item.add[no].add);
$('#to').val(item.add[no].to);
$('#check').click(function(){
	if ($('#equal').val() == item.add[no].equal)
	{
		$('#equal').css("background", "green");
		$('.check-popup').notify("Congratulations! You have entered correct answer!",{
			gap: 5,
			elementPosition: 'left center',
			arrowSize: '5',
			autoHide: false,
			className: 'success',
			showAnimation: 'slideDown',
			showDuration: 0
		});
		no = no + 1;
		$('#add').val(item.add[no].add);
		$('#to').val(item.add[no].to);
		$('#equal').val(null);
		$('')
	}
	else
	{
		$('#equal').css("background", "red");
		$('.check-popup').notify("Sorry, It's not correct answer",{
			gap: 5,
			elementPosition: 'left center',
			arrowSize: '5',
			autoHide: false,
			className: 'error',
			showAnimation: 'slideDown',
			showDuration: 0
		});
	}
});
$('#equal').keypress(function(e){
        if(e.which == 13){
            $('#check').click();
        }
    });
