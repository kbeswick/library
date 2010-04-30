dojo.require("dijit.form.TextBox");
dojo.require("dojo.parser");
dojo.require("dojo.data.ItemFileReadStore");
dojo.require("dojox.grid.DataGrid");
dojo.require("dojo.io.script");
dojo.require("dojox.data.AndOrReadStore");

var reservesStore;

function showInstructions(lang)
{
	var oppLang = "english";
	if (lang == "english")
		oppLang = "french";

	var currentState = dojo.style(dojo.byId("instructions_" + lang), "display");
	if (currentState == "none")
	{
		dojo.style(dojo.byId("instructions_" + lang), "display", "inline");
		if (dojo.style(dojo.byId("instructions"), "display") == "none")
			dojo.style(dojo.byId("instructions"), "display", "inline");
		if (dojo.style(dojo.byId("instructions_" + oppLang), "display") == "inline")
			dojo.style(dojo.byId("instructions_" + oppLang), "display", "none");
	}
	else
	{
		dojo.style(dojo.byId("instructions_" + lang), "display", "none");
		if (dojo.style(dojo.byId("instructions_" + oppLang), "display") == "none")
			dojo.style(dojo.byId("instructions"), "display", "none");
	}
            
}
		
function narrowList(letters){
	var filterQuery = '';
	if (letters.constructor.toString().indexOf("Array") == -1) {
		filterQuery += 'instructor: ' + letters;
	}
	else {
		dojo.forEach(letters, function(l) {
			filterQuery += 'course_code: "' + l + '*" OR ';
		});
		filterQuery = filterQuery.substring(0, filterQuery.length - 4);
	}
	grid.filter({ complexQuery: filterQuery });
}

function getReserves(){
	var xhrArgs = {
		url: "reserves.php?mode=get",
		handleAs: "json",
		sync: true,
		preventCache: true,
		load: function(responseObject) {
			reservesStore = new dojox.data.AndOrReadStore({data: responseObject});
		}
	};
	dojo.xhrGet(xhrArgs);
}

getReserves();
var layout =  [{cells:[[
				{field: "course_code", name: "Course Code", width: "50%"},
				{field: "instructor", name: "Instructor", width: "50%"}
				]]}];
		
dojo.addOnLoad(function(){	
	dojo.connect(grid, 'onRowClick', function(e){
		window.open('http://laurentian.concat.ca/opac/extras/feed/bookbag/opac/' + grid.store.getValue(grid.getItem(e.rowIndex),'bookbag_id') +'?skin=lul&searchOrg=OSUL');
	});
	grid.setSortIndex(0, true);
});


