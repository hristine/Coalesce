function add_neighbour(side, id) {
	var postdata = {
		'side': side,
		'id': id,
		'yourId': yourId
	}

	jQuery.post('/Coalesce/Server/network.php', postdata, function(data) {
		poll();
	});
}

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
				} else if (message.indexOf('sys_neighbour_') == 0) {
					var parts = message.split('_');
					console.log(parts);
					
					var fullMessage = '<a href="#" onclick=\'add_neighbour("' + parts[2] + '", "' + parts[3] + '")\'>Add ' + parts[4] + ' to the ' + parts[2] + '</a>';
					jQuery.growl(fullMessage);
				} else {
					jQuery.growl(message);
				}
			}
		}
		
		if (data.left != '') {
			jQuery('#toTheLeft').text( data.everyone[data.left] );
			leftId = data.left;
		}

		if (data.right != '') {
			jQuery('#toTheRight').text( data.everyone[data.right] );
			rightId = data.right;
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

