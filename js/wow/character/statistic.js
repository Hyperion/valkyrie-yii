var StatisticHandler = {
	linkActiveClass: 			"active",
	cache: {
		searchTerm:				 	"",
		searchTerms:				[],
		timer:					 	null,
		activeCatId:			 	null
	},
			
	/* 
	* Handle "on page load" and eventHandlers
	*/
	init: function () {
		Input.bind('#statistic-search');

		if(location.hash.length > 1 && location.hash.indexOf("summary") == -1) {
			dm.openEntry();
		}
	},

	/* 
	* Allows searching through stats titles
	* @param string term
	*/
	doSearch: function (term, id) {
		sh.cache.searchTerm = term.toLowerCase();
		sh.cache.searchTerms = sh.cache.searchTerm.split(" ");

		$("#search-container").toggleClass("searching", (sh.cache.searchTerm.length > 0));
		
		clearTimeout(sh.cache.timer);

		sh.cache.timer = setTimeout(function () {
			if(!id)
				DynamicMenu.cache.filtering = DynamicMenu.cache.activeCategoryId;

			$("#statistic-list div.group:visible dl").each(function () {
			
			var $listElement = $(this),
				$paragraphNode = $listElement.find("dt:first"),
				nodeValue = $paragraphNode.text().toLowerCase(),
				regex, $titleNode, foundOccurances = 0;
				
				if(!$listElement.data("paragraphNodeReference")) {
					$listElement.data("paragraphNodeReference", $paragraphNode.clone())
				}

				$paragraphNode.html($listElement.data("paragraphNodeReference").html());

				if(sh.cache.searchTerms.length != 0)  {
					for (var i = 0, len = sh.cache.searchTerms.length; i < len; i++) {
						if (sh.cache.searchTerms[i].length > 0) {
							if (nodeValue.indexOf(sh.cache.searchTerms[i]) != -1) {
								$titleNode = $paragraphNode;
								regex = new RegExp("(" + sh.cache.searchTerms[i].replace(" ", "\s") + ")", "gi");
								$titleNode.html($titleNode.html().replace(regex, '<u>$1</u>'));
								
								foundOccurances++;
							}
						} else {
							sh.cache.searchTerms.splice(i, 1)
						}
					}
				}
				
				if((foundOccurances == sh.cache.searchTerms.length) || sh.cache.searchTerms.length == 0) {
					$listElement.show()
				} else {
					$listElement.fadeOut(300)
				}

				foundOccurances	= 0;
			})
		
		}, 300)
	},

	resetSearch: function (id) {
		StatisticHandler.doSearch('', id);
		$('#statistic-search').val("");
		Input.reset('#statistic-search');

	}
};
		
var sh = StatisticHandler;