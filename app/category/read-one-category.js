$(document).ready(function(){
 
    // handle 'read one' button click
    $(document).on('click', '.read-one-category-button', function(){
		
       // get product id
	var id = $(this).attr('data-id');
	// read product record based on given ID
$.getJSON("http://localhost/api/category/read_one.php?id=" + id, function(data){
    // start html
var read_one_category_html=`
 
    <!-- when clicked, it will show the category's list -->

	<div id='show-categories' class='btn btn-primary pull-right m-b-15px show-categories-button'>
        <span class='glyphicon glyphicon-asterisk'></span> Show categories
    </div>	
	<!-- product data will be shown in this table -->
<table class='table table-bordered table-hover'>
 
    <!-- product name -->
    <tr>
        <td class='w-30-pct'>Name</td>
        <td class='w-70-pct'>` + data.name + `</td>
    </tr>
 
   
 
    <!-- product description -->
    <tr>
        <td>Description</td>
        <td>` + data.description + `</td>
    </tr>
 
 
 
</table>`;
// inject html to 'page-content' of our app
$("#page-content").html(read_one_category_html);
 
// chage page title
changePageTitle("Read category");

});
	
    });
 
});