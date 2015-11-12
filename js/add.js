  jQuery(document).ready(function() {
      var title = jQuery('#title');
      var link = jQuery('#link');
      var save = jQuery('#save');
      var saved = jQuery('#saved');
      var titleError = jQuery('#titleAlert');
      var linkError = jQuery('#linkAlert');
      var titleVal, linkVal, errorCount;
      titleError.hide();
      linkError.hide();
      saved.hide();
      save.click(function(event){
        event.preventDefault();
          saved.hide();
          errorCount = 0;
          titleVal = title.val();
          linkVal = link.val();

        if(titleVal.length <= 2) {//at least 2 chars
           titleError.show('slow');
           goodToGo = false;
           errorCount ++;
         }else if(titleVal.length >= 2){
           titleError.hide('slow');
           goodToGo = true;
         }

         if(linkVal.length > 1){
              var urlValid = isUrl(linkVal);
         }
         if((urlValid == false && linkVal.length > 1) || linkVal.length < 1) {
             linkError.show('slow');
             goodToGo = false;
             errorCount ++;
         }else if(urlValid == true){
            linkError.hide('slow');
            goodToGo = true;
         }

         if(errorCount == 0){//submit for if there aren't any errors
         jQuery.ajax({
           type: 'POST',
           url:'/ajax/add_ajax.php',
           data: {title: titleVal, link: linkVal} ,
           success: function(result){
               if(result) {
                 if(result == 'success'){
                    title.val('');
                    link.val('');
                    saved.show('slow');
                 }else{
                   alert(result);
                 }
               }else{
                  alert('send fail');
               }
             }
         });
         }
      });
      function isUrl(s) {
         var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
         return regexp.test(s);
     }
   });
