//init
//generate uniq seesion id for terminal
var sessionId =  randomString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
var history = new  Array();
var historyShift = 0;

$(function() {
    $("#con").keypress(function(ev) {
        if (ev.which == 13){ //enter
			command = $("#con").val();
			history.push(command);
			historyShift = 0;
			if(history.length>20){
				history.shift();
			}
			if(command=="/clear"){
				$("#log").html("");
				$("#con").val("");
				return;
			}
			$("#con").val("");
			$.post("command.php", {command: command, sessionId: sessionId});
		}
		
    });
	
	$("#con").keydown(function(ev) {
		if (ev.keyCode == 38){ //up arrow
			ev.preventDefault();
			historyShift++;
			if(historyShift > history.length){
				historyShift = history.length;
			}
			prevCommand = history[history.length - historyShift];
			$("#con").val(prevCommand);
		}
		if (ev.keyCode == 40){ //down arrow
			historyShift--;
			if(historyShift<0){
				historyShift = 0;
			}
			if(historyShift==0){
				$("#con").val("");
			}else{
				ev.preventDefault();
				prevCommand = history[history.length - historyShift];
				$("#con").val(prevCommand);
			}
		}
	});
	
    $("#con").focus();
    $("#log").click(function() {
        $("#con").focus();
    });

    longPoll(); //start loop
});

function escapeHtml(t){
	return $('<div/>').text(t).html();
}


function randomString(length, chars) {
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
    return result;
}

function handleServerMessage(data) {
            json = $.parseJSON(data);
        if (json.result == "success") {
            $("#log").append("<br/>");
            str = json.message;
            message = $.parseJSON(str);
            for (line in message.lines) {
				_line = message.lines[line];
                pre = '<pre class="server">'; 
				for (shard in _line.shards){
					_shard = _line.shards[shard];
					span = '<span';
					if(_shard.color){
						span+=' style="color:#'+_shard.color+'"';
					}
					span+= '>'+escapeHtml(_shard.text)+'</span>';
					pre+= span;
				}
                pre+= '</pre>';
                $("#log").append(pre);
            }

            $("#log").scrollTop($("#log")[0].scrollHeight);
        }

}

function longPoll()
{
    $.post('ajax.php', {sessionId: sessionId},function(data)
    {
        handleServerMessage(data);
        longPoll();
    });
}

