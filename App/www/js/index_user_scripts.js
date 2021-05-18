/*jshint browser:true */
/*global $ */(function()
{
 "use strict";
 /*
   hook up event handlers 
 */
 function register_event_handlers()
 {
    
    
     /* button  #espaco */
    
    
        /* button  Registrar */
    
    
        /* button  .uib_w_16 */
    
    
        /* button  .uib_w_16 */
    $(document).on("click", ".uib_w_16", function(evt)
    {
         /*global activate_subpage */
         return false;
    });
    
        /* button  .uib_w_16 */
    $(document).on("click", ".uib_w_16", function(evt)
    {
        /* your code goes here */ 
         return false;
    });
    
        /* button  #espaco */
    $(document).on("click", "#espaco", function(evt)
    {
        /* your code goes here */ 
         return false;
    });
    
        /* button  Registrar */
    $(document).on("click", ".uib_w_4", function(evt)
    {
        /* your code goes here */ 
         return false;
    });
    
    }
 document.addEventListener("app.Ready", register_event_handlers, false);
})();
