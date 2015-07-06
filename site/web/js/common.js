/**
 * Sets the modal titles and body, and shows it
 */
function showModal(title, body)
{
  // Set the modal's title
  $('#modal-title').text(title);

  // Set the modal's body
  $('#modal-body').text(body);

  // Show the modal
  $('#the-modal').modal('show');
}
