var DynList = {
	_sources: {},
	_initialized: false,
	initialize: function () {
		if (DynList._initialized) {
			return;
		}
		
		for (var source in DynList._sources) {
			var config = DynList._sources[source];
			console.log(config);
			//console.log($('[data-source="' + source + '"]'));
			
			DynList._sources[source].items = [];
			$('[data-source="' + source + '"] [data-id]').each(function () {
				DynList.collapseItem(source, $(this).data('id'));
				$(this).find('[data-expand]').click(function () {
					var source = $(this).closest('[data-source]').data('source');
					var id = $(this).closest('[data-id]').data('id');
					var expanded = $(this).closest('[data-id]').data('expanded');
					
					if (expanded) {
						DynList.collapseItem(source, id);
					} else {
						DynList.expandItem(source, id);
					}
				});
			});
		}
		//console.log(DynList._sources);
		
		DynList._initialized = true;
	},
	collapseItem: function (source, id) {
		var itemElement = $(
			'[data-source="' + source + '"] [data-id="' + id + '"]'
		);
		var button = $('[data-expand]', itemElement);
		var content = $('[data-content]', itemElement);
		
		button.attr('class', button.data('class-collapsed'));
		content.hide();
			
		console.log(itemElement);
		itemElement.data('expanded', false);
	},
	expandItem: function (source, id) {
		var itemElement = $(
			'[data-source="' + source + '"] [data-id="' + id + '"]'
		);
		var button = $('[data-expand]', itemElement);
		var content = $('[data-content]', itemElement);
		
		button.attr('class', button.data('class-expanded'));
		
		DynList.loadContent(source, id);
		
		content.show();
		console.log(content);
		
		itemElement.data('expanded', true);
	},
	loadContent: function (source, id) {
		var itemElement = $(
			'[data-source="' + source + '"] [data-id="' + id + '"]'
		);
		var content = $('[data-content]', itemElement);
		
		$.ajax({
			url: DynList._sources[source].url.replace('[id]', id) + "?dynlist=true",
			cache: false,
			success: function (html) {
				content.html(html);
			},
			datatype: 'html'
		});
	},
	addSource: function (source, url) {
		DynList._sources[source] = {
			source: source,
			url: url,
			items: [],
		};
	}
}
$(function () {
	DynList.initialize();
});