$(document).on('click','.inline-policy',function(){
   var group_name = $(this).attr('group_name'); 
   var policy_name = $(this).attr('policy_name'); 
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
   $.ajax({
     'url': base_url+'/admin/get-policy-json',
     'method':'POST',
     'data': { '_token':CSRF_TOKEN, 'group_name':group_name, 'policy_name':policy_name },
     'success':function(response){
         $(document).find(".json-code").html(response);
         $(document).find("#policy").modal("show");
     }
   });
    
});
