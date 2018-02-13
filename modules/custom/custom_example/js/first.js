(function ($, Drupal) {
  Drupal.behaviors.custom_example = {
    attach: function (context, settings) {
      var email = drupalSettings.custom_example.name;
      console.log(email);   
      //alert("Hi..");
    }
    
  };
})(jQuery, Drupal);