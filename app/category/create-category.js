$(document).ready(function(){
 
    // show html form when 'create product' button was clicked
    $(document).on('click', '.create-category-button', function(){
        // load list of categories

	
	

// we have our html form here where product information will be entered
// we used the 'required' html5 property to prevent empty fields

var create_product_html=`
 
    <!-- 'Show categores' button to show list of categories -->
	<div id='show-categories' class='btn btn-primary pull-right m-b-15px show-categories-button'>
          <span class='glyphicon glyphicon-asterisk'></span> Show categories
    </div>	
	
	<!-- 'create product' html form -->
<form id='create-category-form' action='#' method='post' border='0'>
    <table class='table table-hover table-responsive table-bordered'>
 
        <!-- name field -->
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' class='form-control' required /></td>
        </tr> 
        <!-- description field -->
        <tr>
            <td>Description</td>
            <td><textarea name='description' class='form-control' required></textarea></td>
        </tr>
 
        <!-- categories 'select' field -->

 
        <!-- button to submit form -->
        <tr>
            <td></td>
            <td>
                <button type='submit' class='btn btn-primary'>
                    <span class='glyphicon glyphicon-plus'></span> Create Category
                </button>
            </td>
        </tr>
 
    </table>
</form>`;

// inject html to 'page-content' of our app
$("#page-content").html(create_product_html);
 
// chage page title
changePageTitle("Create Category");
	
 

    });
 
    // will run if create product form was submitted
$(document).on('submit', '#create-category-form', function(){
var form_data=JSON.stringify($(this).serializeObject());

// submit form data to api
$.ajax({
    url: "http://localhost/api/category/create.php",
    type : "POST",
    contentType : 'application/json',
	dataType: "json",
    crossDomain: true,
    data : form_data,
    success : function(result) {
        // category was created, go back to category list        
		showCategoryFirstPage();
    },
    error: function(xhr, resp, text) {
        // show error to console
        console.log(xhr, resp, text);	
    }
});
 
return false;
});
});



