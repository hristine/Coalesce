function poll() {
	var postdata = {
		'yourId': yourId
	};
	jQuery.post('/Coalesce/Server/poll.php', postdata, function(data) {
		if (data.messages) {
			for (var i = 0; i < data.messages.length; i++) {
				var message = data.messages[i];
				
				if (message.indexOf('sys_shift_') == 0) {
					var parts = message.split('_');
					eval('colour_' + parts[2] + ' = "' + parts[3] + '"');
					
					changeColour();
				} else {
					jQuery.growl(message);
				}
			}
		}
	}, 'json');
}

function sendUpdate() {
	var postdata = {
		'name': jQuery('#name').val(),
		'colour': colour,
		'yourId': yourId
	}
	
	jQuery.post('/Coalesce/Server/update.php', postdata, function(data) {
		yourId = data;
	});
}