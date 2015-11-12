  jQuery(document).ready(function() {
     var voters = jQuery('.vote');
     if(voters.length > 0){
       voters.each(function(i){
         jQuery(this).click(function(event){
           var thisID = jQuery(this).attr('id');
           //id will have the post id and vote type, '100_up'
           var arrayID = thisID.split('_');
           var post_id = arrayID[0];
           var vote_status = arrayID[1];
           jQuery.ajax({
             type: 'POST',
             url:'/ajax/vote.php',
             data: {post_id: post_id, vote_status: vote_status} ,
             success: function(result){
                 if(result) {
                   if(result != 'fail'){
                      jQuery('#badge_'+post_id).text(result);
                    //  jQuery('#'+post_id+'_up').hide('slow');
                    //  jQuery('#'+post_id+'_down').hide('slow');
                      jQuery('#'+post_id+'_up').hide('slow');
                      jQuery('#'+post_id+'_down').hide('slow');
                      /*
                      jQuery(this).hide('slow');
                      vote_status == 'up' ? var other = 'down' : var other = 'up';
                      jQuery('#'+post_id+'_'+other).hide('slow');
                      */
                   }else{
                     alert(result);
                   }
                 }else{
                    alert('send fail');
                 }
               }
           });
         });//end click
       });//end each
     }
  });
