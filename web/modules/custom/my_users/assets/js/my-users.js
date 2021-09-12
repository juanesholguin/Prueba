jQuery(document).ready(function () {
  // jQuery(':input[type="submit"]').prop('disabled', true);

  jQuery(".register-users").validate({
    rules: {
      name: {
        required: true,
        lettersonly: true
      },
    }
  });

  jQuery.validator.addMethod("lettersonly", function (value, element) {
    return this.optional(element) || /^[a-z]+$/i.test(value);
  }, "Only letters in this field");

  // if(jQuery(".register-users").valid()){
  //   jQuery(':input[type="submit"]').prop('disabled', false);
  // }

  (function($) {
    $.fn.myModal = function() {
      $('#myModal').modal('show');
    };
  })(jQuery);

});
