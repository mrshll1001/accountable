
// ==================================================
// Event controllers
// ==================================================

/**
 * Controller for selecting another council on change
 */
$('#council-select').change(function(e)
{
  // Cheeky null check
  if($(this).val() != "NULL")
  {
    // Get the value of the select
    var councilcode = $(this).val();

    // Form the AJAX request for getting the service list
    $.ajax({
      url: '/record/services/'+councilcode,
      method: 'GET',
      success: function(response)
      {
        refreshServices(response);
      },
      error: function(response)
      {
        alert(response.message);
      }
    });
  }
});

/**
 * Controller for selecting another service from the dropdown
 */
 $('#serviceTwoSelect').change(function(e)
 {
   if($(this).val() != "NULL")
   {
     alert("Not a null service");
   }
 });



// ==================================================
// Helper functions
// ==================================================

/**
 * Refresh the inner html of the serviceTwoList
 */
function refreshServices(html)
{
  // Get the services selector and set its inner html
  $('#serviceTwoSelect').html(html);
}
