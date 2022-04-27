(function($)
{
    var carSelect = function( element, options ) 
    {
        this.options = options;
        this.init();
    };

    // -------------------------------------------------------------------------
    // init the script

    carSelect.prototype.init =

    function()
    {
        var self = this;

        $(self.options.selector).on('change', function( event )
                                                {
                                                    self.loadCars( event, self.options );
                                                } );

    };

    // -------------------------------------------------------------------------
    // load the modal data

    carSelect.prototype.loadCars =

    function( event, options )
    {
        var url = options.url;
        var data = { 
                        'id': $(options.selector).val(),
                   };

        $.ajax(
        {
          type: "POST",
          url: url,
          cache: false,
          async:false,
          data: data,
          error: function( xhr, status, error )
          {
            alert( error );
            // console.log( xhr );
            // console.log( status );
            // console.log( error );
          },
          success: function(response)
          {
              $(options.target).find('option').remove().end();
              
              $(options.target).append($('<option></option>').attr('value', '').text('-- seleccionar --'));

              $.each(response.cars, function(key, value)
              {
                $(options.target).append($('<option></option>').attr('value', value.id).text(value.patent));
              });
              $(options.target).removeAttr('disabled');
          },
        });
    };

    // -------------------------------------------------------------------------

    $.fn.carSelect = function(options)
    {
        return( new carSelect(this, $.extend({}, $.fn.carSelect.defaults, options)));
    }

    $.fn.carSelect.defaults = 
    {
        url: 'localhost',
        selector: '#selector',
        target: '#target',
    };    


})(jQuery);
