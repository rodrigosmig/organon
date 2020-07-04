$(function() {
  $(".delete-task").on('click', function(event) {
    event.preventDefault()
    
    var link = event.currentTarget.href

    swal({
        title: delete_title,
        text: delete_msg,
        icon: 'warning',
        buttons: [button_cancel, button_confirm],
        }).then(function(confirm) {
            if (confirm) {          
            location.href=link
            }
        });
    })

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
  });
})
