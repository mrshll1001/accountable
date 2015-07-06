
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
 $('.service-selector').change(function(e)
 {
   // Get the values of both service selectors
   var serviceOne = $('#serviceOneSelect').val();
   var serviceTwo = $('#serviceTwoSelect').val();

   // Check if either of them are null
   if(serviceOne != "NULL" && serviceTwo != "NULL")
   {
     // Get the council codes for the call
     var councilOne = $('#council-name').val();
     var councilTwo = $('#council-select').val();

     // Make the JSON data for the AJAX call.
     var data = JSON.stringify({councilOne: councilOne, councilTwo: councilTwo, serviceOne: serviceOne, serviceTwo: serviceTwo});

     // Form the AJAX Request
     $.ajax({
       url: '/record/compare',
       method: 'POST',
       data: data,
       type: 'application/JSON',
       success: function(response)
       {
         refreshComparison(response);
       },
       error: function(response)
       {
         alert(response.responseText);
       }
     });
   }
 });

/**
 * Controller for the information button in the title. SHould show a modal with the content
 */
$('#record-info').click(function(e)
{

  var title = "Where do we get our information?";
  var body = "We get our information from the council services. Silly billy";


  showModal(title, body);
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

/**
 * refresh the inner html of the comparison-container
 */
function refreshComparison(html)
{
  // get the container and refresh the html
  $('#comparison-container').html(html);
}
