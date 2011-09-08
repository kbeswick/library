/*
 * Copyright (C) 2011 Laurentian University
 * Kevin Beswick <kx_beswick@laurentian.ca> 
 *
 * Redistribution and use in source and binary forms, with or without 
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice, 
 *    this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright 
 *    notice, this list of conditions and the following disclaimer in the 
 *    documentation and/or other materials provided with the distribution.
 * 3. The name of the author may not be used to endorse or promote 
 *    products derived from this software without specific prior 
 *    written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS 
 * OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR 
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE AUTHOR BE LIABLE 
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT 
 * OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; 
 * OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF 
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT 
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF 
 * THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF 
 * SUCH DAMAGE.
 */

dojo.require("dijit.form.TextBox");
dojo.require("dojo.parser");
dojo.require("dojo.data.ItemFileReadStore");
dojo.require("dojox.grid.DataGrid");
dojo.require("dojo.io.script");
dojo.require("dojox.data.AndOrReadStore");

var reservesStore;

//The following needs to be configured to your own values:
var HOSTNAME = "http://laurentian.concat.ca";
var SKIN = "lul";
var SEARCH_ORG = "osul";

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
		window.open(HOSTNAME + '/opac/extras/feed/bookbag/opac/' + grid.store.getValue(grid.getItem(e.rowIndex),'bookbag_id') +'?skin='+ SKIN +'&searchOrg=' + SEARCH_ORG);
	});
	grid.setSortIndex(0, true);
});


