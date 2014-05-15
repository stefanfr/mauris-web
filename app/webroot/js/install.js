/**
 * This class contains all the methods used by the Mauris installation
 *
 * @type {{}}
 */
var Install = {};
/**
 * A list of all the sources to check for the status
 *
 * @type {Array}
 */
Install.sources = [];
/**
 * Adds sources to the status table
 */
Install.check = function () {
	var table = $('#install-status');
	$('tbody', table).empty();

	var generateRow = function (source) {
		/**
		 * The source row HTML
		 *
		 * @type {string}
		 */
		var html = '<td>' + source.title + '</td>';
		html += '<td><span class="fa fa-question"></span></td>';

		return '<tr>' + html + '<t/r>';
	};

	for (var index in Install.sources) {
		var source = Install.sources[index];

		$('tbody', table).append(generateRow(source));

		Install.updateStatus(index);
	}
};
/**
 * Gets the source's status using AJAX
 *
 * @param index The index of the source
 */
Install.updateStatus = function (index) {
	var table = $('#install-status');

	$.ajax({
		url     : Install.sources[index].url,
		success : function (json) {
			var row = $('tbody tr:eq(' + index + ')', table);
			var status = $('td:eq(1)', row);

			$('span', status).text(json.message);
			$('span', status).removeClass('fa-question fa-check fa-times');
			$('span', status).addClass(json.valid ? 'fa-check' : 'fa-times');

		},
		cache   : false,
		datatype: 'json'
	});
};