$(function() {
    $(".collapse").on('show.bs.collapse', function() {
        $(this).parent().parent().prev().find('.expand i').removeClass('fa-caret-down').addClass('fa-caret-right')       
    }).on('hide.bs.collapse', function(){
        $(this).parent().parent().prev().find('.expand i').removeClass('fa-caret-right').addClass('fa-caret-down')       
    });

    $('.select-user-ajax').select2({
      ajax: {
        url: '/user/get-users/',
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            query: params.term,
          };
        },
        processResults: function (data) {
          return {
            results: data
          };
        }
      },
      placeholder: 'Search for a user',
      minimumInputLength: 3,
      templateResult: formatRepo,
      templateSelection: formatRepoSelection,
    });

    function formatRepo (repo) {
      if (repo.loading) {
        return repo.text;
      }

      var url = "";
      if(repo.photo == 'user.png') {
        url += '/img/user.png'
      }
      
      var $container = $(
        "<li class='media'>" +
          "<img class='img-profile rounded-circle' src='" + url + "' width='50px'/></div>" +
          "<div class='media-body'>" +
            "<strong class='user-name'>" + repo.name + "</strong>" +
            "<p>" +
              repo.email +
            "</p>" +
          "</div>" +
        "</li>"
      );

      return $container;
    }
    
    function formatRepoSelection (repo) {
      return repo.name || repo.email;
    }

    $("#modal-add_user").on('hidden.bs.modal', function() {
      $('.select-user-ajax').val("").trigger('change')
    })

    $(".add_member").on('click', function() {
      var id = $(this).attr('data-project')
      $("#project_id").val(id)
    })
})
