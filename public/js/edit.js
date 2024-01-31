

    $('#editmodal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
  var title = button.data('title') 
  var date= button.data('date') 
  var amount = button.data('amount') 

  var modal = $(this)
  modal.find('#id').val(id)
  modal.find('#title').val(title)
  modal.find('#date').val(date)
  modal.find('#amount').val(amount)
  //$("#title").val(id)
// console.log('hello')
})
