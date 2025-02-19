;(function($){
/**
 * jqGrid Icelandic Translation
 * jtm@hi.is Univercity of Iceland
 * Dual licensed under the MIT and GPL licenses:
 * https://www.opensource.org/licenses/mit-license.php
 * https://www.gnu.org/licenses/gpl.html
**/
$.jgrid = {
	defaults : {
		recordtext: "View {0} - {1} of {2}",
	    emptyrecords: "No records to view",
		loadtext: "Hle�ur...",
		pgtext : "Page {0} of {1}"
	},
	search : {
	    caption: "Leita...",
	    Find: "Leita",
	    Reset: "Endursetja",
	    odata : ['equal', 'not equal', 'less', 'less or equal','greater','greater or equal', 'begins with','does not begin with','is in','is not in','ends with','does not end with','contains','does not contain'],
	    groupOps: [	{ op: "AND", text: "all" },	{ op: "OR",  text: "any" }	],
		matchText: " match",
		rulesText: " rules"
	},
	edit : {
	    addCaption: "Add Record",
	    editCaption: "Edit Record",
	    bSubmit: "Vista",
	    bCancel: "H�tta vi�",
		bClose: "Loka",
		saveData: "Data has been changed! Save changes?",
		bYes : "Yes",
		bNo : "No",
		bExit : "Cancel",
	    msg: {
	        required:"Reitur er nau�synlegur",
	        number:"Vinsamlega settu inn t�lu",
	        minValue:"gildi ver�ur a� vera meira en e�a jafnt og ",
	        maxValue:"gildi ver�ur a� vera minna en e�a jafnt og ",
	        email: "er ekki l�glegt email",
	        integer: "Vinsamlega settu inn t�lu",
			date: "Please, enter valid date value",
			url: "is not a valid URL. Prefix required ('https://' or 'https://')",
			nodefined : " is not defined!",
			novalue : " return value is required!",
			customarray : "Custom function should return array!",
			customfcheck : "Custom function should be present in case of custom checking!"
		}
	},
	view : {
	    caption: "View Record",
	    bClose: "Close"
	},
	del : {
	    caption: "Ey�a",
	    msg: "Ey�a v�ldum f�rslum ?",
	    bSubmit: "Ey�a",
	    bCancel: "H�tta vi�"
	},
	nav : {
		edittext: " ",
	    edittitle: "Breyta f�rslu",
		addtext:" ",
	    addtitle: "N� f�rsla",
	    deltext: " ",
	    deltitle: "Ey�a f�rslu",
	    searchtext: " ",
	    searchtitle: "Leita",
	    refreshtext: "",
	    refreshtitle: "Endurhla�a",
	    alertcap: "Vi�v�run",
	    alerttext: "Vinsamlega veldu f�rslu",
		viewtext: "",
		viewtitle: "View selected row"
	},
	col : {
	    caption: "S�na / fela d�lka",
	    bSubmit: "Vista",
	    bCancel: "H�tta vi�"	
	},
	errors : {
		errcap : "Villa",
		nourl : "Vantar sl��",
		norecords: "Engar f�rslur valdar",
	    model : "Length of colNames <> colModel!"
	},
	formatter : {
		integer : {thousandsSeparator: " ", defaultValue: '0'},
		number : {decimalSeparator:".", thousandsSeparator: " ", decimalPlaces: 2, defaultValue: '0.00'},
		currency : {decimalSeparator:".", thousandsSeparator: " ", decimalPlaces: 2, prefix: "", suffix:"", defaultValue: '0.00'},
		date : {
			dayNames:   [
				"Sun", "Mon", "Tue", "Wed", "Thr", "Fri", "Sat",
				"Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
			],
			monthNames: [
				"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
				"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
			],
			AmPm : ["am","pm","AM","PM"],
			S: function (j) {return j < 11 || j > 13 ? ['st', 'nd', 'rd', 'th'][Math.min((j - 1) % 10, 3)] : 'th'},
			srcformat: 'Y-m-d',
			newformat: 'd/m/Y',
			masks : {
	            ISO8601Long:"Y-m-d H:i:s",
	            ISO8601Short:"Y-m-d",
	            ShortDate: "n/j/Y",
	            LongDate: "l, F d, Y",
	            FullDateTime: "l, F d, Y g:i:s A",
	            MonthDay: "F d",
	            ShortTime: "g:i A",
	            LongTime: "g:i:s A",
	            SortableDateTime: "Y-m-d\\TH:i:s",
	            UniversalSortableDateTime: "Y-m-d H:i:sO",
	            YearMonth: "F, Y"
	        },
	        reformatAfterEdit : false
		},
		baseLinkUrl: '',
		showAction: '',
	    target: '',
	    checkbox : {disabled:true},
		idName : 'id'
	}
};
})(jQuery);
