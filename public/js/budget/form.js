$(function()
{
  // setup an add a item
  
  var $addTagitem = $('<a href="#" class="add_tag_item"><i class="far fa-plus-square"></i></a>');
  var $newitemLi = $('<li class="list-group-item"></li>').append($addTagitem);
  

  jQuery(document).ready(function() {

    function addTagFormDeleteitem($tagFormLi) 
    {
      var $removeFormButton = $('<a href="#" class="remove-tag-item align-self-center"><i class="far fa-trash-alt"></i></a>');
      $tagFormLi.children('.item-item').append($removeFormButton);

      $removeFormButton.on('click', function(e) 
      {
          // remove the li for the tag form
          $tagFormLi.remove();
      });
    }
    
  
  
  
    function addTagForm($collectionHolder, $newitemLi) {
      // Get the data-prototype explained earlier
      var prototype = $collectionHolder.data('prototype');

      // get the new index
      var index = $collectionHolder.data('index');

      
      // Replace '$$name$$' in the prototype's HTML to
      // instead be a number based on how many items we have
      var newForm = prototype.replace(/__name__/g, index);

      // increase the index with one for the next item
      $collectionHolder.data('index', index + 1);
      
      // Display the form in the page in an li, before the "Add a tag" item li
      var $newFormLi = $('<li class="list-group-item"></li>').append(newForm);
      
      // also add a remove button, just for this example
      addTagFormDeleteitem($newFormLi);
      
      $newitemLi.before($newFormLi);

  }
  
  

      // Get the ul that holds the collection of item
      var $collectionHolder = $('ul.items');

      // add a delete item to all of the existing tag form li elements
      $collectionHolder.find('li').each(function() 
      {
        addTagFormDeleteitem($(this));
      });
    
      // add the "add a tag" anchor and li to the items ul
      $collectionHolder.append($newitemLi);
  
      
      
      // count the current form inputs we have (e.g. 2), use that as the new
      // index when inserting a new item (e.g. 2)
      $collectionHolder.data('index', $collectionHolder.find(':input').length);
      
      $addTagitem.on('click', function(e) {
          // prevent the item from creating a "#" on the URL
          e.preventDefault();
          
          // add a new tag form (see code block below)
          addTagForm($collectionHolder, $newitemLi);

      });

      var i = $collectionHolder.data('index');

      // -----------------------------------------------------------------------
      // add the first row on load

      if( 0 == i )
      {
        $('.add_tag_item').click();
      }




  });

});
