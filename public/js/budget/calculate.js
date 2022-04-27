(function($)
{
    var calculate = function( element, options ) 
    {
        this.options = options;
        this.init();
    };

    // -------------------------------------------------------------------------
    // init the script

    calculate.prototype.init =

    function()
    {
        var self = this;

        $(self.options.selector).on('click', function( event )
                                                {
                                                    self.submitForm( event, self.options );
                                                } );

    };

    // -------------------------------------------------------------------------
    // submit the form

    calculate.prototype.submitForm =

        function() {
            var self = this;
            var form = $('form[name="' + self.options.form + '"]') 

            $.ajax({
                type: "POST",
                url: self.options.url,
                cache: false,
                async: false,
                data: $(form).serialize(),
                error: function(xhr, status, error) {
                    // if( 'Forbidden' == error )
                    // {
                    error = 'Error';
                    // }

                    alert(error);
                    // console.log( xhr );
                    // console.log( status );
                    // console.log( error );
                    // $(self.options.modalError).html( xhr.responseText );
                    // $('#forbidden').css('height', '41vh');
                    // $(self.options.modalError).find('.contact-btn').addClass('d-none');
                    // $(self.options.modalError).find('.img-fluid').css('width', '15%');
                    // $(self.options.modalError).dialog( { modal: true, width: 800 });
                    // $(self.options.modalError).removeClass('d-none');

                    // $('#messaging_mode').clear();
                    // $('#modal_messaging_mode').modal('hide');
                },
                success: function(response) {
                    if (true == response.ok) {
                        $(self.options.target).val(response.value);
                    } else {
                        alert(response.msg);
                    }
                },
            });
        };
    // -------------------------------------------------------------------------

    $.fn.calculate = function(options)
    {
        return( new calculate(this, $.extend({}, $.fn.calculate.defaults, options)));
    }

    $.fn.calculate.defaults = 
    {
        url: 'localhost',
        selector: '#selector',
        target: '#target',
        form: '#form',
    };    


})(jQuery);
