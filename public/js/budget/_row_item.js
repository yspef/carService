$('.remove-tag-item').click(function(e) {
    e.preventDefault();
    
    $(this).parent().remove();
    
    return false;
    
});
