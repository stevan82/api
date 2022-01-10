$(document).ready(function(){
 
    // show list of product on first load
   // showCategoryFirstPage();
 
    // when a 'read products' button was clicked
    $(document).on('click', '.show-categories-button', function(){
        showCategoryFirstPage();
    });
 
    // when a 'page' button was clicked
    $(document).on('click', '.pagination li', function(){
        // get json url
        var json_url=$(this).find('a').attr('data-page');
 
        // show list of products
        showProducts(json_url);
    });
 
});
 
function showCategoryFirstPage(){
    var json_url="http://localhost/api/category/read.php";
    showCategory(json_url);
}
 
// function to show list of products
function showCategory(json_url){
	
 
    // get list of products from the API
    $.getJSON(json_url, function(data){
	console.log(data);
        // html for listing products
        readCategoryTemplate(data, "");
 
        // chage page title
        changePageTitle("List of categories");
 
    });
}