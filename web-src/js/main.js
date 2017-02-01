$(function () {
  $(document).ready(function () {
    /**
     * Datepicker
     */
    $('.datepicker').datepicker({
      dateFormat: "yy-mm-dd"
    });

    /**
     * Additional forms on Item main form
     */
    $('.btn-add-new').on('click', function(e) {
      e.preventDefault();

      var dataForm = $(this).attr('data-form'),
        inputVal = $('input.' + dataForm).val(),
        targetForm = $('form.' + dataForm);

      $('input', targetForm).val(inputVal);
      targetForm.attr('data-form', dataForm);
      targetForm.trigger('submit');
    });

    /* additional forms handle custom submit */
    $('.add-ajax-form').submit(function(e) {
      e.preventDefault();

      var dataForm = $(this).attr('data-form'),
        ajaxParams = {
          type: $(this).attr('method'),
          url: $(this).attr('action'),
          data: $(this).serialize()
        };

      ajaxSubmit(dataForm, ajaxParams);
    });

    /* additional forms ajax submit */
    function ajaxSubmit(dataForm, ajaxParams) {
      var targetSelect = $('select.' + dataForm),
        formGroups = $('.add-form-group');

      //remove previous errors
      formGroups.removeClass('has-error');
      $('.help-block', formGroups).remove();

      $.ajax({
        type: ajaxParams.type,
        url: ajaxParams.url,
        data: ajaxParams.data,
        success: function(result) {
          if ('ok' === result.status) {
            targetSelect.html('');

            $.each(result.data, function(index, item) {
              var option = $('<option value="' +  item.id + '">' + item.name + '</option>');

              if (result.data.length === index + 1) option.attr('selected', true);

              targetSelect.append(option);
            });
          } else if ('error' === result.status) {
            var targetFormGroup = formGroups.filter('.' + dataForm),
              errorsHtml = '';

            targetFormGroup.addClass('has-error');

            $.each(result.data, function(index, item) {
              errorsHtml += '<li><span class="glyphicon glyphicon-exclamation-sign"></span>' + item + '</li>';
            });

            $('input.' + dataForm).next().after('<span class="help-block"><ul class="list-unstyled">' + errorsHtml +
              '</ul></span>');
          }
        }
      });
    }
  });
});