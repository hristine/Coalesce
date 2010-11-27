// Harmless defaults.
var gridheight = 5;
var gridwidth = 8;


function requestImagery(colour, count, callback, params) {
	var postdata = {
		'method': 'color_search',
		'min_score': 0,
		'max_num_matches': count,
		'colors[0]': colour,
		'url': 'http://piximilar-flickr.hackmtl.tineye.com/rest/'
	};

	jQuery.post('/Coalesce/Server/proxy.php', postdata, function(data) {
		callback(data, params);
	}, 'json');
}

// Fill the whole grid with images.
function gridImageryCallback(data) {
	for (var i = 0; i < data.result.length; i++) {
		jQuery('.cell_' + i).css('background-image', 'url(http://piximilar-flickr.hackmtl.tineye.com/collection/?filepath=' + data.result[i].filepath + ')');
	}
}

function gridImagery(colour) {
	requestImagery(colour, gridheight * gridwidth, gridImageryCallback);
}

// Fill a single column with images.
function columnImageryCallback(data, params) {
	for (var i = 0; i < data.result.length; i++) {
		jQuery('#ref_' + params.column + '_' +  i).css('background-image', 'url(http://piximilar-flickr.hackmtl.tineye.com/collection/?filepath=' + data.result[i].filepath + ')');
		console.log('#ref_' + params.column + '_' +  i);
	}
}

function columnImagery(colour, columnIndex) {
	requestImagery(colour, gridheight, columnImageryCallback, {column: columnIndex});
}

// Layout the grid
function sizeInterface() {
	gridwidth = Math.ceil(jQuery(window).width() / 75);
	jQuery('#rainbox').empty();
	for (var y = 0; y < gridheight; y++) {
		for (var x = 0; x < gridwidth; x++) {
			jQuery('#rainbox').append('<div id="ref_' + x + '_' + y + '" class="cell cell_' + (x + (y*gridwidth)) + ' col_' + x + ' row_' + y + '" style="left: ' + (x * 75) + 'px ; top:' + (y * 75) + 'px;">&nbsp;</div>');
		}
	}
}

function renderSpectra() {
	jQuery('#spectra').empty();
	
	for (var i = 0; i < 360; i += 5) {
		jQuery('#spectra').append('<div style="background-color:' + jQuery.Color([i/360, 0.8, 0.8], 'HSV').toCSS() + '">&nbsp;</div>');
	}
}

// Event handler for changing the current colour.
function changeColour() {
	gridImagery( jQuery.Color(jQuery(this).css('background-color')).toHEX());
}

// Populate with images with the colour I chose at randomish.
jQuery(document).ready(function() {
	sizeInterface();
	renderSpectra();
	gridImagery('#482948');
	
	jQuery('#spectra').delegate('div', 'click', changeColour);
});