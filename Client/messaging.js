function poll() {
	var postdata = {
		'yourId': yourId
	};
	jQuery.post('/Coalesce/Server/poll.php', postdata, function(data) {
		if (data.messages) {
			for (var i = 0; i < data.messages.length; i++) {
				jQuery.growl(data.messages[i]);
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