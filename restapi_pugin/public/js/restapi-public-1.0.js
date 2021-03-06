/**
 * All of the code for public-facing JavaScript source
 * should reside in this file.
 *
 */

 $(document).ready(function (){
   
   var user_id=0;
   
   //datatable
   var table = $('#usergrid').DataTable({
      'columnDefs': [
         { 
            'data': null,
			"autoWidth": true,
            'searchable': true,
            'orderable': true 
         }
      ]
   });
    
   $('#usergrid .dt').on('click', function(){ 
	   user_id=$(this).data('id'); 
      // Show dialog
      $('#modal-edit').modal('show');
   });
   
   // Handle modal shown event
   $('#modal-edit').on('shown.bs.modal', function (e){ 
	   

	$.ajax({
	cache: false,
	type: "GET",
	data: "",
	url: "https://jsonplaceholder.typicode.com/users/"+user_id,
	success:function(data){
	$('#user_details_id').text(data.id);
	$('#user_details_name').text(data.name);
	$('#user_details_email').text(data.email);
	$('#user_details_username').text(data.username);
	$('#user_details_address').text(data.address.street+', '+data.address.city+', '+ data.address.zipcode);
	$('#user_details_phone').text(data.phone);
	$('#user_details_website').text(data.website);
	$('#user_details_cmpnyname').text(data.company.name); 
	} 
	}); 
   
});

});
	
	 
