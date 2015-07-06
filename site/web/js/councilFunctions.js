
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



// ==================================================
// Helper function
// ==================================================
function refreshServices(html)
{
  // Get the services selector and set its inner html
  $('#serviceTwoSelect').html(html);
}
