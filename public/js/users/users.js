/*global window, $, jQuery */

$.extend( $.fn.dataTableExt.oStdClasses, {
	"sSortAsc": "header headerSortDown",
	"sSortDesc": "header headerSortUp",
	"sSortable": "header"
} );


$(document).ready(
	function(){
		$('#users-tbl').dataTable(
			{"sDom": "<'row'<'span4'l><'span8'f>r>t<'row'<'span4'i><'span4'p>>"}
		);
});

