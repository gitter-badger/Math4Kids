var taskslist = '{"task":[{"value":"1", "to":"2", "equal":"?", "correct":"1", "field":"equal"},{"value":"2", "to":"4", "equal":"6"},{"value":"3", "to":"6", "equal":"9"},{"value":"4", "to":"3", "equal":"7"},{"value":"5", "to":"0", "equal":"5"}]}';
var task = JSON.parse('{"sign1":"plus", "sign2":"equals", "type":"add", "valuestate":"readonly", "tostate":"readonly", "equalstate":"readonly", "valuemax":"1", "tomax":"1", "equalmax":"1", "taskfullname":"adding to 10", "classname":"1st", "input":"equal"}')
var tasks = JSON.parse(taskslist);
var no = 0;
var currtask = 1;
var tasksno = parseInt(Object.keys(tasks.task).length);

$('#value').val(tasks.task[no].value).prop(task.valuestate, task.valuestate).prop("maxlength", task.valuemax);
$('#to').val(tasks.task[no].to).prop(task.tostate, task.tostate).prop("maxlength", task.tomax);
$('#equal').val(tasks.task[no].equal)
$('#sign-1').addClass("typcn-" + task.sign1);
$('#sign-2').addClass("typcn-" + task.sign2);
$('#equal').prop(task.equalstate, task.equalstate).prop("maxlength", task.equalmax);
$('#check').click(function(){
	if (tasksno <= currtask)
	{
		$('#tasks').fadeOut().fadeIn().html("Congratulations! You have finished "+ task.taskfullname +" in "+ task.classname +" class !");

	}
	else if ($('#' + tasks.task[no].field).val() == tasks.task[no].correct)
	{
		$('#tasks').fadeOut();
		$('.check-popup').notify("Congratulations! You have entered correct answer!",{
			gap: 5,
			elementPosition: 'left top',
			arrowSize: '5',
			autoHide: false,
			className: 'success',
			showDuration: 0,
			hideDuration: 0
		});
		++no;
		++currtask;
		$('#equal').css("background", "white");	
		$('#value').val(tasks.task[no].value);
		$('#to').val(tasks.task[no].to);
		$('#equal').val(null);
		$('#tasks').fadeIn();	
	}
	else
	{
		if ($.isNumeric($('#' + task.input).val()))
		{
			var input = $('#' + task.input).val();
		}
		else
		{
			var input = "letter in that case";	
		}
		$('#equal').css("background", "red");
		$('.check-popup').notify("Sorry, "+ input +" is not correct answer",{
			gap: 5,
			elementPosition: 'left top',
			arrowSize: '5',
			autoHide: false,
			className: 'error',
			showAnimation: 'slideDown',
			showDuration: 0,
			hideDuration: 0
		});
		$('#equal').val(null);
	}
});
$('#equal').keypress(function(e){
        if(e.which == 13){
            $('#check').click();
        }
    });
