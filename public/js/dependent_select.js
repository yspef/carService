(function($)
{
    var dependentSelect = function( element, options ) 
    {
        this.options = options;
        this.init();
    };

    // -------------------------------------------------------------------------
    // init the script

    dependentSelect.prototype.init =

    function()
    {
        var self = this;

        $(self.options.selector).on('change', function( event )
                                                {
                                                    self.loadModels( event, self.options );
                                                } );

    };

    // -------------------------------------------------------------------------
    // load the modal data

    dependentSelect.prototype.loadModels =

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
              
              $.each(response.models, function(key, value)
              {
                  console.log(value.id);
                  console.log(value.description);
                  console.log('----');
                    $(options.target).append($("<option></option>").attr("value", value.id).text(value.description));
              });
            //   $(options.target).append(response);
            //   $(options.target).removeAttr('disabled');
          },
        });
    };

    // -------------------------------------------------------------------------

    $.fn.dependentSelect = function(options)
    {
        return( new dependentSelect(this, $.extend({}, $.fn.dependentSelect.defaults, options)));
    }

    $.fn.dependentSelect.defaults = 
    {
        url: 'localhost',
        selector: '#selector',
        target: '#target',
    };    


})(jQuery);
