console.log('%c   %c   %c   Mat4Kid Taskx 0.1 alpha | Verbose-log | [Seems working... but if U found bug please submit it to us -> bugs@mat4kid.eu :)] ', 'background: #f39c12;','background: #f1c40f','color: #ffffff; background: #2c3e50');
function getUrlParameter(){
	var r = /\d/g;
	var l = document.location.pathname;
	var p = l.match(r);
	return p;
}
var param = getUrlParameter();
var type = "c" + param[0] + "t" + param[1];
$('body').after("")
$(window).load(function(){
		$('div.container').hide().delay(3000).fadeIn();
		setTimeout("$('.loader-bg').hide();", "2990")
});
var url = '/inc/js/pl/';
var prop;
var tasks;
var tasksno;
var error;
$.ajax({
                type: 'GET',
                url: url+type+'-prop.json',
                data: '',
                dataType: 'json',
                success: function(response){
                	prop = response;
                	console.info("AJAX request success: GET json '"+ url + type+"-prop.json'");
                },
               	error: function(response){
               		$('#tasks').append("<div class='alert alert-danger center'>There was a problem while fetching task properties</div>");
               		console.error("Failed AJAX request: GET json '"+ url + type+"-prop.json' | Response code: "+ response.status + " | Error code: mat4kid.request_failed.prop");
               	}
});
$.ajax({
                type: 'GET',
                url: url+type+'.json',
                data: '',
                dataType: 'json',
                success: function(response){
                	tasks = response;
                	tasksno = _.size(tasks.task);
                	ref();
                	console.info("AJAX request success: GET json '"+ url + type+"-prop.json'");
                },
                error: function(response){
               		$('#tasks').append("<div class='alert alert-danger center'>There was a problem while fetching task variants</div>");
               		console.error("Failed AJAX request: GET json '"+ url + type+".json' | Response code: "+ response.status + " | Error code: mat4kid.request_failed.tasks");
               	}

});
var no = 0;
var i = 0;
var currtask = 1;
var nums = new Array();

function rndExc(excl = tasks.task[no].correct)
{
	excl = parseInt(excl);
	a = _.random(parseInt(prop.min), parseInt(prop.max));
	if (a == excl) 
	{
		++a;
	}
	else
	{
	}
	if (a == excl && a <= prop.max && a >= prop.min) 
	{
	}
	else
	{
		a = _.random(parseInt(prop.min), parseInt(prop.max));
	}
	if ($.inArray(a, nums) === -1) a = _.random(parseInt(prop.min), parseInt(prop.max));
	if (a == excl) 
	{
		++a;
	}
	return a;
}
$('body').on('click', 'button.task-button', function(){
        var value = parseInt($(this).html());
	var pressed = parseInt($(this).prop('id'));
		if (value == tasks.task[no].correct)
		{
			console.info("User pressed button #"+pressed+" with value '"+value+"'. It is correct answer ("+tasks.task[no].correct+")!");
		++no;
		++currtask;
		ref();
		}
		else
		{
		console.info("User pressed button #"+pressed+" with value '"+value+"'. It is NOT correct answer! Disabling this button!");
		$('button#' + pressed).addClass("disabled btn-danger").prop("disabled", "disabled");
		}
});
function ref()
{
	nums = [];
	$('#buttons').html(null).html('<div class="col-md-4"></div>');
	if(tasksno < currtask)
		{
		$('#tasks').html("<div class='alert alert-success center'>Congratulations! You have finished "+ prop.taskfullname +" in "+ prop.classname +" class !</div>");
		$('#buttons').hide();
		--currtask;
		--no;
		console.info("User completed all tasks avaialble in class "+param[0]+"!");
	}
	for (i = 0;i < prop.buttons; ++i)
	{	
		nums.push(rndExc());
		$('#buttons').append('<div class="col-md-1 center">\n<button id="'+ i +'" class="task-button btn btn-default" style="padding: 1.2em; width: 100%">'+ nums[i] +'</button>\n</div>\n');
	}
	b = _.random(0, parseInt(prop.buttons) - 1);
	$('button#' + b).html(tasks.task[no].correct).val(tasks.task[no].correct);
	$('#value').val(tasks.task[no].value);
	$('#to').val(tasks.task[no].to);
	$('#equal').val(tasks.task[no].equal);
	$('#sign-1').addClass("typcn-" + prop.sign1);
	$('#sign-2').addClass("typcn-" + prop.sign2);
	$('.task').css({"border": "black 1px solid", "background": "white"});
	$('#' + tasks.task[no].field).css({"border": "red 2px solid", "background": "khaki"}).val("?");
	$('.task-button').removeClass("disabled btn-danger").removeProp("disabled");
}