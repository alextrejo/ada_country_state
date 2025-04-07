(function($){
    $('#field-country').on('change',function(e){
      $('#img-loading').toggleClass('hidden');
      var country = $(this).val();
      
      if(country != '')
        $('#field-state').prop('required', true);
      else
        $('#field-state').prop('required', false);
      
      jQuery.get(
          ajaxurl.url,
          {
              'action': 'ada_country_states',
              dataType : "json",
              'data':   country
          },
          function(res){
            $('#field-state').empty();
            len = res.length;
            option = new Option('Select','');
            $('#field-state').append($(option));
            for(i=0; i < len; i++){
              option = new Option(res[i].state, res[i].state);
              $('#field-state').append($(option));
            };

            $('#img-loading').toggleClass('hidden');
          }
      );
    });

})(jQuery);
